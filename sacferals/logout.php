<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>	
	<title>Testing Login</title>
	<style>
	body 
	{
		background-color: #5ab1c5;
	}
	label {display: block;}
	</style>
</head>
<body background: #5ab1c5>
<h1>You are logged out</h1>
<a href="userprofile.php">BACK</a>

</body>
</html>
