<?php
	session_start();
	$con=mysqli_connect("localhost","patric14_admin","o@KZj?Q6","patric14_taskmaster");

	// Set TaskID Variable
	$TaskID=$_GET['id'];

	if (mysqli_connect_errno()) 
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	// Set Date Completed Variable
	$DateCompleted  = date('Y-m-d H:i:s');
    $Reoccurance = $_SESSION['sess_Reoccurance'];
    
    if( $Reoccurance == 1)
    {
        $ListType = 'Reoccur';
    }
    else
    {
        $ListType ='Completed';
    }
    
	// Update user-task-list query
	mysqli_query($con,
				 "UPDATE user_task_list
				SET
				ListType ='$ListType'
				WHERE TaskID='$TaskID' 
				");

	//Update task query
	mysqli_query($con,
				 "UPDATE task
				SET
				DateCompleted = '$DateCompleted'
				WHERE TaskID='$TaskID' 
				");

	// Unset the session variables from editTask
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