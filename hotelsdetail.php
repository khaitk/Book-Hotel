<?php 
    include 'session.php'; 
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $id = $_GET['id'];

    $sql = "select *  from hotels where id = $id";
    $query = $conn->query($sql);

    $row  = mysqli_fetch_assoc($query);

    $sqlmin = "select min(price) as min from rooms where idHotel = $id";
    $querymin = $conn->query($sqlmin);
    $rowmin = mysqli_fetch_array($querymin);

    
    $sqlmax = "select max(price) as max from rooms where idHotel = $id";
    $querymax = $conn->query($sqlmax);
    $rowmax = mysqli_fetch_array($querymax);
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
<style>
  .sidebar.vangdunglai{
    position: fixed;
    top: 50px;

}
.col-lg-3.sidebar {
    padding-right: 4px !important;
    padding-left: 56px !important;
    padding-top: 85px;
}
</style>

  </head>
  <body>
    
<?php include 'templates/navbar.php'; ?>
    <!-- END nav -->
    
<?php include 'templates/header.php'; ?>
        
        <section class="ftco-section ftco-degree-bg">
          <div class="container">
            <div class="row">
                
          <div class="col-lg-12">
            <div class="row">
                <div class="col-md-12 ftco-animate">
                    <div class="single-slider owl-carousel">
                        <div class="item">
                            <div class="hotel-img" style="background-image: url(./images/hotels/<?php echo $row['images1']; ?>);"></div>
                        </div>
                        <div class="item">
                            <div class="hotel-img" style="background-image: url(./images/hotels/<?php echo $row['images2']; ?>);"></div>
                        </div>
                        <div class="item">
                            <div class="hotel-img" style="background-image: url(./images/hotels/<?php echo $row['images3']; ?>);"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 hotel-single mt-4 mb-5 ftco-animate">
                    <span>Giới Thiệu</span>
                    <h2><?php echo $row['name']; ?></h2>
                    <p class="rate mb-5">
                        <span class="loc"><a href="#"><i class="icon-map"></i><?php echo $row['address']; ?></a></span>
                        <span class="star">
                            <?php 
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
                            ?>
                                
                            </p>
                            
                            <p><?php echo $row['description'] ?></p>
                </div>
              </div>
                  
                </div>
                <div class="col-lg-12">
                  <div class="row">
                <div class="col-lg-9 hotel-single ftco-animate mb-5 mt-4">
                    <h4 class="mb-4">Danh sách phòng</h4>
                    
                       <div id="product_loading"></div>
                    
                </div>
                             <div class="col-lg-3 sidebar">
                    <div class="sidebar-wrap ftco-animate">
                        <h3 class="heading mb-4">Tìm Phòng Theo Giá</h3>
                        
                            <div class="fields">
                      <div class="form-group">
                        <div class="range-slider">
                           <input type="hidden" id="hidden_minimum_price" value="0" /> 
                              <input type="hidden" id="hidden_maximum_price" value="650000" />
                            <p id="price_show"><?php echo $rowmin['min'];  ?> - <?php echo $rowmax['max'];  ?></p>
                            <div id="slider-range"></div>
                            </svg>
                            <br>
                          </div>
                      </div>
                      
                    </div>
                </div>

          </div></div>
                </div>
            </div>
          </div> <!-- .col-md-8 -->
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    
    $(document).ready(function(){
      filter_data();
      function filter_data(){
            var action = 'fetch_data';
            var minimum_price = $('#hidden_minimum_price').val();
            var maximum_price = $('#hidden_maximum_price').val();
            var rating = get_filter('rating');
            $.ajax({
                url:"loadroom.php",
                method:"POST",
                data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, rating:rating,  id: <?php echo $_GET['id'];?>},
                success:function(data){
                    $('#product_loading').html(data);
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

        $( "#slider-range" ).slider({
            range: true,
            min: <?php echo $rowmin['min'];?>,
            max: <?php echo $rowmax['max'];?>,
            values: [ <?php echo $rowmin['min'];?>, <?php echo $rowmax['max'];?> ],
            slide: function( event, ui ) {
                $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
                $('#hidden_minimum_price').val(ui.values[0]);
                $('#hidden_maximum_price').val(ui.values[1]);
                filter_data();
            }
        });
    });
</script>
</body>
</html>