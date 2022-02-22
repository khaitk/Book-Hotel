<?php  
    include 'session.php';
    if(isset($_POST["action"])){

      $sqlhotels = "SELECT hotels.id, hotels.name, hotels.starLevel, hotels.address, hotels.images1, COUNT(rooms.id) as countroom
              FROM hotels LEFT JOIN rooms ON hotels.id = rooms.idHotel
              ";

        if(isset($_POST["hotels"]))
        {

            $hotels_filter = implode("','", $_POST["hotels"]);
            $sqlhotels .= " WHERE hotels.starLevel IN('".$hotels_filter."')";
            
        }
        $sqlhotels .= "GROUP BY hotels.name, hotels.starLevel, hotels.address, hotels.images1 LIMIT 6";
        $query = $conn->query($sqlhotels);
                    if($query->num_rows > 0){
                        while($row =  $query->fetch_assoc()){
                          echo '
              <div class="col-sm-6 col-md-6 col-lg-4">
                  <div class="destination">
                    <a href="hotelsdetail.php?id='.$row['id'].'" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(./images/hotels/'.$row['images1'].');">
                      <div class="icon d-flex justify-content-center align-items-center">
                        <span class="icon-link"></span>
                      </div>
                    </a>
                    <div class="text p-3">
                      <div class="d-flex">
                        <div class="one">
                          <h3><a href="hotelsdetail.php?id='.$row['id'].'">'.$row['name'].'</a></h3>
                          <p class="rate">';

                            $star = $row['starLevel'];
                                              $count  = 0;
                                              for($i = 0; $i < $star; $i++){
                                                  echo '<i class="icon-star"></i>';
                                                  $count = $count + 1;
                                              }
                                              $star1 = 5 - $count;
                                              for($i = 0; $i < $star1; $i++){
                                                  echo '<i class="icon-star-o"></i>';
                                              }
                                              $id = $row['id'];
                                              $sql0 = "select count(*) as count from rooms where status = 'NO' and idHotel = $id";
                                              $query0 = $conn->query($sql0);
                                              $row0 = mysqli_fetch_array($query0);
                          echo '
                          </p>
                        </div>
                      </div>';
                      if($row0['count'] > 0){
                        echo '<p>Còn '.$row0['count'].' Phòng</p>';
                      }else{
                        echo '<p>Hết Phòng</p>';
                      }
                      
                      echo '
                      <hr>
                      <p class="bottom-area d-flex">
                        <span><i class="icon-map-o"> '.$row['address'].'</i></span> 
                      </p>
                      <p class="bottom-area d-flex">
                        <span><a href="hotelsdetail.php?id='.$row['id'].'">XEM CHI TIẾT</a></span>
                      </p>
                    </div>
                  </div>
                </div>
                          ';
                        }
                    }else{
             echo '
             <div class="col-sm-12">
                <div class="alert alert-danger" role="alert">
                    Hiện tại không có phòng
                </div>
             </div>
             ';
        }
    }
 ?>  
