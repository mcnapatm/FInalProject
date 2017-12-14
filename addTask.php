<?php
	session_start();
	$con=mysqli_connect("localhost",'patric14_admin','o@KZj?Q6','patric14_taskmaster');

	if (mysqli_connect_errno()) 
	{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	//Variable Declarations
	$TaskName=$_POST['addTaskName'];
	$TaskPriority=$_POST['addTaskPriority'];
	$TaskGrade=$_POST['addTaskGrade'];
	$TaskSubGrade=$_POST['addTaskSubGrade'];
	$DateEntered=date("Y-m-d");
	$DueDate=$_POST['addDueDate'];
	$TaskDescription=$_POST['addTaskDescription'];

    
	//Set Reoccurance field if it exists
	if(isset($_POST['addReoccuring']))
	{
        if($_POST['addReoccuring'] == 'Yes')
    	  {
    	    $Reoccuring = 1;
    		$ReoccuranceNum =$_POST['addReoccuranceDays'];
    		$ListType = 'Reoccur';
    	  }
        else
    	{
    		$Reoccuring = 0;
    		$ReoccuranceNum = 0;
    		$ListType = 'In Progress';
    	}  
	}
	else
	{
	    $Reoccuring = 0;
    	$ReoccuranceNum = 0;
    	$ListType = 'In Progress';
	}
    

	//Get User ID
	$user = $_SESSION['sess_username'];
	$getUserID = "SELECT UserID FROM user WHERE UserName='$user'";
	$UserIDResult = $con->query($getUserID);
	$UserIDRow = $UserIDResult->fetch_array();
	$UserID = $UserIDRow['UserID'];

 
	// Get Priority ID
	$query = "SELECT PriorityID FROM priority WHERE PriorityName='$TaskPriority' AND UserID='$UserID' ";
	$result = $con->query($query);
	$row =  $result->fetch_array();
	$PriorityID = $row['PriorityID'];
	
	
	//Insert Task into database
	mysqli_query($con,"INSERT INTO task (TaskName,TaskDescription,TaskGrade,TaskSubGrade,DateEntered,DateDue,Reoccurance,ReoccuranceNum,PriorityID)
					VALUES ('$TaskName','$TaskDescription','$TaskGrade','$TaskSubGrade','$DateEntered','$DueDate','$Reoccuring','$ReoccuranceNum','$PriorityID')");
	
	// Get auto incremented Task ID
	$query = "SELECT TaskID FROM task WHERE TaskName='$TaskName'";
	$result = $con->query($query);
	$row =  $result->fetch_array();
	$TaskID = $row['TaskID'];


	// Insert into the user_task_list table
	mysqli_query($con,"INSERT INTO user_task_list(UserID,TaskID,ListType) VALUES('$UserID','$TaskID','$ListType')");
	


	mysqli_close($con);

	header("Location:To_Do_List.php");
?>