<?php 
    include 'session.php';
    $sqluser = "select * from users where gmail = '$gmail'";
    $queryuser = $conn->query($sqluser);
    $rowuser = mysqli_fetch_array($queryuser, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>HOTEL</title>
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
</head>

<body>
    <!-- Page Preloder -->
    <?php include 'templates/navbar.php' ?>

    <?php include 'templates/header.php' ?>

    <section class="room-section" style="padding-top: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row justify-content-center">
                        <div class="col-sm-6 rounded-lg" >
                            <h3 class="bg-success text-center text-white">Phòng đang đặt</h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12">
                    <div class="row">
                         <?php

                        $id = $rowuser['id'] ;
                        $sqlbook = "select rooms.id as idrooms, bills.id as idbills , bookings.id as idbookings , rooms.name as nameRoom, hotels.name as nameHotel, startDate, endDate, bills.billstatus as billstatus, totalPrice
                        from bookings, rooms, hotels, bills
                        where rooms.id = bookings.idRoom 
                        and rooms.idHotel = hotels.id 
                        and bookings.id = bills.idBooking
                        and idUser = $id";
                        $querybook = $conn->query($sqlbook);

                        $book = array();
                        if($querybook->num_rows > 0){
                             while($row = $querybook->fetch_assoc()){
                                $getDate = strtotime(date('Y-m-d'));
                               //$endDate = $row['endDate'];
                                $startDate = $row['startDate'];
                                //echo date('Y-m-d');
                                $startDate = strtotime($startDate) ;
                                                        
                                $days = floor(($startDate - $getDate) / 86400);
                                
                            ?>
                            <?php 
                                if($days > 0 && $row['billstatus'] == 'NO'){
                            ?>
                                <div class="col-3 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-8 text-left">
                                                    <h4 class="card-title"><?php echo $row['nameRoom'] ?></h4>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="fa fa-hotel f-28"></i>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row align-items-center">
                                                <div class="col-12">
                                                    <h6 class="card-subtitle mb-2 text-muted">Start : <?php echo $row['startDate'] ?></h6>
                                                    <h6 class="card-subtitle mb-2 text-muted">End  : <?php echo $row['endDate'] ?></h6>
                                                    <h6 class="card-subtitle mb-2 text-muted">Giá  : <?php echo number_format($row['totalPrice']).' đ'?></h6>
                                                </div>
                                            </div>
                                        </div>
                                            
                                            <div class="card-footer text-muted bg-success">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6 class="card-title text-white"><?php echo $row['nameHotel'] ?></h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-5">
                                                        <b><a href="deletebookings.php?idbills=<?php echo $row['idbills'].'&idbookings='.$row['idbookings'].'&idrooms='.$row['idrooms'] ?>" class="btn btn-danger">Huỷ</a></b>
                                                   </div>
                                                   <div class="col-6">
                                                        <b><a href="chitiethoadon.php?idbills=<?php echo $row['idbills'].'&idbookings='.$row['idbookings'].'&idrooms='.$row['idrooms'] ?>" class="btn btn-primary">Xem chi tiết</a></b>
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
                            }else{
                                echo 'Bạn chưa đặt phòng.';
                                echo '<br>';
                                echo '<a href="index.php">Đến nơi đặt phòng.</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-top: 15px">
                <div class="col-sm-12">
                    <div class="row justify-content-center">
                        <div class="col-sm-6 rounded-lg" >
                            <h3 class="bg-danger text-center text-white">Phòng đã đặt</h3>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                    <?php
                    $num_per_page = 04;
                                              if (isset($_GET['page'])) {
                                            $page = $_GET['page'];
                                        }else{
                                            $page = 1;
                                        }

                                        $start_from = ($page - 1) * 04;
                        $id = $rowuser['id'] ;
                        $sqlbook = "select rooms.id as id, bookings.id as idbookings, rooms.name as nameRoom, hotels.name as nameHotel, startDate, endDate, bills.billstatus as billstatus, totalPrice
                        from bookings, rooms, hotels, bills
                        where rooms.id = bookings.idRoom 
                        and rooms.idHotel = hotels.id 
                        and bookings.id = bills.idBooking
                        and idUser = $id LIMIT $start_from, $num_per_page";
                        $querybook = $conn->query($sqlbook);

                        //$rowbook = mysqli_fetch_array($querybook, MYSQLI_ASSOC);
                        //echo $rowbook['count'];
                        
                        $book = array();
                        if($querybook->num_rows > 0){
                             while($row = $querybook->fetch_assoc()){
                                $getDate = strtotime(date('Y-m-d'));
                               //$endDate = $row['endDate'];
                                $startDate = $row['startDate'];
                                //echo date('Y-m-d');
                                $startDate = strtotime($startDate) ;
                                                        
                                $days = floor(($startDate - $getDate) / 86400);
                                //echo $days;
                            ?>
                            <?php 
                                                if($row['billstatus'] == 'YES'){
                                            ?>
                                <div class="col-4 mt-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-8 text-left">
                                                    <h4 class="card-title"><?php echo $row['nameRoom'] ?></h4>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <i class="fa fa-hotel f-28"></i>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row align-items-center">
                                                <div class="col-12">
                                                    <h6 class="card-subtitle mb-2 text-muted">Ngày bắt đầu: <?php echo $row['startDate'] ?></h6>
                                                    <h6 class="card-subtitle mb-2 text-muted">Ngày kết thúc: <?php echo $row['endDate'] ?></h6>
                                                    <h6 class="card-subtitle mb-2 text-muted">Giá  : <?php echo number_format($row['totalPrice']).' đ'?></h6>
                                                </div>
                                            </div>
                                        </div>
                                            
                                            <div class="card-footer text-muted bg-info">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h6 class="card-title text-white"><?php echo $row['nameHotel'] ?></h6>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-5">
                                                           <b><a href="rooms.php?idroom=<?php echo $row['id'] ?>" class="btn btn-success">Đặt lại</a></b>
                                                        </div>
                                                        <div class="col-6">
                                                            <b><a href="chitiethoadon.php?idbills=<?php echo $row['idbills'].'&idbookings='.$row['idbookings'].'&idrooms='.$row['id'] ?>" class="btn btn-primary">Xem chi tiết</a></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                    </div>
                                </div>
                            
                                    
                            <?php
                        }
                                 }
                                
                            }


                            else{
                                echo 'Bạn chưa đặt phòng.';
                                echo '<br>';
                                echo '<a href="index.php">Đến nơi đặt phòng.</a>';
                            }
                        ?>
                </div>
                <?php
                 $sqlcount = "select count(*) as count, rooms.id as id, bookings.id as idbookings, rooms.name as nameRoom, hotels.name as nameHotel, startDate, endDate, bills.billstatus as billstatus, totalPrice from bookings, rooms, hotels, bills where rooms.id = bookings.idRoom and rooms.idHotel = hotels.id and bookings.id = bills.idBooking and idUser = $id GROUP by bills.billstatus";
                                        $querycount = mysqli_query($conn, $sqlcount);
                                        $rowcount = mysqli_fetch_array($querycount);
                                        
                                        $totalrecord = $rowcount['count'];
                                        $totalpages = ceil($totalrecord/$num_per_page);
                                        echo '<br><div class="row"><div class="col-sm-6 justify-content-center"> ';
                                        for ($i=1; $i <= $totalpages; $i++) { 
                                            echo '<a href="?page='.$i.'" class="btn btn-success mr-1">'.$i.'</a>';
                                        }
                                        echo '</div></div>';
                                        ?>
                </div>
                
                    
           </div>
        </div>
    </section>
    <br><br>

    <?php include 'templates/footer.php' ?>

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
</body>

</html>