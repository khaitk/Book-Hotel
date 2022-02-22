<?php 
    include 'session.php';


    $sqluser = "select * from users where gmail = '$gmail'";
    $queryuser = $conn->query($sqluser);
    $rowuser = mysqli_fetch_array($queryuser, MYSQLI_ASSOC);

    $id = $rowuser['id'];
    $idbooking = $_GET['idbookings'];
    $idbill = $_GET['idbills'];
    $idrooms = $_GET['idrooms'];

     $sql = "select users.name as nameuser, users.image as image, hotels.name as namehotels, rooms.name as nameroom, rooms.price as price, users.phone as phone,
      bookings.startDate as startDate , bookings.endDate as endDate, bills.totalPrice as totalPrice
      from users, bookings, rooms, hotels, bills where bookings.idRoom = rooms.id
      and bookings.idUser = users.id and rooms.idHotel = hotels.id and bookings.id = bills.idBooking and bookings.id = $idbooking";
      $query = $conn->query($sql);
      $row = mysqli_fetch_array($query);
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
                            <h3 class="bg-success text-center text-white">Chi tiết hoá đơn</h3>
                        </div>
                    </div>
                    <br>
                    <div class="row justify-content-center">
                        <div class="col-sm-9 rounded-lg" >
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="./images/users/<?php echo $row['image'] ?>" alt="<?php echo $row['nameuser'] ?>" width="200px">
                                </div>
                                <div class="col-sm-9">
                                    <table class="table">
                                        <tr>
                                            <td ><h6>Bookings Hotel</h6></td>
                                            <td ><h6>Ngày : <?php echo $row['startDate'];?></h6></td>
                                          </tr>
                                          <tr>
                                            <td  class="text-center"><h3>Hoá Đơn</h3></td>
                                            <td>
                                              <?php
                                                  echo '<img class="barcode" alt="'.$row['nameuser'].'" src="barcode.php?text='.$row['phone'].'&codetype=code128&orientation=horizontal&size=20&print=true"/> ';
                                              ?>
                                             </td>
                                          </tr>

                                          <tr>
                                            <td>Họ Tên : </td>
                                            <td><?php echo $row['nameuser'] ?></td>
                                          </tr>
                                          <tr>
                                            <td>Khách Sạn : </td>
                                            <td><?php echo $row['namehotels'] ?></td>
                                          </tr>
                                          <tr>
                                            <td>Phòng: </td>
                                            <td><?php echo $row['nameroom'] ?></td>
                                          </tr>
                                          <tr>
                                            <td>Ngày Bắt Đầu : </td>
                                            <td><?php echo $row['startDate'] ?></td>
                                          </tr>
                                          <tr>
                                            <td>Ngày Kết Thúc : </td>
                                            <td><?php echo $row['endDate'] ?></td>
                                          </tr>
                                          <tr>
                                            <td>Giá : </td>
                                            <td>
                                                <?php 
                                                    $startdate = $row['startDate'];
                                                    $enddate = $row['endDate'];

                                                    $date = (strtotime($enddate) - strtotime($startdate))/ (60 * 60 * 24);
                                                    echo  number_format($row['price']).'đ x '. $date.' ngày';
                                                ?>
                                             </td>
                                          </tr>
                                          <tr>
                                            <td>Tổng : </td>
                                            <td><b><?php echo number_format($row['totalPrice']).' đ' ?></b></td>
                                          </tr>
                                          <tr>
                                            <td colspan="2" class="text-center"><b>Lưu ý : Khi đến nhận phòng, thì xuất trình hoá đơn này. </b></td>
                                          </tr>
                                          <tr>
                                            <td colspan="2" class="text-center"><i>Cảm ơn quý khách rất nhiều !</i></td>
                                          </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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