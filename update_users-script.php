<?php
session_start();
require_once('connection/conn.php');
if(!isset($_SESSION['user_id']) or $_SESSION['access']!="admin"){
	header("location:login.html");	
}
?>
<?php
	$uid=$_POST['uid'];
	$fname=$_POST['fname'];
	$uname=$_POST['uname'];
	$upass=$_POST['upass'];
	$uaccess=$_POST['uaccess'];
	$status=$_POST['status'];

	//echo $uid;
	$sql = "UPDATE users SET full_name='$fname', username='$uname', password='$upass', access='$uaccess', status='$status' WHERE user_id='$uid'";
		if ($conn->query($sql) === TRUE) {	
			header("location:manage_accounts.php?msg=Successfully updated!");		
		}
		else {
				echo "Error updating record: " . $conn->error;
			}
?>