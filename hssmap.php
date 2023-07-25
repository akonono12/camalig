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
    <title>NDRRMC Tabaco - Hazard Map</title>
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
    <link rel="shortcut icon" href="img/tabaco_logo.jpg">
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
	  Average: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_green.png'
      },
	  Lightly: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_yellow.png'
      },
	   Highlevel: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_gray.png' 
      },
      Flood: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
      }
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(13.341937, 123.689508),
        zoom: 13,
        mapTypeId: 'satellite'
		
      });
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
	  
	  <?php
	  $signal=$ss_signal;
	  if($signal==1){
	  	 echo "map.data.loadGeoJson('tabaco_ss_no_signal.json');";
	  }
	  elseif($signal==2){
		  echo "map.data.loadGeoJson('tabaco_ss_no_signal.json');";
	  }
	  elseif($signal>=3){
		  echo "map.data.loadGeoJson('tabaco_ss.json');";
	  }
	  else{
			echo "map.data.loadGeoJson('tabaco_ss_no_signal.json');";
		  
	  }
		?>

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
      downloadUrl("xmlflood.php", function(data) { 
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("address");
		  var message = markers[i].getAttribute("message");
   		  var type = markers[i].getAttribute("type");
		  var link1 = markers[i].getAttribute("link1");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + name + "</b> <br/>" + address  + "<br/> " + type  + "<br/>" + message + "<br> <p><a href='" + link1 + "'>View The Information</a></p>"; 
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
<script type="text/javascript">
function Ajax(){
var xmlHttp;
	try{	
		xmlHttp=new XMLHttpRequest();// Firefox, Opera 8.0+, Safari
	}
	catch (e){
		try{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
		}
		catch (e){
		    try{
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e){
				alert("No AJAX!?");
				return false;
			}
		}
	}
xmlHttp.onreadystatechange=function(){
	if(xmlHttp.readyState==4){
		document.getElementById('load_data').innerHTML=xmlHttp.responseText;
		setTimeout('Ajax()',1000);
	}
}
xmlHttp.open("GET","",true);
xmlHttp.send(null);
}
window.onload=function(){
	setTimeout('Ajax()',1000);
}
</script>

<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	// load messages every 1000 milliseconds from server.
	load_data = {'fetch':1};
	window.setInterval(function(){
	 $.post('shout.php', load_data,  function(data) {
		$('.message_box').html(data);
		var scrolltoh = $('.message_box')[0].scrollHeight;
		$('.message_box').scrollTop(scrolltoh);
	 });
	}, 1000);
	
	//method to trigger when user hits enter key
	$("#shout_message").keypress(function(evt) {
		if(evt.which == 13) {
				var iusername = $('#shout_username').val();
				var imessage = $('#shout_message').val();
				post_data = {'username':iusername, 'message':imessage};
			 	
				//send data to "shout.php" using jQuery $.post()
				$.post('shout.php', post_data, function(data) {
					
					//append data into messagebox with jQuery fade effect!
					$(data).hide().appendTo('.message_box').fadeIn();
	
					//keep scrolled to bottom of chat!
					var scrolltoh = $('.message_box')[0].scrollHeight;
					$('.message_box').scrollTop(scrolltoh);
					
					//reset value of message box
					$('#shout_message').val('');
					
				}).fail(function(err) { 
				
				//alert HTTP server error
				alert(err.statusText); 
				});
			}
	});
	
	//toggle hide/show shout box
	$(".close_btn").click(function (e) {
		//get CSS display state of .toggle_chat element
		var toggleState = $('.toggle_chat').css('display');
		
		//toggle show/hide chat box
		$('.toggle_chat').slideToggle();
		
		//use toggleState var to change close/open icon image
		if(toggleState == 'block')
		{
			$(".header1 div").attr('class', 'open_btn');
		}else{
			$(".header1 div").attr('class', 'close_btn');
		}
		 
		 
	});
});

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

		.shout_box {
	background: #627BAE;
	width: 300px;
	overflow: hidden;
	position: fixed;
	bottom: 0;
	right: 10px;;
	z-index:9;
	float:right;
	margin-bottom:48px;
}
.shout_box .header1 .close_btn {
	background: url(images/close_btn.png) no-repeat 0px 0px;
	float: right;
	width: 15px;
	height: 15px;
}
.shout_box .header1 .close_btn:hover {
	background: url(images/close_btn.png) no-repeat 0px -16px;
	height:8px;
}

