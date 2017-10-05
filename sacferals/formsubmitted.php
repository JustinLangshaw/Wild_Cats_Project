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
	
	
	<style type="text/css">
	label {display: block;}
	body 
	{
		background-color: powderblue;
	}
	</style>	
</head>
<body>
<h1>Form successfully submited.</h1>
 <BLOCKQUOTE> You can close this window now.</BLOCKQUOTE><br><br>

 
 <body class="main_body">
<?php
	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{
		print "<a href=http://www.sacferals.com/>Back to Sac Ferals</a>";

	} else{
		print "<a href='userprofile.php' align='right'>Back to Profile</a><br><br>";		
	}
?>
</body>
</html>