<?php
	session_start();
	include('authenticate.php');
	$link = connectdb($host, $user, $pass, $db);

	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{
	authenticateUser();
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>	<title>User Profile</title> </head>

<body>
<?php

	//if no ones logged in, print login screen
	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{ 
		print "<a href='createaccount.php'>Create Account</a>";

		print "<form method='post' action='userprofile.php'>
		<fieldset><legend>Login</legend>
		<label><input type='text' name='username'>User Name</label><br>
		<label><input type='password' name='pass'>Password</label><br>
		<label><input type='submit' name='login' value='Login'></label>
		</fieldset>
		</form>
		
		<h3>Level 1 access: Guest1, 123</h3>
		<h3>Level 2 access: Guest2, abc</h3>";
	}
	//once you're logged in, show menu/options
	else 
	{
		$Ausername = $_SESSION['Ausername'];
		$level = $_SESSION['level'];
		//$roomnumber = $_SESSION['roomnumber'];
		
		print "<a href='logout.php'>Log out</a>";
		print "<h1>Logged in as $Ausername (level $level )</h1>";

		
	}
?>

</body>
</html>