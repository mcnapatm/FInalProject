
<!doctype html>

<html>
	<head>
		<!--Link to Stylesheet -->
		<link rel="stylesheet" type="text/css" href="Style/taskmaster.css">
		
		<!--Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		
		<!-- Bootstrap Scripts -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
		<meta charset="utf-8">
		<title>Registration</title>
	</head>

	<body class="body">
		<!-- Header Panel with User Information and Links -->
		<header class="Header">
			<div class="Title">
				<h1>Task Master</h1>
			</div>
			<div class="HeaderLog">
				<div>
				</div>
				<div>
				</div>
			</div>
			<div class="Links">
				<div>
				</div>
				<div class="AboutLink">
						<p><a href="Index.php">Log In</a></p>
				</div>
				<div>
				</div>
			</div>
		</header>
	
		<h1 class="Registration_Title">Registration</h1>
		<form class="Registration_Form" name="Registration_Form" action="Register.php" method="post">
			<div>
				<!-- Registration Input-->
				<p>User Name: <input type="text" name="username" /></p>
				<p>Password: <input type="text" name="password" /></p>
				<p>First Name: <input type="text" name="fName" /></p>
				<p>Last Name: <input type="text" name="lName" /></p>
				<button  type="submit" name="Registration_Submit">Submit</button>

			</div>
		</form>
	</body>
</html>