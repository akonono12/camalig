<?php
session_start();
require_once('connection/conn.php');
//echo "connected!";
$user=$_POST['uname'];
$pass=$_POST['upass'];
$sql = "SELECT * FROM users WHERE username='$user' and password='$pass' and status='active'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$access=$row['access'];
		switch($access){
			case 'admin':
			$_SESSION['brgy_id']=$row['barangay_id'];
			$_SESSION['f_name']=$row['full_name'];	
			$_SESSION['user_id']=$row['user_id'];
			$_SESSION['user_name']=$row['username'];	
			$_SESSION['position']=$row['position'];
			$_SESSION['access']=$row['access'];		
			header("Location:index.php");	
			break;
			case 'Brgy':
			$_SESSION['brgy_id']=$row['barangay_id'];
			$_SESSION['f_name']=$row['full_name'];	
			$_SESSION['user_id']=$row['user_id'];
			$_SESSION['user_name']=$row['username'];	
			$_SESSION['position']=$row['position'];
			$_SESSION['access']=$row['access'];	
			header("Location:index_barangay.php");
			break;
			case 'CampManager':
			$_SESSION['ec_id']=$row['ec_id'];
			$_SESSION['f_name']=$row['full_name'];	
			$_SESSION['user_id']=$row['user_id'];
			$_SESSION['user_name']=$row['username'];	
			$_SESSION['position']=$row['position'];
			$_SESSION['access']=$row['access'];	
			header("Location:index_camp_man.php");
			break;
			default:
			header("Location:login.html");
			break;
			
		}
    }	
} 
else{
header("Location:login.html");	
}
$conn->close();
?>