<?php
session_start();
require_once('connection/conn.php');
if(!isset($_SESSION['user_id']) or $_SESSION['access']!="Brgy"){
	header("location:login.html");	
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Camalig Albay - MDRRMO</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="css/grasp_mobile_progress_circle-1.0.0.min.css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/Camalig_Albay.png">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <!-- Side Navbar -->
          <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <div class="sidenav-header-inner text-center"><img src="img/Camalig_Albay.png" alt="logo" class="img-fluid rounded-circle">
            <h2 class="h5 text-uppercase">MDRRMC Camalig Albay</h2><span class="text-uppercase">Albay, Philippines</span>
          </div>
          <div class="sidenav-header-logo"><a href="index.php" class="brand-small text-center"> <strong>FS</strong><strong class="text-primary">P</strong></a></div>
        </div>
        <div class="main-menu">
            <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="index_barangay.php"> <i class="icon-home"></i><span>Home</span></a></li>
            <li> <a href="barangay_brgy.php"> <i class="icon-grid"> </i><span>Barangays</span></a></li>
            <li  class="active"> <a href="post_report_barangay.php"> <i class="icon-mail"></i><span>MDRRMC POST</span>
                </a></li>
          </ul>
        </div>
        <div class="admin-menu">
          <ul id="side-admin-menu" class="side-menu list-unstyled"> 
			<li > <a href="hmap_barangay.php"> <i class="icon-picture"> </i><span>Landslide Map</span></a></li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="page home-page">
      <!-- navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="index.php" class="navbar-brand">
                  <div class="brand-text d-none d-md-inline-block"><span></span><strong class="text-primary">Landslide Evacuation Monitoring and Management System</div></a></div>
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <li class="nav-item"><a href="" class="nav-link logout">Welcome Barangay <b><?php echo $_SESSION['user_name'];?></b></a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link logout">Logout<i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <!-- Counts Section -->
      <!-- Header Section-->
      <section class="dashboard-header section-padding">
        <div class="container-fluid">
          <div class="row d-flex align-items-md-stretch">
            <!-- To Do List-->
            <!-- Line Chart -->
            <div class="col-lg-10 col-md-12 flex-lg-last flex-md-first align-self-baseline">
              <div class="wrapper sales-report">
                <h2 class="display h4">MDRRMC Weather Posting Page</h2>
                <p> Weather Post as of <?php echo date("M-d-Y");?></p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Statistics Section-->
      
      <!-- Updates Section -->
      <section class="updates section-padding">
        <div class="container-fluid">
          <div class="row">
            <!-- Daily Feed-->
            <!-- Recent Activities                            -->
            <div class="col-lg-10 col-md-10">
              <div id="recent-activities-wrapper" class="wrapper recent-activities">
                <div id="activites-header" class="card-header d-flex justify-content-between align-items-center">
                  <h2 class="h5 display"><a data-toggle="collapse" data-parent="#recent-activities-wrapper" href="#activities-box" aria-expanded="true" aria-controls="activities-box">Recent Weather POST update</a></h2><a data-toggle="collapse" data-parent="#recent-activities-wrapper" href="#activities-box" aria-expanded="true" aria-controls="activities-box"><i class="fa fa-angle-down"></i></a>
                </div>
                <div id="activities-box" role="tabpanel" class="collapse show">
                  <ul class="activities list-unstyled">
                    <!-- Item-->
					<?php
					$pyear=date('Y');
												$sql = "SELECT * FROM report_details where year(date_added)='$pyear' order by date_added desc";
												$result = $conn->query($sql);

												if ($result->num_rows > 0) {
													// output data of each row
													
													while($row = $result->fetch_assoc()) {
														$process_by=$row['cdrrmo_name'];
														$amt_water=$row['amount_water'];
														$ss_signal=$row['ss_signal'];
														$date_proc=$row['date_added'];
														 echo "<li>";
														  echo "<div class='row'>";
															echo "<div class='col-4 date-holder text-right'>";
															echo "<div class='icon'><i class='icon-clock'></i></div>";
															echo "<div class='date'> <span>";
															echo $date_proc;
															echo "</span></div>
															</div>";
															echo "<div class='col-8 content'><strong>Weather Update</strong>
															  <p>Amount of Rain: "; 
															echo "<b style='color:Black;'>".$amt_water."</b>";
															echo " mm</p>
															  <p>Storm Signal:"; 
															echo "<b style='color:Black;'>".$ss_signal."</b>";
															echo "</p>
															  <span class='text-info'>Posted by: "; 
															echo "<b style='color:Black;'>".$process_by."</b>";
															echo "</span>
															</div>
														  </div>
														</li>";
													}
												} 
												
												$conn->close();
												
                   
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p>MDRRMC Camalig Albay &copy; 2017-2018</p>
            </div>
            <div class="col-sm-6 text-right">
              
            </div>
          </div>
        </div>
      </footer>
    </div>
    <!-- Javascript files-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="js/charts-home.js"></script>
    <script src="js/front.js"></script>
    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
    <!---->
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-XXXXX-X');ga('send','pageview');
    </script>
  </body>
</html>