<?php
session_start();
require_once('connection/conn.php');
if(!isset($_SESSION['user_id']) or $_SESSION['access']!="admin"){
	header("location:login.html");	
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Camalig Albay MDRRMO</title>
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
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                zoomType: 'xy'
            },
            title: {
                text: 'Average Monthly Rainfall in Camalig '
            },
            subtitle: {
                text: 'Albay, Philippines'
            },
            xAxis: [{
                categories: [<?php
												$counter=1;
												$cyear=date('Y');
												$sql = "SELECT * FROM average_report_month where w_year='$cyear'";
												$result = $conn->query($sql);
												$cnt=$result->num_rows;
												if ($result->num_rows > 0) {
													// output data of each row
													while($row = $result->fetch_assoc()) {
														$w_month=$row['w_month'];
														echo "'".$w_month."',";
														
													}
												} 
												
												
												?>]
            }],
            yAxis: [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return this.value +'';
                    },
                    style: {
                        color: '#89A54E'
                    }
                },
                title: {
                    text: 'Storm Signal',
                    style: {
                        color: '#89A54E'
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'Rainfall',
                    style: {
                        color: '#4572A7'
                    }
                },
                labels: {
                    formatter: function() {
                        return this.value +' mm';
                    },
                    style: {
                        color: '#4572A7'
                    }
                },
                opposite: true
            }],
            tooltip: {
                formatter: function() {
                    return ''+
                        this.x +': '+ this.y +
                        (this.series.name == 'Rainfall' ? ' mm' : ':Signal #');
                }
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                x: 120,
                verticalAlign: 'top',
                y: 100,
                floating: true,
                backgroundColor: '#FFFFFF'
            },
            series: [{
                name: 'Rainfall',
                color: '#4572A7',
                type: 'column',
                yAxis: 1,
                data: [<?php
												$counter=1;
												$cyear=date('Y');
												$sql = "SELECT * FROM average_report_month where w_year='$cyear'";
												$result = $conn->query($sql);
												$cnt=$result->num_rows;
												if ($result->num_rows > 0) {
													// output data of each row
													while($row = $result->fetch_assoc()) {
														$a_water=($row['a_water']);
														echo $a_water.",";
														
													}
												} 
												
												
												?>]
    
            }, {
                name: 'Storm Signal',
                color: '#89A54E',
                type: 'spline',
                data: [<?php
												$counter=1;
												$cyear=date('Y');
												$sql = "SELECT * FROM average_report_month where w_year='$cyear'";
												$result = $conn->query($sql);
												$cnt=$result->num_rows;
												if ($result->num_rows > 0) {
													// output data of each row
													while($row = $result->fetch_assoc()) {
														$ss_signal=$row['ss_signal'];
														echo $ss_signal.",";
														
													}
												} 
												
												
												?>]
            }]
        });
    });
    
});
		</script>
  </head>
  <body>
    <!-- Side Navbar -->
    <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <div class="sidenav-header-inner text-center"><img src="img/Camalig_Albay.png" alt="logo" class="img-fluid rounded-circle">
            <h2 class="h5 text-uppercase">MDRRMC Camalig Albay</h2><span class="text-uppercase">Albay, Philippines</span>
          </div>
          <div class="sidenav-header-logo"><a href="index.php" class="brand-small text-center"> <strong>B</strong><strong class="text-primary">D</strong></a></div>
        </div>
        <div class="main-menu">
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li class="active"><a href="index.php"> <i class="icon-home"></i><span>Home</span></a></li>
            <li> <a href="list_accounts.php"><i class="icon-form"></i><span>Manage Account</span></a></li>
            <li> <a href="report.php"><i class="icon-presentation"></i><span>Manage Report</span></a></li>
			<li> <a href="evacuation_report.php"><i class="icon-presentation"></i><span>Manage Evacuation</span></a></li>
            <li> <a href="barangay.php"> <i class="icon-grid"> </i><span>Barangays</span></a></li>
            <li> <a href="post_report.php"> <i class="icon-mail"></i><span>Manage POST</span>
                </a></li>
          </ul>
        </div>
        <div class="admin-menu">
          <ul id="side-admin-menu" class="side-menu list-unstyled"> 
			<li> <a href="hmap.php"> <i class="icon-picture"> </i><span>Landslide Map</span></a></li>
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
                  <div class="brand-text d-none d-md-inline-block"><span></span><strong class="text-primary">Landslide Evacuation Monitoring and Management System</strong></div></a></div>
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <li class="nav-item"><a href="" class="nav-link logout">Welcome <b>
				<?php echo $uid=$_SESSION['user_name']; ?>
				</b></a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link logout">Logout<i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <!-- Counts Section -->
      <section class="dashboard-counts section-padding">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xl-2 col-md-4 col-4">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-user"></i></div>
                <div class="name">User<strong class="text-uppercase"> Accounts</strong><span>active users</span>
                  <div><h1><?php
												$cyear=date('Y');
												$sql = "SELECT * FROM users_count";
												$result = $conn->query($sql);

												if ($result->num_rows > 0) {
													// output data of each row
													
													while($row = $result->fetch_assoc()) {
														$count=$row['ucount'];
														echo $count;
													}
												} 
												else{
												echo "0";
												}
												
												?></h1></div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-padnote"></i></div>
                <div class="name"><strong class="text-uppercase">Barangays</strong><span>as of <?php echo date('Y');?></span>
                  <div><h1>50</h1></div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-check"></i></div>
                <div class="name">Weather Update<strong class="text-uppercase"> Posted</strong><span>for the year <?php echo date('Y');?></span>
                  <div><h1>
				  <?php
												$cyear=date('Y');
												$sql = "SELECT * FROM report_count where ryear='$cyear'";
												$result = $conn->query($sql);

												if ($result->num_rows > 0) {
													// output data of each row
													
													while($row = $result->fetch_assoc()) {
														$count=$row['rcount'];
														echo $count;
													}
												} 
												else{
												echo "0";
												}
												
												?>
				  </h1></div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 col-md-8 col-8">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-list"></i></div>
                <div class="name">Landslide<strong class="text-uppercase">Prone Areas</strong><span>as of <?php echo date('M-d-Y');?></span>
                  <div><h1>18</h1></div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-8 col-8">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="icon-list-1"></i></div>
												<?php
												$sql = "SELECT * FROM report_details order by date_added asc";
												$result = $conn->query($sql);

												if ($result->num_rows > 0) {
													// output data of each row
													
													while($row = $result->fetch_assoc()) {
														$process_by=$row['cdrrmo_name'];
														$amt_water=$row['amount_water'];
														$ss_signal=$row['ss_signal'];
														$date_proc=$row['date_added'];
													}
												}
												?>
				<div class="name">Recent<strong class="text-uppercase"> Update</strong><span>weather update as of 
				<?php echo $date_proc;?></span>
                  <div>Amount of Rain: <b><?php echo $amt_water;?></b>mm</div>
				  <div>Storm Signal: <b><?php echo $ss_signal;?></b></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Header Section-->
      <section class="dashboard-header section-padding">
        <div class="container-fluid">
          <div class="row d-flex align-items-md-stretch">
            <!-- Line Chart -->
            <div class="col-lg-12 col-md-12 flex-lg-last flex-md-first align-self-baseline">
              <div class="wrapper sales-report">
                <h2 class="display h4" align="center"></h2>
                <p align="center"> Year of <?php echo date('Y');?></p>
                <div class="line-chart">
                  <script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
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
              <p>MDRRMC Camalig Albay &copy; 2018</p>
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