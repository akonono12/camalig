<?php
session_start();
$conn = mysql_connect('localhost', 'root', '');
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('capstone');
?>
<?php
$fname=$_POST['fname'];
$bdate=$_POST['bdate'];
$uname=$_POST['uname'];
$upass=$_POST['upass'];
$uaccess=$_POST['uaccess'];
	
	mysql_query("INSERT INTO users (fullname, bdate, username, password, access) VALUES ('$fname','$fname','$bdate','$upass','$uaccess')");
				header("location:list_accounts.php?msg=Successfully added!");
?>