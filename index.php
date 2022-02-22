<?php include 'session.php';?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>BOOK HOTEL</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">

    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
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
		
	<section class="ftco-section">
      	<div class="container">
        	<div class="row">
        		<div class="col-lg-3 sidebar order-md-last ftco-animate">
        			<div class="sidebar-wrap ftco-animate">
        				<h3 class="heading mb-4">Tìm Khách Sạn</h3>
        			</div>
        			<div class="sidebar-wrap ftco-animate">
        					<form method="post" class="star-rating">
							   <?php
		                            for ($i=5; $i > 0; $i--) { 
		                              echo '
		                            <div class="form-check">
    		                            <input type="checkbox" class="common_selector hotels" value='.$i.'> 
    		                            <label class="form-check-label" for="exampleCheck1">
    		                                <p class="rate">
    		                                    <span>';
            		                                $star = $i;
            		                                $count  = 0;
            		                                for($j = 0; $j < $star; $j++){
            		                                    echo '<i class="icon-star"></i>';
            		                                    $count = $count + 1;
            		                                }
            		                                $star1 = 5 - $count;
            		                                for($j = 0; $j < $star1; $j++){
            		                                    echo '<i class="icon-star-o"></i>';
            		                                }
    		                                echo '
    		                                   </span>
    		                                </p>
		                              </label>
		                            </div>
		                              '
		                              ;
		                            }
		                        ?>
							</form>
        		</div>
          </div>
          <div class="col-lg-9">
          	<div class="row product_loading">
          		
          	</div>
          </div>
        </div>
      </div>
    </section>

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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
    
    $(document).ready(function(){
	    filter_data();
	    function filter_data(){
            var action = 'fetch_data';
            var hotels = get_filter('hotels');
            $.ajax({
                url:"loadhotels.php",
                method:"POST",
                data:{action:action, hotels:hotels },
                success:function(data){
                    $('.product_loading').html(data);
                }
            });
        }
      	function get_filter(class_name) {
            var filter = [];
            $('.'+class_name+':checked').each(function(){
                filter.push($(this).val());
            });
            return filter;
        }

        $('.common_selector').click(function(){
            filter_data();
        });

    });
    </script>
</body>
</html>