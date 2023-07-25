<?php
session_start();
require_once('connection/conn.php');
?>
<?php
$arain=$_POST['arain'];
$ss_signal=$_POST['ss_signal'];
$uid=$_POST['uid'];

	
	$sql="INSERT INTO disaster_report (amount_water, ss_signal, process_by)
	VALUES ('$arain','$ss_signal','$uid')";
		if ($conn->query($sql) === TRUE) {	
			header("location:post_report.php?msg=POST Successfully added!");		
		}
?>