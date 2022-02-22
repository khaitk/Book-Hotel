<?php
include 'db.php';
session_start();
error_reporting(E_ALL & ~E_NOTICE);
if(isset($_POST['submit'])){
    $email=$_POST['email'];
    $pwd = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE gmail = '$email' or phone = '$email' and password = '$pwd'";

    $result = mysqli_query($conn,$sql);
    $rowsql = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1) {
        $_SESSION['gmail'] = $email;
        if($rowsql['phone'] == '' || $rowsql['idCardNumber'] == '' || $rowsql['idCardType'] == '' || $rowsql['address'] == '' || $rowsql['phone'] == ''){
            header("location: profile.php");
        }else{
            header("location: index.php");
        }
        
     }else {
        $error = '<div class="alert alert-danger" role="alert">Email hoặc mật khẩu chưa đúng.</div>';
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
</head>

<body>
     <?php include 'templates/navbar.php'; ?>
    
     <?php include 'templates/header.php'; ?>

        <div class="container" style="padding-top: 50px; padding-bottom: 50px;">

            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <?php echo $error ?>
                </div>

                <div class="col-sm-6">
                <h4 class="text-center">Sign in</h4>
                <form action="" method="post" id="loginForm">
                    <div class="form-group">
                        <label for="email">Email : </label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password : </label>
                        <input type="password" class="form-control" minlength="6" maxlength="10" name="password" id="password" aria-describedby="password" placeholder="Password">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary" id="check">Đăng Nhập</button>
                    <a href="signup.php" class="btn btn-outline-dark buttonleft">Tạo Tài Khoản</a>
                </form>
                </div>
            </div>
        </div>


    <!-- Footer Section Begin -->
    <?php include 'templates/footer.php' ?>
    <!-- Footer Section End -->
    <!-- Js Plugins -->
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#check").click(function () {
                var password = $("#password").val();
                var email = $("#email").val();

                if (email == "") {
                    alert("Email không được để trống");
                    return false;
                }
                if(password == ""){
                    alert("Password không được để trống");
                    return false;
                }
                

            });
        });
        $( "#loginForm" ).validate();
  </script>
</body>
</html>