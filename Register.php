<?php
$con=mysqli_connect("localhost","patric14_admin","o@KZj?Q6","patric14_taskmaster"); //Database Connection
session_start(); // Start the session

if(isset($_POST['username'])){
	$username = $_POST['username'];
	$_SESSION['sess_username'] = $username;
	
}
if(isset($_POST['password'])){
	$password = $_POST['password'];
}
if(isset($_POST['fName'])){
	$fname = $_POST['fName'];
}
if(isset($_POST['lName'])){
	$lname = $_POST['lName'];
}
	$CreationDate = date('Y-m-d H:i:s');


	mysqli_query($con,"INSERT INTO user (UserName,Password,FirstName,LastName,Role,CreationDate) VALUES('$username','$password','$fname','$lname','user',$CreationDate)");
	

	header("Location:GettingStarted.php");


	mysqli_close($con);
?>