<?php
	session_start();
	$con=mysqli_connect("localhost","patric14_admin","o@KZj?Q6","patric14_taskmaster");

	//Set Task ID
	$TaskID=$_GET['id'];

	if (mysqli_connect_errno()) 
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	mysqli_query($con,
				 "DELETE FROM user_task_list
				WHERE TaskID='$TaskID' 
				");

	mysqli_query($con,
				 "DELETE FROM task
				WHERE TaskID='$TaskID' 
				");

	//Unset Session Variables
	unset($_SESSION['sess_TaskID']);
	unset($_SESSION['sess_TaskName']);
	unset($_SESSION['sess_TaskDescription']);
	unset($_SESSION['sess_TaskGrade']);
	unset($_SESSION['sess_TaskSubGrade']);
	unset($_SESSION['sess_DateEntered']);
	unset($_SESSION['sess_DateDue']);
	unset($_SESSION['sess_Reoccurance']);
	unset($_SESSION['sess_ReoccuranceNum']);
	unset($_SESSION['sess_PriorityName']);
	unset($_SESSION['sess_PriorityID']);
	
	header("Location:To_Do_List.php");
	
?>