<?php
session_start();
require_once('connection/conn.php');
if(!isset($_SESSION['user_id']) or $_SESSION['access']!="admin"){
	header("location:login.html");	
}
?>
<?php
$nagoods=$_POST['nagoods'];
$qty=$_POST['qty'];
$e_center=$_POST['e_center'];
$disaster=$_POST['disaster'];
$ddelivery=$_POST['ddelivery'];
$uid=$_POST['uid'];
$cyear=date('Y');
$disaster=	$_POST['disaster'];
	$sql="INSERT INTO distribution (r_goods_id, qty,evac_id, d_distribute, process_by,year,disaster)
	VALUES ('$nagoods','$qty',$e_center,'$ddelivery','$uid',$cyear,$disaster)";
		if ($conn->query($sql) === TRUE) {	
			header("location:distributed_relief_report.php?msg=Distribution Successfully processed!");		
		}
?>