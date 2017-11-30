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
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!--<link rel="shortcut icon" href="images/sacferals.png" type="image/x-icon">-->
	<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="css/userprofile.css" />  
	
	<!-- This must preceed any code that uses JQuery. It links out to that library so you can use it -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="userprofile.js"></script>

</head>

<body class="main_body">
<?php

	//if no ones logged in, print login screen
	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{  
		//print "<a href='createaccount.php'>Create Account</a>";
?>
	<div class='main_login' style='margin-top:20px'>
		<div class='page-wrap'>
			<div class='main'>
				<div class='main_container'>
					<h1 class='main_heading'>Log in</h1>
					<form class='form' role='form' method='post' action='userprofile.php'>
						<fieldset class='form_field'>
							<label class='form_label required'>Username</label>
							<input type='username' class='form_input' placeholder='Enter your username or email' 
												required='required' name='username' value=''>
						</fieldset>

						<fieldset class='form_field'>
							<label class='form_label required'>Password</label>
								<input type='password' class='form_input' name='pass' id='password_field' 
												required='required' placeholder='Enter your password'>
						</fieldset>
						
						<button type='submit' id='login' class='button' name='login' style='background-color: #BE1D2C'>
							<div class='button_label'>Log in</div>
						</button>

						<div class='main_heading-2'>
							<a href='createaccount.php'>Create Account</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php
	}
	//once you're logged in, show menu/options
	else 
	{
		$Ausername = $_SESSION['Ausername'];
		$level = $_SESSION['level'];

		header("Location: search.php");
	}
?>

</body>
</html>