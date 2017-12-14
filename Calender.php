<!-- User Varaible Declarations -->
<?php
session_start();
if(isset($_SESSION['sess_username'])){
	$username = $_SESSION['sess_username'];
	$userrole = $_SESSION['sess_userrole'];
}

?>


<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Calender</title>
	</head>

	<body>
		<header class="Header">
			<h1>Task Master</h1>
			<div class="HeaderLog">
				<h3><?php echo $_SESSION['sess_username']; ?></h3>
				<h4><a href="logout.php">Log Out</a></h4>
			</div>
			<div class="AboutLink">
				<p><a href="about.php">About</a></p>
			</div>
			<div class="ToDoLink">
				<p><a href="To_do_List.php">To-do</a></p>
			</div>
			<div class="CalenderLink">
				<p><a href="Calender.php">Calender</a></p>
			</div>
		</header>
	</body>
</html>