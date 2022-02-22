 <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.php">BOOK HOTELS</a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">

	          	<?php
	                if(!isset($_SESSION['gmail'])){
	                	echo '<li class="nav-item"><a href="signup.php" class="nav-link btn btn-danger">Đăng Ký</a></li>';
	                    echo '<li class="nav-item"><a href="login.php" class="nav-link btn btn-primary ml-1">Đăng Nhập</a></li>';

                    }else{
                        $sqluser = "select * from users where gmail = '$gmail'";
                        $queryuser = $conn->query($sqluser);
                        $rowuser = mysqli_fetch_array($queryuser, MYSQLI_ASSOC);
                        echo '
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link btn dropbtn btn btn-primary" ><i class="fa fa-user-circle-o" style="font-size:20px; padding:4px"></i>'.$rowuser['name'].'</a>
                                <ul class="dropdown-content">
                                    <li><a href="profile.php">Trang cá nhân</a></li>
                                    <li><a href="bills.php">Chi tiết đã đặt</a></li>
                                    <li><a href="logout.php">Đăng Xuất</a></li>
                                </ul>
                            </li>
                        ';                          
                    }
                ?>
	        </ul>
	      </div>
	    </div>
	  </nav>