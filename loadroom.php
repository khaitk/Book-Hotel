
<?php  
    include 'session.php';
    
    $id =  $_POST["id"];

    //echo $id;
    if(isset($_POST["action"])){

       $sqlroom = "SELECT rooms.id as id, hotels.name as namehotels, rooms.images1 as images1, rooms.name as nameroom,rooms.status, rooms.price, review.rating as rating , COUNT(review.id) as count, CAST((SUM(review.rating)/COUNT(review.id)) as int) as totalrating 
                FROM rooms INNER JOIN hotels ON rooms.idHotel = hotels.id LEFT JOIN review ON rooms.id = review.idRoom
                WHERE hotels.id = $id ";

        if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
        {

            $sqlroom .= " AND price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."' ";
            

        }
         if(isset($_POST["rating"]))
        {

            $rating_filter = implode("','", $_POST["rating"]);
            $sqlroom .= " AND review.rating IN('".$rating_filter."')";
            
        }
        $sqlroom .= "GROUP BY rooms.id , hotels.name, rooms.images1, rooms.name, rooms.price, rooms.status";
         $queryroom = $conn->query($sqlroom);
                            if($queryroom->num_rows > 0){
                                while ($rowroom = $queryroom->fetch_assoc()) {
                                    echo '
                                    <div class="col-md-12">
                                        <div class="destination">
                                            <a href="rooms.php?idroom='.$rowroom['id'].'" class="img img-2" style="background-image: url(./images/rooms/'.$rowroom['images1'].');"></a>
                                            <div class="text p-3">
                                                <div class="d-flex">
                                                    <div class="one">
                                                        <h3><a href="rooms.php?idroom='.$rowroom['id'].'">'.$rowroom['nameroom'].'</a></h3>

                                                        <p class="rate">';
                                                        if(isset($rowroom['totalrating'])){
                                                          $star = $rowroom['totalrating'];
                                                          $count  = 0;
                                                          for($i = 0; $i < $star; $i++){
                                                              echo '<i class="icon-star"></i>';
                                                              $count = $count + 1;
                                                          }
                                                          $star1 = 5 - $count;
                                                          for($i = 0; $i < $star1; $i++){
                                                              echo '<i class="icon-star-o"></i>';
                                                          }
                                                        }else{
                                                          $star = 5;
                                                          for($i = 0; $i < $star; $i++){
                                                              echo '<i class="icon-star-o"></i>';
                                                          }
                                                        }
                                                          
                                                          echo '
                                                            <span>'.$rowroom['count'].' Rating</span>
                                                        </p>
                                                    </div>
                                                    <div class="two">
                                                        <span class="price per-price">'.number_format($rowroom['price']).'đ<br><small>/night</small></span>
                                                    </div>
                                                </div>
                                                <hr>
                                                <p class="bottom-area d-flex">
                                                ';
                                                  if($rowroom['status']=='NO'){
                                                    echo '<span class="ml-auto"><a href="rooms.php?idroom='.$rowroom['id'].'" class="btn btn-success">Phòng chưa đặt</a></span>';
                                                  }else{
                                                    echo '<span class="ml-auto"><button type="" class="btn btn-danger">Phòng đã đặt</button></span>';
                                                  }
                                                  echo'
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    ';
                                }
                            }else{
             echo '
                <div class="alert alert-danger" role="alert">
                    Hiện tại không có phòng
                </div>
             
             ';
        }
    }
 ?>  
