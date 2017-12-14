<?php
require 'connect.php'; //Database Connection
session_start(); // Start the session

if(isset($_POST['username'])){
	$username = $_POST['username'];}

if(isset($_POST['password'])){
	$password = $_POST['password'];
	$pass = $password; //entered password
}

// Check whether the entered username/password pair exist in the Database
$q = 'SELECT * FROM user WHERE UserName=:username AND Password=:password';
$query = $db->prepare($q);
$query->execute(array(':username' => $username, ':password' => $pass));

if($query->rowCount() == 0)
{
	header('Location: Index.php?err=1');}
else{
	// fetch the result as assoctaitive array
	$row = $query->fetch(PDO::FETCH_ASSOC);
	
	// Store the fetched details into $_SESSION
	$_SESSION['sess_username'] = $row['UserName'];
	$_SESSION['sess_userrole'] = $row['Role'];
	
		header('Location: To_Do_List.php');
}
?>