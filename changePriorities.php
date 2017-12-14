<?php
	session_start();
	$con=mysqli_connect("localhost","patric14_admin","o@KZj?Q6","patric14_taskmaster");
	

	$Priority1 = $_POST['PriorityOne'];
	$Priority1Description = $_POST['Priority1Description'];
	$Priority2 = $_POST['PriorityTwo'];
	$Priority2Description = $_POST['Priority2Description'];
	$Priority3 = $_POST['PriorityThree'];
	$Priority3Description = $_POST['Priority3Description'];
	

	//Get User ID
	$user = $_SESSION['sess_username'];
	$getUserID = "SELECT UserID FROM user WHERE UserName='$user'";
	$UserIDResult = $con->query($getUserID);
	$UserIDRow = $UserIDResult->fetch_array();
	$UserID = $UserIDRow['UserID'];


	mysqli_query($con,
				 "UPDATE priority
				SET	PriorityName ='$Priority1',
				PriorityDescription ='$Priority1Description'
				WHERE PriorityWeight = 1 AND UserID = '$UserID';
				");

	mysqli_query($con,
				 "UPDATE priority
				SET	PriorityName ='$Priority2',
				PriorityDescription ='$Priority2Description'
				WHERE PriorityWeight = 2 AND UserID= '$UserID';
				");

	mysqli_query($con,
				 "UPDATE priority
				SET	PriorityName ='$Priority3',
				PriorityDescription ='$Priority3Description'
				WHERE PriorityWeight = 3 AND UserID = '$UserID';
				");

	if(isset($_POST['PriorityFour']))
	{
		$Priority4 = $_POST['PriorityFour'];
		$Priority4Description = $_POST['Priority4Description'];
		echo $Priority4;
		mysqli_query($con,
				 "UPDATE priority
				SET	PriorityName ='$Priority4',
				PriorityDescription ='$Priority4Description'
				WHERE PriorityWeight = 4 AND UserID = '$UserID';
				");
	}
	if(isset($_POST['PriorityFive']))
	{
		$Priority5 = $_POST['PriorityFive'];
		$Priority5Description = $_POST['Priority5Description'];
		mysqli_query($con,
				 "UPDATE priority
				SET	PriorityName ='$Priority5',
				PriorityDescription ='$Priority5Description'
				WHERE PriorityWeight = 5 AND UserID = '$UserID';
				");
	}


	header("Location:To_Do_List.php");

?>
