<?php

session_start();
$con=mysqli_connect("localhost","patric14_admin","","patric14_taskmaster");

$TaskID=$_GET['id'];

if (mysqli_connect_errno()) 
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Get task info
$query = "SELECT * FROM task WHERE TaskID='$TaskID'";
$result = $con->query($query);
$row =  $result->fetch_array();


//Set variable Sessions
$_SESSION['sess_TaskID'] = $TaskID;
$_SESSION['sess_TaskName'] = $row['TaskName'];
$_SESSION['sess_TaskDescription'] = $row['TaskDescription'];
$_SESSION['sess_TaskGrade'] = $row['TaskGrade'];
$_SESSION['sess_TaskSubGrade'] = $row['TaskSubGrade'];
$_SESSION['sess_DateEntered'] = $row['DateEntered'];
$_SESSION['sess_DateDue'] = $row['DateDue'];
$_SESSION['sess_Reoccurance'] = $row['Reoccurance'];
$_SESSION['sess_ReoccuranceNum'] = $row['ReoccuranceNum'];
$_SESSION['sess_PriorityID'] = $row['PriorityID'];

//Get Priority Name and Info
$PriorityID = $_SESSION['sess_PriorityID'];
$getPriorityName = "SELECT PriorityName FROM priority WHERE PriorityID='$PriorityID'";
$PriorityNameResult = $con->query($getPriorityName);
print_r($PriorityNameResult);
$PriorityNameRow = $PriorityNameResult ->fetch_array();
$PriorityName = $PriorityNameRow['PriorityName'];

$_SESSION['sess_PriorityName'] = $PriorityName;



header("Location:To_Do_List.php");


?>
