<?php 

    include 'session.php'; 
    $msg ='' ;
	$sqluser = "select * from users";
	$query = $conn->query($sqluser);
	$phone1 = array();
	if($query->num_rows > 0){
	    while ($row = $query->fetch_assoc()) {
	        $phone1[] = $row['phone'];
	    }
	}

    $sqluser = "select * from users where gmail = '$gmail'";
    $queryuser = $conn->query($sqluser);
    $rowuser = mysqli_fetch_array($queryuser, MYSQLI_ASSOC);
	$id = $rowuser['id'];

	if(isset($_POST['updateprofile'])){
		$name = $_POST['name'];
		$gmail = $_POST['gmail'];
		$phone = $_POST['phone'];
		$cardnumber = $_POST['cardnumber'];
		$cardtype = $_POST['cardtype'];
		$address = $_POST['address'];
		if(in_array($phone, $phone1)){
			$msg = '<div class="alert alert-danger" role="alert">Số diện thoại đã tồn tại.</div>';
		}else{
			$sql = "UPDATE `users` SET `name`='$name',`gmail`='$gmail',`idCardNumber`='$cardnumber',`idCardType`='$cardtype', `address`='$address',`phone`='$phone' WHERE id = $id ";

			if($conn->query($sql)){
				header('Location: profile.php');
			}else{
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		
	}

	if(isset($_POST['updateimage'])){
		$dir = "./images/users/";
        $images1 = $_FILES['images']['name'];
        $temp_name1 = $_FILES['images']['tmp_name'];

        if($images1 != ""){
            if(file_exists($dir.$images1)){
                $images1 = time().'_'.$images1;
            }
            $fdir = $dir.$images1;
            move_uploaded_file($temp_name1, $fdir);
        }

        $sql = "UPDATE `users` SET image = '$images1' WHERE id = $id ";
        if($conn->query($sql)){
			header('Location: profile.php');
		}else{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	if(isset($_POST['updatepassword'])){
		$pass = $_POST['password'];

		$sql = "UPDATE `users` SET `password`='$pass' WHERE id = $id ";

		if($conn->query($sql)){
			header('Location: profile.php');
		}else{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
?>
<!DOCTYPE html>
<html lang="zxx">

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
    @import url("https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap");
body {
	background: #f9f9f9;
	font-family: "Roboto", sans-serif;
}

.shadow {
	box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
}

.profile-tab-nav {
	min-width: 250px;
}

.tab-content {
	flex: 1;
}

.form-group {
	margin-bottom: 1.5rem;
}

.nav-pills a.nav-link {
	padding: 15px 20px;
	border-bottom: 1px solid #ddd;
	border-radius: 0;
	color: #333;
}
.nav-pills a.nav-link i {
	width: 20px;
}

.img-circle img {
	height: 100px;
	width: 100px;
	border-radius: 100%;
	border: 5px solid #fff;
}label {  
  width: 300px;  
  font-weight: bold;  
  display: inline-block;  
  margin-top: 20px;  
}  
label span {  
  font-size: 1rem;  
}  
label.error {  
    color: red;  
    font-size: 1rem;  
    display: block;  
    margin-top: 5px;  
}  
input.error {  
    border: 1px dashed red;  
    font-weight: 300;  
    color: red;  
}


    </style>
</head>

<body>
    <!-- Page Preloder -->
    <?php include 'templates/navbar.php' ?>

    <?php include 'templates/header.php' ?>

    <!-- Rooms Section Begin -->
    <section class="py-5 my-5">
		<div class="container">
			<div class="bg-white shadow rounded-lg d-block d-sm-flex">
				
				<div class="profile-tab-nav border-right">
					<div class="p-4">
						<div class="img-circle text-center mb-3">
							<form  action="" method="POST" enctype="multipart/form-data">
								<?php
									if($rowuser['image'] == ''){

										echo '<img src="./images/users/user.png" alt="Image" id="imgFileUpload" class="shadow">';
										echo '	
												<input type="file" id="FileUpload1" name="images" style="display: none" />';
										
									}elseif ($rowuser['image'] != '') {
										echo '<img src="./images/users/'.$rowuser['image'].'" alt="Image" id="imgFileUpload" class="shadow">';
										echo '	
												<input type="file" id="FileUpload1" name="images" style="display: none" />';
										
									}
								?>
								<br>
								<button type="submit" name="updateimage" class="btn btn-danger">Save</button>
							</form>
						</div>
						<h4 class="text-center"><?php echo $rowuser['name'] ;?></h4>
					</div>
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
							<i class="fa fa-home text-center mr-1"></i> 
                            Tài Khoản
						</a>
						<a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
							<i class="fa fa-key text-center mr-1"></i> 
							Mật Khẩu
						</a>
					</div>
				</div>
				<div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
						<h3 class="mb-4">Cài đặt tài khoản</h3>
						<br>
						<div class="col-sm-12">
		                    <?php echo $msg ?>
		                </div>

						<form action="" method="post" id="informationForm">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">Họ tên : </label>
										<input type="text" name="name" id="name" minlength="10" maxlength="35" required class="form-control" value="<?php echo $rowuser['name'] ;?>">
									</div>
								</div>	
								<div class="col-md-6">
									<div class="form-group">
										<label for="gmail">Gmail : </label>
										<input type="text" name="gmail" id="gmail" minlength="5" maxlength="35"  class="form-control" readonly="" value="<?php echo $rowuser['gmail'] ;?>" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="phone">Số điện thoại : </label>
										<input type="text" name="phone" id="phone" minlength="10" maxlength="10" class="form-control" value="<?php echo $rowuser['phone'] ;?>" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="cardnumber">Số CMND : </label>
										<input type="text" name="cardnumber" id="cardnumber" minlength="9" maxlength="12" class="form-control" value="<?php echo $rowuser['idCardNumber'] ;?>" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="type">Kiểu Thẻ : </label>
										<input type="text" name="cardtype" id="type" minlength="4" maxlength="19" class="form-control" value="<?php echo $rowuser['idCardType'] ;?>" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="address">Địa Chỉ : </label>
										<input type="text" name="address" id="address" minlength="15" class="form-control" value="<?php echo $rowuser['address'] ;?>" required>
									</div>
								</div>
							</div>
							<div>
								<button type="submit" name="updateprofile" class="btn btn-primary">Update</button>
							</div>
						</form>
					</div>
					<div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
						<h3 class="mb-4">Cài đặt mật khẩu</h3>
						<form action="" method="post" id="passwordForm">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Mật khẩu mới</label>
										<input type="password" minlength="6" maxlength="10" name="" id="pass" class="form-control" required="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Nhập lại mật khẩu mới</label>
										<input type="password" minlength="6" maxlength="10" name="password" id="confirmPassword" class="form-control" required="">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<div class="form-check">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" onclick="displayPass()">
													Hiển thị mật khẩu
												</label>
											</div>
										</div>
									</div>
								</div>
								
							</div>

							<div>
								<button type="submit" name="updatepassword" class="btn btn-primary" id="check">Update</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
    <!-- Rooms Section End -->

    <!-- Footer Section Begin -->
    <?php include 'templates/footer.php' ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
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
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

        <script type="text/javascript">
            $(function () {
                $("#check").click(function () {

                    var password = $("#pass").val();
                    var confirmPassword = $("#confirmPassword").val();
                    if(password=="" || confirmPassword == ""){
                        alert("Không được để trống");
                        return false;
                    }

                    if (password != confirmPassword) {
                        alert("Mật khẩu chưa đúng");
                        return false;
                    }

                });
            });

            var trangthai = true
            function displayPass(){
                if(trangthai == true){
                    document.getElementById('pass').setAttribute('type', 'text')
                    document.getElementById('confirmPassword').setAttribute('type', 'text')
                    trangthai = false
                }else{
                    document.getElementById('pass').setAttribute('type', 'password')
                    document.getElementById('confirmPassword').setAttribute('type', 'password')
                    trangthai = true
                }
            }
            $(function () {
		        var fileupload = $("#FileUpload1");
		        var filePath = $("#spnFilePath");
		        var image = $("#imgFileUpload");
		        image.click(function () {
		            fileupload.click();
		        });
		        fileupload.change(function () {
		            var fileName = $(this).val().split('\\')[$(this).val().split('\\').length - 1];
		            filePath.html("<b>Selected File: </b>" + fileName);
		        });
		    });

		    //check
		    $( "#informationForm" ).validate();
		    $( "#passwordForm" ).validate();
		    $(function () {
		      	$('#name'),$('#type').keydown(function (e) {
		          	if (e.shiftKey || e.ctrlKey || e.altKey) {
		              	e.preventDefault();
		          	} else {
		              	var key = e.keyCode;
		              	if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		                  	e.preventDefault();
		            	}
		          	}
		      	});
		      	$('#phone').keypress(function(event) {
					return /\d/.test(String.fromCharCode(event.keyCode));
				});
				$('#cardnumber').keypress(function(event) {
					return /\d/.test(String.fromCharCode(event.keyCode));
				});
		  	});
        </script>
</body>

</html>