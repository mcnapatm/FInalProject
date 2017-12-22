<?php
	session_start();
	$con=mysqli_connect("localhost","patric14_admin","","patric14_taskmaster");

	if (mysqli_connect_errno()) 
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
	$TaskID = $_SESSION['sess_TaskID'];
	echo $TaskID;
	$TaskName=$_POST['editTaskName'];
	$TaskPriorityName=$_POST['editTaskPriority'];
	$TaskGrade=$_POST['editTaskGrade'];
	$TaskSubGrade=$_POST['editTaskSubGrade'];
	$DueDate=$_POST['editDueDate'];
	if(isset($_POST['editReoccuringYes']))
	{
		$Reoccuring = 1;
		$ReoccuranceNum = $_POST['editReoccuranceDays'];
		$ListType = 'Reoccur';
	}
	else
	{
		$Reoccuring = 0;
		$ReoccuranceNum = 0;
		$ListType = 'In Progress';
	}
	$TaskDescription=$_POST['editTaskDescription'];
	$UserID = $_SESSION['sess_username'];

	// Get Priority ID
	$query = "SELECT PriorityID FROM priority WHERE PriorityName='$TaskPriorityName' AND UserID='$UserID' ";
	$result = $con->query($query);
	$row =  $result->fetch_array();
	$PriorityID = $row['PriorityID'];
	
	mysqli_query($con,
				 "UPDATE task
				SET	TaskName ='$TaskName',
				TaskDescription='$TaskDescription',
				TaskGrade='$TaskGrade',
				TaskSubGrade='$TaskSubGrade',
				DateDue='$DueDate',
				Reoccurance='$Reoccuring',
				ReoccuranceNum='$ReoccuranceNum',
				PriorityID='$PriorityID'
				WHERE TaskID='$TaskID' 
				");
				
	// Insert into the user_task_list table
	mysqli_query($con,"UPDATE user_task_list
	                   SET
	                   ListType = '$ListType'
	                   WHERE UserID ='$UserID' AND TaskID = '$TaskID'");

	mysqli_close($con);
	
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
