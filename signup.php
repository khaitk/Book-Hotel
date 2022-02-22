<?php
include 'session.php';
session_start();
$msg = "";

$sqluser = "select * from users";
$query = $conn->query($sqluser);
$gmail = array();
if($query->num_rows > 0){
    while ($row = $query->fetch_assoc()) {
        $gmail[] = $row['gmail'];
    }
}
//print_r($gmail);
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email=$_POST['email'];
    $pwd = $_POST['password'];
    
    if(in_array($email, $gmail)){
        $msg = '<div class="alert alert-danger" role="alert">Email đã tồn tại.</div>';
    }else{
        $sql = "INSERT INTO `users`(`name`, `gmail`, `image`, `password`) VALUES ('$name','$email', 'user.png', '$pwd')";


        if($conn->query($sql) == TRUE){
            $msg = '<div class="alert alert-success" role="alert">Đăng ký thành công.</div>';
        }else{
            echo "Error: " . $sql . "<br>" . $conn->error;
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
</head>

<body>
     <?php include 'templates/navbar.php'; ?>
    
     <?php include 'templates/header.php'; ?>

        <div class="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <?php echo $msg ?>
                </div>
                <div class="col-sm-6">
                <h4 class="text-center">Sign up</h4>
                <form action="" method="post" id="signupForm">
                    <div class="form-group">
                        <label for="">Họ Và Tên : </label>
                        <input type="text" class="form-control" name="name" minlength="10" maxlength="35" id="name" aria-describedby="emailHelpId" placeholder="Name" >
                    </div>
                    <div class="form-group">
                        <label for="">Email : </label>
                        <input type="email" class="form-control" name="email" id="email" minlength="15" maxlength="35" aria-describedby="emailHelpId" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="">Mật Khẩu : </label>
                        <input type="password" class="form-control" name="password" id="password" minlength="6" maxlength="10" aria-describedby="emailHelpId" placeholder="Password" >
                    </div>
                    <div class="form-group">
                        <label for="">Nhập Lại Mật Khẩu : </label>
                        <input type="password" class="form-control" name="" id="confirmPassword" minlength="6" maxlength="10" aria-describedby="emailHelpId" placeholder="Password" >
                    </div>
                    
                    <button type="submit" name="submit" class="btn btn-primary" id="checkform">Đăng Ký </button>
                    <a href="login.php" class="btn btn-outline-dark buttonleft">Đăng Nhập</a>
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
            $("#checkform").click(function () {
                var name = $("#name").val();
                var confirmPassword = $("#confirmPassword").val();
                var password = $("#password").val();
                var email = $("#email").val();

                if(name == ""){
                    alert("Tên không được để trống");
                    return false;
                }

                if (email == "") {
                    alert("Email không được để trống");
                    return false;
                }
                 
                if(password=="" || confirmPassword == ""){
                    alert("Mật khẩu không được để trống");
                    return false;
                }

                if (password != confirmPassword) {
                    alert("Mật khẩu chưa khớp");
                    return false;
                }

            });
        });
        $( "#signupForm" ).validate();
    </script>
</body>

</html>