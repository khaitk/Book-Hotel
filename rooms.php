<?php
    include 'session.php';
    //echo $_SESSION['gmail'];
    

    $sqluser = "select * from users where gmail = '$gmail'";
    $queryuser = $conn->query($sqluser);
    $rowuser = mysqli_fetch_array($queryuser, MYSQLI_ASSOC);

    $iduser = $rowuser['id'];
    $gmailuser = $rowuser['gmail'];
    $gmailsession = $_SESSION['gmail'];

    $idRoom = $_GET['idroom'];
    //$idhotel = $_GET['idhotel'];
    
    $sql = mysqli_query($conn, "select rooms.id as id, rooms.name, price, type, status, rooms.description, rooms.images1, rooms.images2, rooms.images3, CAST((SUM(review.rating)/COUNT(review.id)) as int) as totalrating  from rooms, review
where rooms.id = review.idRoom and rooms.id = '$idRoom'");

    $row  = mysqli_fetch_array($sql, MYSQLI_ASSOC);

    date_default_timezone_set("Asia/Ho_Chi_Minh");

    $sqlrating = "SELECT count(*) as count from rooms, users, review 
    WHERE rooms.id = review.idRoom AND users.id = review.idUser and rooms.id = $idRoom";
    $queryrating = $conn->query($sqlrating);
    $rowcount = mysqli_fetch_array($queryrating);
    
    $msg = "";
    //$daytime = date("Y-m-d H:i:s");

    if(isset($_POST['submit'])){
        if(!isset($_SESSION['gmail'])){
            header("location: login.php");
        }elseif($rowuser['phone'] == '' || $rowuser['idCardNumber'] == '' || $rowuser['idCardType'] == '' || $rowuser['address'] == '' || $rowuser['phone'] == ''){
            header("location: profile.php");
        }
        else{
            $start = $_POST['start'];
            $end = $_POST['end'];
    
            $startday = date('Y-m-d', strtotime($start));
            $endday = date('Y-m-d', strtotime($end));
    
            $price = $_POST['price'];
            $total = $_POST['total'];
            $hinhthuc = $_POST['hinhthuc'];
            //$startday = $_POST['startday'];
    
            $sql0 = "select id from bookings";
            $query0 = mysqli_query($conn, $sql0);
            if(mysqli_num_rows($query0) == 0){
                $idbooking = 1;
            }elseif(mysqli_num_rows($query0) > 0){
                $sql1 = "select MAX(id) as id from bookings";
                $query1 = mysqli_query($conn, $sql1);
                $row = mysqli_fetch_array($query1);
                $idbooking = $row['id'];
                $idbooking = $idbooking + 1;
    
            }
    
            $sqlbookings = "INSERT INTO `bookings`(`id`, `idRoom`, `idUser`, `startDate`, `endDate`, `price`) VALUES ('$idbooking', '$idRoom','$iduser','$startday','$endday','$price')";
    
            if($conn->query($sqlbookings )){
                $sqlstatus = "UPDATE `rooms` SET `status`='YES' WHERE id = '$idRoom' ";
                if($conn->query($sqlstatus) == TRUE){
                    $sqlbill = "select id from bills";
                    $querybill = mysqli_query($conn, $sql0);
                    if(mysqli_num_rows($querybill) == 0){
                        $idbills = 1;
                    }elseif(mysqli_num_rows($querybill) > 0){
                        $sqlbill1 = "select MAX(id) as id from bills";
                        $querybill1 = mysqli_query($conn, $sqlbill1);
                        $row = mysqli_fetch_array($querybill1);
                        $idbills = $row['id'];
                        $idbills = $idbills + 1;
            
                    }
                    $sqlbills = "INSERT INTO `bills`(`id`, `idBooking`, `totalPrice`, `papaymentType`, `billstatus`) VALUES ('$idbills' ,'$idbooking', '$total','$hinhthuc', 'NO')";
                    if($conn->query($sqlbills) == TRUE){
                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                        //$msg = '<div class="alert alert-success" role="alert">Đặt phòng thành công !</div>';
                    }else{
                        echo "Error: " . $sqlbills . "<br>" . $conn->error;
                    }
                }else{
                    echo "Error: " . $sqlstatus . "<br>" . $conn->error;
                }
            }else{
                echo "Error: " . $sqlbookings . "<br>" . $conn->error;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>BOOK HOTEL</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/css.css">
    <style>
        .card{
            padding: 0;
        }
        

    </style>
        <style>
        @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
        
        h1{font-size:1.5em;margin:10px;}
        
        #rating{border:none;float:left;}
        #rating>input{display:none;}
        #rating>label:before{margin:5px;font-size:2.25em;font-family:FontAwesome;display:inline-block;content:"\f005";}
        #rating>.half:before{content:"\f089";position:absolute;}
        #rating>label{color:#ddd;float:right;}
        
        #rating>input:checked~label,
        #rating:not(:checked)>label:hover, 
        #rating:not(:checked)>label:hover~label{color:#FFD700;}
        
        #rating>input:checked+label:hover,
        #rating>input:checked~label:hover,
        #rating>label:hover~input:checked~label,
        #rating>input:checked~label:hover~label{color:#FFED85;}
    </style>

  </head>
  <body>
    
     <?php include 'templates/navbar.php'; ?>
    
     <?php include 'templates/header.php'; ?>
        
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php echo $msg ?>
                </div>
                <div class="col-lg-5 sidebar card">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="./images/rooms/<?php echo $row['images1'] ?>" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="./images/rooms/<?php echo $row['images2'] ?>" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="./images/rooms/<?php echo $row['images3'] ?>" alt="Third slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <b><h3 class="text-center"><?php echo $row['name'] ?></h3></b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table ">
                                <tr>
                                    <th>Giá :</th>
                                    <td> <?php echo number_format($row['price']) ?> đ</td>
                                </tr>
                                <tr>
                                    <th>Hạng : </th>
                                    <td>
                                        <?php
                                            if(isset($row['totalrating'])){
                                                $star = $row['totalrating'];
                                                $count  = 0;
                                                for($i = 0; $i < $star; $i++){
                                                    echo '<i class="fa fa-star text-warning" aria-hidden="true"></i>';
                                                    $count = $count + 1;
                                                }
                                                $star1 = 5 - $count;
                                                for($i = 0; $i < $star1; $i++){
                                                    echo '<i class="fa fa-star" aria-hidden="true"></i>';
                                                }
                                            }else{
                                                $star = 5;
                                                $count  = 0;
                                                for($i = 0; $i < $star; $i++){
                                                    echo '<i class="fa fa-star text-warning" aria-hidden="true"></i>';
                                                    $count = $count + 1;
                                                }
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Loại : </th>
                                    <td> <?php echo $row['type'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ml-5">
                    <div class="row">
                          <form action="" method="post">
                                        <div class="col-sm-12">
                                            <div class="card p-2">
                                                <div class="card-header">
                                                    <h4 class="text-center">Booking</h4>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">Start Day</label>
                                                            <input class="form-control" id="StartDate" name="start" placeholder="MM/DD/YY" readonly type="text"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="">End Day</label>
                                                            <input class="form-control" id="EndDate" name="end" placeholder="MM/DD/YY" readonly type="text"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Price</label>
                                                        <input type="number" readonly class="form-control" name="price" id="price" value="<?php echo $row['price']  ?>" aria-describedby="helpId" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="">Days</label>
                                                            <input type="number" readonly class="form-control" name="days" id="days" value="0" aria-describedby="helpId" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Total (Price * Days)</label>
                                                    <input type="number" readonly class="form-control" name="total" id="total" value="" aria-describedby="helpId" placeholder="">
                                                </div>
                                                <!-- <div class="form-group">
                                                    <label for="">Description</label> <br>
                                                    <textarea name="description" id="" cols="55" rows="5" placeholder=""></textarea>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="col-lg-12 pt-2">
                                            <div class="card p-2">
                                                <div class="card-header">
                                                    <h4>Hình thức thanh toán</h4>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hinhthuc" id="radio1" value="Thanh toán khi nhận phòng" checked>
                                                    <label class="form-check-label" for="">
                                                        Thanh toán khi nhận phòng
                                                    </label>
                                                </div>
                                            </div>
                                            <?php
                                                if($row['status'] == 'NO'){
                                                    echo '<button type="submit" name="submit" class="btn btn-success mt-2" id="check">BOOK</button>';
                                                }else{
                                                    echo '
                                                    <button type="button" class="btn btn-danger mt-2" data-toggle="modal" data-target="#myModal">
                                                        BOOK
                                                    </button>

                                                    <div class="modal" id="myModal">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Thông báo</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <div class="modal-body">
                                                                Hiện tại phòng đã có người đặt
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            </div>
                                                            
                                                          </div>
                                                        </div>
                                                      </div>
                                                    ';
                                                }
                                            ?>
                                            
                                        </div>
                                    </form>     
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 40px">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Mô tả</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Đánh giá(<?php echo $rowcount['count']; ?>)</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent" style="width: 100%; ">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="table-responsive">
                            <?php echo $row['description'] ?>
                        </div>
                    </div>
                
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="media mt-3 mb-4">
                            <div class="media-body">
                                <?php 
                                    $sqlrating = "SELECT review.id as id, users.name as name, gmail, rating, review.description as description, datetime from rooms, users, review 
                                    WHERE rooms.id = review.idRoom AND users.id = review.idUser and rooms.id = $idRoom";
                                    $queryrating = $conn->query($sqlrating);

                                    if($queryrating->num_rows > 0){
                                        while($rowrating = $queryrating->fetch_assoc()){
                                ?>
                                    <div class="ratings">
                                       <div class="d-sm-flex justify-content-between">
                                           <p class="mt-1 mb-2">
                                               <strong><?php echo $rowrating['name'] ?></strong>
                                               <span>– </span><span><?php echo $rowrating['datetime'] ?></span>
                                           </p>
                                           <ul class="rating mb-sm-0">
                                            <?php
                                                $star = $rowrating['rating'];
                                                $count  = 0;
                                                for($i = 0; $i < $star; $i++){
                                                    echo '<i class="fa fa-star fa-2x text-warning"></i>';
                                                    $count = $count + 1;
                                                }
                                                $star1 = 5 - $count;
                                                for($i = 0; $i < $star1; $i++){
                                                    echo '<i class="fa fa-star fa-2x text-muted"></i>';
                                                }
                                            ?>
                                           </ul>
                                       </div>
                                       <p class="mb-0"><?php echo $rowrating['description'] ?></p>
                                       </div>
                                   <br>
                                   <?php 
                                   if($rowrating['gmail'] == $gmailsession){
                                    ?>
                                        <div class="hover">
                                            <nav class="navbar navbar-expand-lg navbar-light">
                                                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                                                    <div class="navbar-nav">
                                                      <a class="nav-item nav-link" href="#" data-toggle="modal" data-target="#exampleModal">Chỉnh sửa</a>
                                                      <a class="nav-item nav-link" href="deleterate.php?id=<?php echo $rowrating['id'] ?>">Xoá</a>
                                                    </div>
                                                  </div>
                                            </nav>
                                        </div>
                                          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Sửa đánh giá</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <form action="updaterate.php?id=<?php echo $rowrating['id'] ?>" method="POST">
                                                        <div class="my-3">
                                                            <div id="rating">
                                                                <div id="rating">
                                                                    <input type="radio" id="star5" name="rating" value="5" />
                                                                    <label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                                
                                                                    <input type="radio" id="star4" name="rating" value="4" />
                                                                    <label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                                
                                                                    <input type="radio" id="star3" name="rating" value="3" />
                                                                    <label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                                
                                                                    <input type="radio" id="star2" name="rating" value="2" />
                                                                    <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                                
                                                                    <input type="radio" id="star1" name="rating" value="1" />
                                                                    <label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <div class="md-form md-outline">
                                                            <label for="form76">Đánh giá : </label>
                                                            <textarea id="form76" name="description" class="md-textarea form-control pr-6" rows="4" placeholder="Viết cảm nghĩ của bạn..."><?php echo $rowrating['description']  ?></textarea>
                                                        </div>
                                                        <br>
                                                        <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                    </form>
                                                  </div>
                                                  
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    <?php
                                   }
                                    ?>
                                   
                            
                            <?php
                                    }
                                }
                            ?>
                            </div>
                           
                        </div>
                        
                        
                            <?php
                                //if(isset($_SESSION['gmail'])){
                                    echo ' <hr> 
                                    <h5 class="mt-4">Hãy cho tôi đánh giá</h5>
                                        <p>Thông tin của bạn sẽ được công khai ở đây</p>
                                        <form action="review.php?id='.$idRoom.'" method="post">
                                            <div class="my-3">
                                                <div id="rating">
                                                    <input type="radio" id="star5" name="rating" value="5" />
                                                    <label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                
                                                    <input type="radio" id="star4" name="rating" value="4" />
                                                    <label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                
                                                    <input type="radio" id="star3" name="rating" value="3" />
                                                    <label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                
                                                    <input type="radio" id="star2" name="rating" value="2" />
                                                    <label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                
                                                    <input type="radio" id="star1" name="rating" value="1" />
                                                    <label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <br>
                                            <div class="md-form md-outline">
                                                <label for="form76">Đánh giá : </label>
                                                <textarea id="form76" name="description" class="md-textarea form-control pr-6" rows="4" placeholder="Viết cảm nghĩ của bạn..."></textarea>
                                            </div>
                                            <br>
                                            
                                            <div class="pb-2">
                                                <button type="submit" name="submit" class="btn btn-primary">Đăng</button>
                                            </div>
                                        </form>';
                                //}
                            ?>
  </div>


        </div>
    </section> <!-- .section -->


<?php include 'templates/footer.php'; ?>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    <script>
        $(document).ready(function(){
            $('#StartDate, #EndDate').datepicker({
                dateFormat: 'dd/mm/yy',
                startDate: "dd/mm/yy",
                endDate: "+70d",
                changeMonth: true,
                changeYear: true,
            })

            $('#StartDate').datepicker({ dateFormat: 'dd-mm-yy' });
            $('#EndDate').datepicker({ dateFormat: 'dd-mm-yy' });

            $('#EndDate').change(function(){
                var startDate = $('#StartDate').datepicker('getDate');
                var endDate = $('#EndDate').datepicker('getDate');
                

                if(startDate < endDate){
                    var price =  $('#price').val();
                    var totals = (endDate-startDate)/1000/60/60/24;
                    $('#total').val(totals * price);
                    $('#days').val(totals);
                    //console.log(totals + '*' + price + '='+ totals * price);
                }else{
                    alert('Không được bé hơn ngày bắt đầu');
                    $('#StartDate').val("");
                    $('#EndDate').val("");
                }
            })


            $("#check").click(function (){
                var startDate = $('#StartDate').val();
                var endDate = $('#EndDate').val();
                if(startDate < endDate){
                    return true;
                }else{
                    alert('Không được bé hơn ngày bắt đầu');
                    $('#StartDate').val("");
                    $('#EndDate').val("");
                    return false;
                }

            });
        })
    </script>
  </body>
</html>