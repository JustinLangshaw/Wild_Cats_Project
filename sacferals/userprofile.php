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
<head>	
	<title>User Profile</title> 
	
	<style type="text/css">
    .fieldset-auto-width 
	{
         display: inline-block;
    }
	</style>

</head>

<body>
<?php

	//if no ones logged in, print login screen
	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{ 
		print "<a href='createaccount.php'>Create Account</a>";

		print "<form method='post' action='userprofile.php'>
		<div><fieldset class='fieldset-auto-width'>
		<legend>Login</legend>
		<label><input type='text' name='username'>User Name</label><br>
		<label><input type='password' name='pass'>Password</label><br>
		<label><input type='submit' name='login' value='Login'></label>
		</fieldset></div>
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
			print "<b>Welcome Master Administrator ".$Ausername."!</b> <br><br>";
			print "<div><fieldset class='fieldset-auto-width'>";
			print "- <a href='search.php' align='right'>View/Edit Database</a><br>";
			print "- <a href='changeaccounttype.php' align='right'>Change User Account Types</a><br>";
			print "- <a href='volunteerlist.php' align='right'>View Volunteers</a><br>";
			
			
			print "<br><a href='volunteerform.php' align='right'>volunteer form</a> for testing purposes<br>";
			print "</fieldset></div>";
		}
		else if($level == 2)
		{
			print "<h3 align='right'>Logged in as $Ausername </h3>";
			
			print "<a href='logout.php' style='float: right;'>Log out</a><br><br>";
			
			print "<b><u>Jobs volunteered for:</u></b>";
			
			print "<ul>
					  <li>job 1 (these will populate in upcoming build)</li>
					  <li>job 2</li>
					  <li>job 3</li>
				   </ul>";
			
			print "<br><br>(availability table will appear in upcoming build)<br><br>";
			
			print "(job tables will appear in upcoming build)<br><br>";
		}

		
	}
?>

</body>
</html>