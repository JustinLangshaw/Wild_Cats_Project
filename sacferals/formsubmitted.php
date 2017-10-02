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
	<title>Form Submitted</title>
	<style>
	label {display: block;}
	</style>
</head>
<body>
<h1>Report form successfully submited.</h1>

<?php

	//if no ones logged in, print login screen
	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{ 
		print "<a href='http://www.sacferals.com/'>Back to Sac Ferals</a>";
	}
	else
	{
		print "You can close this window now."
		//print "<a href='userprofile.php'>Back to Profile</a>";
	}
?>

</body>
</html>
