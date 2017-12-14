<?php
$con=mysqli_connect("localhost","patric14_admin","o@KZj?Q6","patric14_taskmaster"); //Database Connection
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
$username = $_SESSION['sess_username'];

	mysqli_query($con,"INSERT INTO Priority (PriorityName,UserName,PriorityWeight,PriorityDescription) VALUES('$PriorityNumber1','$username','1','$Priority_Description1'), 
	('$PriorityNumber2','$username','2','$Priority_Description2'), 
	('$PriorityNumber3','$username','3','$Priority_Description3')
	('$PriorityNumber4','$username','4','$Priority_Description4')
	('$PriorityNumber5','$username','5','$Priority_Description5')");
	
	header("Location:To_Do_List.php");


?>