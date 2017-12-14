<?php
session_start();
if(isset($_SESSION['sess_username']))
{
	$username = $_SESSION['sess_username'];
}


?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="Style/taskmaster.css">
		<title>Getting Started</title>
	</head>

	<body class="body">
		<div class="GettingStarted">
		<h1>Hello <?php $username ?> and Welcome to Task Master!</h1>
			<p>
				Thank you for signing up for Task Master. Task Master is
				in its most simple form is a To-Do List. Keeping track of everything you want to get done in todays busy world can challenging. Task master is here to help you rise up to that callenge. Heres how it works. First you list the three things in you life that are most important to you. That could be school, work, family or anything else that is a huge part of your life. 
				Once you have your priorites in order you can start adding tasks to your list. When you add a task you choose whether its a part of your top priorities and how much of an impact it has on your life if it does or does not get done. Lets start by inputting your priorities below.
			</p>
		</div>
		<div class="PriorityClass">
			<form name="Priorities" action="Priorities.php" method="post">
				<h2 class="PriorityTitle">1st Priority</h2>
					<input type="text" name="Priority_1"></br>
						<h3>1st Priority Description</h3>
							<textarea name="Priority_Description1"></textarea>
		</div>
		<div class="PriorityClass">
			<h2 class="PriorityTitle">2nd Priority</h2>
				<input type="text" name="Priority_2"></br>
					<h3>2nd Priority Description</h3>
						<textarea name="Priority_Description2"></textarea>
		</div>
		<div class="PriorityClass">			
			<h2 class="PriorityTitle">3rd Priority</h2>
				<input type="text" name="Priority_3"></br>
					<h3>3rd Priority Description</h3>
						<textarea name="Priority_Description3"></textarea>
		
		</div>
		</br><button style="submit" class="btn2">Input Priorities</button>	
		</form>
		
	</body>
</html>