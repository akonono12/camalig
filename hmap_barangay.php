<?php
session_start();
require_once('connection/conn.php');
//if(!isset($_SESSION['user_id']) or $_SESSION['access']!="admin"){
	//header("location:login.html");	
//}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MDRRMC Camalig Albay - Hazard Map</title>
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
		
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5R6JEIiERVxCgYhl9gsGZ8GOUvnifjO4" type="text/javascript"></script>
    <script type="text/javascript">
    //<![CDATA[

    var customIcons = {
      Evacuation: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
      },
	  Lightly: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_yellow.png'
      },
	   Highlevel: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_gray.png' 
      }
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(13.155940, 123.638588),
        zoom: 12,
        mapTypeId: 'satellite',
      });
	  
	  <?php
												$sql = "SELECT * FROM report_details order by date_added asc";
												$result = $conn->query($sql);

												if ($result->num_rows > 0) {
													// output data of each row
													
													while($row = $result->fetch_assoc()) {
														$process_by=$row['fullname'];
														$amt_water=$row['amount_water'];
														$ss_signal=$row['ss_signal'];
														$date_proc=$row['date_added'];
													}
												}
												?>
	  	map.data.loadGeoJson('camalig.json');
	 

  // Add some style. 
  map.data.setStyle(function(feature) {
    return /** @type {google.maps.Data.StyleOptions} */({
      fillColor: feature.getProperty('color'), 
      strokeWeight: 1
    });
  });

  // [START snippet]
  // Set mouseover event for each feature.
  map.data.addListener('mouseover', function(event) {
    document.getElementById('info-box').textContent =
        event.feature.getProperty('');
 
	      	//listen for click events
			map.data.addListener('click', function(event) {
				//show an infowindow on click   
				infoWindow.setContent('<div style="line-height:1.35;overflow:hidden;white-space:nowrap;">'
											
									+"" + event.feature.getProperty("Name")  + " </div>");
				var anchor = new google.maps.MVCObject();
				anchor.set("position",event.latLng);
				infoWindow.open(map,anchor);
			});

	
  });
  // [END snippet]
  
  
	  
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
      downloadUrl("xmllandslide.php", function(data) { 
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("address");
		  var message = markers[i].getAttribute("message");
   		  var type = markers[i].getAttribute("type");
		  var capacity = markers[i].getAttribute("capacity");
		  var tevac = markers[i].getAttribute("tevac");
		  var link1 = markers[i].getAttribute("link1");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "Name: <b>" + name + "</b> <br/>Address:" + address  + "<br/> Type:" + type  + " center<br/># of Evacuee:" + tevac + "<br/>Capacity:"+ capacity +" <br/><p><a href='" + link1 + "'>View The Information</a></p>"; 
          var icon = customIcons[type] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point, 
            icon: icon.icon
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

    //]]>
	

  </script>

<style>
.left{
	float:left;
}
.right{
	float:right;
}
  html, body {
        height: 100%;
        margin: 0;
        padding: 0;
		background-color:;
      }
      #map {
        height: 100%;
	
      
    }
 #legend {
	background: #FFF;
	padding: 10px;
	margin: 5px;
	font-size: 12px;
	font-family: Arial, sans-serif;
	margin-right:30px;
	margin-top:30px;
	float:right;
	border-radius:5px;
	margin-top:30px;
	left: 26px;
}

      #legend p {
        font-weight: bold;
      }

      #legend div {
        padding-bottom: 2px;
      }

      .color {
        border: 1px solid;
        height: 12px;
        width: 12px;
        margin-right: 3px;
        float: left;
      }
	      .top{
		margin-top:60px;}


.color{
	background-color:#8B8989;
}


</style>
  </head>
  <body onLoad="load()">
    <!-- Side Navbar -->
      <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <div class="sidenav-header-inner text-center"><img src="img/Camalig_Albay.png" alt="logo" class="img-fluid rounded-circle">
            <h2 class="h5 text-uppercase">MDRRMC Camalig Albay</h2><span class="text-uppercase">Albay, Philippines</span>
          </div>
          <div class="sidenav-header-logo"><a href="index.php" class="brand-small text-center"> <strong>T</strong><strong class="text-primary">C</strong></a></div>
        </div>
        <div class="main-menu">
           <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="index_barangay.php"> <i class="icon-home"></i><span>Home</span></a></li>
            <li> <a href="barangay_brgy.php"> <i class="icon-grid"> </i><span>Barangays</span></a></li>
            <li> <a href="post_report_barangay.php"> <i class="icon-mail"></i><span>MDRRMC POST</span>
                </a></li>
          </ul>
        </div>
        <div class="admin-menu">
          <ul id="side-admin-menu" class="side-menu list-unstyled"> 
			<li  class="active"> <a href="hmap_barangay.php"> <i class="icon-picture"> </i><span>Landslide Map</span></a></li>
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
                <li class="nav-item"><a href="" class="nav-link logout">Welcome <b>Barangay</b></a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link logout">Logout<i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <div class="breadcrumb-holder">   
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Landslide Hazard map</li>
          </ul>
        </div>
      </div>
      <section class="charts">
        <div class="container-fluid">
          <header> 
            <h1 class="h3">Camalig Albay Hazard Map</h1>
          </header>
          <div class="row">
            <div class="col-lg-12">
			
              <div class="card">
                <div class="card-header d-flex align-items-center">
			
                  <h2 class="h5 display">Weather update: As of  <b><?php echo " ".$date_proc." ";?></b>  the expected amount of rain is : <b><?php echo $amt_water;?></b>mm</h2>  
                </div>
                <div class="card-body">
                <div id="map" style="width:100%; height:495px;"></div>
				<div id="info-box"></div>
				<div id="legend" style="z-index: 0; background:#FFF; height:auto; position:absolute; bottom: 50px; float:left; margin-top:-20px;"><p>&nbsp;Legend of Camalig Albay<br />
			   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>Landslide Hazard map&nbsp;</em></p>
			  <div><span class="color" style="background-color: red;"></span><span>Highly Susceptability to Landslide Areas</span></div><div></div>
			  <div><span class="color" style="background-color: orange;"></span><span>Moderately Susceptability to Landslide Areas</span></div>
			  <div><span class="color" style="background-color:yellow;"></span><span> Low Susceptability to Landslide  Areas</span></div></div>
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
              <p>Camalig Albay &copy; 2017-2018</p>
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