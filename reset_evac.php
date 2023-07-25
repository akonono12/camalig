<?php
session_start();
require_once('connection/conn.php');
if(!isset($_SESSION['user_id']) or $_SESSION['access']!="admin"){
	header("location:login.html");	
}
?>
<?php
	$sql = "UPDATE evacuee_report SET status='notActive' where status='active'";
		if ($conn->query($sql) === TRUE) {	
			header("location:evacuation_report.php?msg=Successfully reset!");		
		}
		else {
				echo "Error updating record: " . $conn->error;
			}
?>