.shout_box .header1 .open_btn {
	background: url(images/close_btn.png) no-repeat 0px -32px;
	float: right;
	width: 15px;
	height: 15px;
}
.shout_box .header1 .open_btn:hover {
	background: url(images/close_btn.png) no-repeat 0px -48px;
}
.shout_box .header1{
	padding: 5px 3px 5px 5px;
	font: 11px 'lucida grande', tahoma, verdana, arial, sans-serif;
	font-weight: bold;
	color:#fff;
	border: 1px solid rgba(0, 39, 121, .76);
	border-bottom:none;
	cursor: pointer;
}
.shout_box .header1:hover{
	background-color: #627BAE;
}
.shout_box .message_box {
	background: #FFFFFF;
	height: 330px;
	overflow:auto;
	border: 1px solid #CCC;
}
.shout_msg{
	margin-bottom: 10px;
	display: block;
	border-bottom: 1px solid #F3F3F3;
	padding: 0px 5px 5px 5px;
	font: 11px 'lucida grande', tahoma, verdana, arial, sans-serif;
	color:#7C7C7C;
}
.message_box:last-child {
	border-bottom:none;
}
time{
	font: 11px 'lucida grande', tahoma, verdana, arial, sans-serif;
	font-weight: normal;
	float:right;
	color: #D5D5D5;
}
.shout_msg .username{
	margin-bottom: 10px;
	margin-top: 10px;
}
.user_info input {
	width: 98%;
	height: 25px;
	border: 1px solid #CCC;
	border-top: none;
	padding: 3px 0px 0px 3px;
	font: 11px 'lucida grande', tahoma, verdana, arial, sans-serif;
}
.shout_msg .username{
	font-weight: bold;
	display: block;
}
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
          <div class="sidenav-header-inner text-center"><img src="img/tabaco_logo.jpg" alt="logo" class="img-fluid rounded-circle">
            <h2 class="h5 text-uppercase">NDRRMC Camalig Albay</h2><span class="text-uppercase">Albay, Philippines</span>
          </div>
          <div class="sidenav-header-logo"><a href="index.php" class="brand-small text-center"> <strong>T</strong><strong class="text-primary">C</strong></a></div>
        </div>
        <div class="main-menu">
            <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="index.php"> <i class="icon-home"></i><span>Home</span></a></li>
            <li> <a href="list_accounts.php"><i class="icon-form"></i><span>Manage Account</span></a></li>
            <li> <a href="report.php"><i class="icon-presentation"></i><span>Manage Report</span></a></li>
            <li> <a href="barangay.php"> <i class="icon-grid"> </i><span>Barangays</span></a></li>
            <li> <a href="post_report.php"> <i class="icon-mail"></i><span>Manage POST</span>
                </a></li>
          </ul>
        </div>
        <div class="admin-menu">
          <ul id="side-admin-menu" class="side-menu list-unstyled"> 
            <li class="active"> <a href="hssmap.php"> <i class="icon-picture"> </i><span>Storm Surge Map</span></a></li>
			<li> <a href="hmap.php"> <i class="icon-picture"> </i><span>Flood Map</span></a></li>
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
                  <div class="brand-text d-none d-md-inline-block"><span></span><strong class="text-primary">FLOOD AND STORM SURGE PREDICTION System </strong></div></a></div>
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <li class="nav-item"><a href="" class="nav-link logout">Welcome <b>Admin</b></a></li>
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
            <li class="breadcrumb-item"><a href="hmap.php">Flood Hazard map</a></li>
			<li class="breadcrumb-item active">Storm Surge Hazard map</li>
          </ul>
        </div>
      </div>
      <section class="charts">
        <div class="container-fluid">
          <header> 
            <h1 class="h3">Camalig Albay Storm Surge Hazard Map</h1>
          </header>
          <div class="row">
            <div class="col-lg-12">
			 
              <div class="card">
                <div class="card-header d-flex align-items-center">
			
                  <h2 class="h5 display" align="center">Weather Update: as of <b><?php echo $date_proc;?> </b>the Storm Surge signal #: <b><?php echo $signal;?></b></h2>
				  
                </div>
                <div class="card-body">
                <div id="map" style="width:100%; height:495px;"></div>
				<div id="info-box"></div>
			   <div id="legend" style="z-index: 0; background:#FFF; height:auto; position:absolute; bottom: 50px; float:left; margin-top:-20px;"><p>&nbsp;Legend of Camalig Albay<br />
			   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>Storm Surge Hazard map&nbsp;</em></p>
			  <div><span class="color" style="background-color: red;"></span><span>Highly Prone to Storm Surge Areas</span></div><div></div>
			  </div>
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