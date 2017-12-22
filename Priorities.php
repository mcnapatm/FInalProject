<?php
$con=mysqli_connect("localhost","patric14_admin","","patric14_taskmaster"); //Database Connection
session_start(); // Start the session

$PriorityNumber1 = $_POST['Priority_1'];
$Priority_Description1=$_POST['Priority_Description1'];
$PriorityNumber2 = $_POST['Priority_2'];
$Priority_Description2=$_POST['Priority_Description2'];
$PriorityNumber3 = $_POST['Priority_3'];
$Priority_Description3=$_POST['Priority_Description3'];
$PriorityNumber4 = '';
$Priority_Description4= '';
$PriorityNumber5 = '';
$Priority_Description5= '';

	$user = $_SESSION['sess_username'];
	$getUserID = "SELECT UserID FROM user WHERE UserName='$user'";
	$UserIDResult = $con->query($getUserID);
	$UserIDRow = $UserIDResult->fetch_array();
	$UserID = $UserIDRow['UserID'];


	mysqli_query($con,"INSERT INTO priority (UserID,PriorityName,PriorityWeight,PriorityDescription) VALUES('$UserID','$PriorityNumber1','1','$Priority_Description1'), 
	('$UserID','$PriorityNumber2','2','$Priority_Description2'),
	('$UserID','$PriorityNumber3','3','$Priority_Description3'),
	('$UserID','$PriorityNumber4','4','$Priority_Description4'),
	('$UserID$','$PriorityNumber5','5','$Priority_Description5')");
	
	header("Location:To_Do_List.php");


?>
