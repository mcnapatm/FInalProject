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
		<!--Link to Stylesheet -->
		<link rel="stylesheet" type="text/css" href="Style/taskmaster.css">
		<meta charset="utf-8">
		<title>About Task Master</title>
	</head>

	<body class="body">
		<!-- Header Panel with User Information and Links -->
		<header class="Header">
			<div class="Title">
				<h1>Task Master</h1>
			</div>
			<div class="HeaderLog">
				<div class="AboutLink">
						<p><a href="To_Do_List.php">To Do List</a></p>
				</div>
				<p><?php echo $_SESSION['sess_username']; ?><br/><a href="logout.php">Log Out</a></p>
			</div>
		</header>
	<div class="AboutContainer">
		<div class="aboutSection">
			<h1>About</h1>
				<p>Hello and welcome to Task Master. Do you ever feel like you aren't getting enough done during the day? Have you ever felt busy all day and look back and feel like you got nothing accomplished. Task Master is system that anyone can use to help them get more accomlished in their everyday life! 
				</p>
		</div>
		<div class="aboutSection">
			<h1>How to Rank Tasks</h1>
				<p>When you first enter a task into our task mangerment system you assign it with with a letter A through E. Heres how the letters are graded.
					<ul>
						<li>An “A” task is defined as something that is very important, something that you must do. This is a task that will have serious positive or negative consequences if you do it or fail to do it. </li>
						<li>A “B” task is defined as a task that you should do. </li>
						<li>A “C” task is defined as something that would be nice to do. </li>
						<li>A “D” task is defined as something you can delegate to someone else.</li>
						<li>An “E” task is defined as something that you can eliminate altogether.</li>
					</ul>
				</p>
		</div>
		<div class="aboutSection">
			<h1>Choosing Priorties</h1>
			<p>
				Everytime you you choose a task you also get to choose which priorties to asscociate with it. When you first sign up you are ask to choose what the three most important areas of your life are. These three things will help dictate what you want and/or need to get most on you list of things to do. This combined with the letter grading should allow you to accomplish things that impact your life the most!
			</p>
		</div>
	</div>
	</body>
</html>