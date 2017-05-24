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
		
		<h3>Level 1 access (admin): Guest1, 123</h3>
		<h3>Level 2 access (pleb): Guest2, abc</h3>";
	}
	//once you're logged in, show menu/options
	else 
	{
		$Ausername = $_SESSION['Ausername'];
		$level = $_SESSION['level'];
		
		if($level == 1)
		{
			print "<a href='logout.php' align='right'>Log out</a><br><br>";
			print "Welcome Master Administrator ".$Ausername."! <br><br>";
			print "(insert hub with links here)<br><br>";
		}
		else if($level == 2)
		{
			print "<h3 align='right'>Logged in as $Ausername </h3>";
			
			print "<a href='logout.php' style='float: right;'>Log out</a><br><br>";
			
			print "<b><u>Jobs volunteered for:</u></b>";
			
			print "<ul>
					  <li>job 1 (these will populate in upcoming build</li>
					  <li>job 2</li>
					  <li>job 3</li>
				   </ul>";
			
			print "<br><br><br><br>(availability table will appear in upcoming build)<br><br>";
			
			print "(job tables will appear in upcoming build)<br><br>";
		}

		
	}
?>

</body>
</html>