<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'capstone');
if (!$conn) {
    die('Could not connect: ' . mysqli_error());
}

?>
<?php
$ec_id=$_POST['ec_id'];
$ehead=$_POST['ehead'];
$etotal=$_POST['etotal'];
$no_preg=$_POST['no_preg'];
$no_kid=$_POST['no_kid'];
$no_male=$_POST['no_male'];
$no_female=$_POST['no_female'];
$no_adult=$_POST['no_adult'];
$no_elder=$_POST['no_elder'];

$add_date=$_POST['add_date'];
$uid=$_POST['uid'];

	
	mysqli_query($conn, "INSERT INTO evacuee_report (evac_id, name_head, no_member, date_added,pr_id,no_pregnant, no_kids, no_male, no_female, no_elderly) VALUES ('$ec_id','$ehead','$etotal','$add_date','$uid','$no_preg','$no_kid','$no_male','$no_female','$no_elder')");
	header("location:evacuation_report.php?msg=Successfully reported!");
?>