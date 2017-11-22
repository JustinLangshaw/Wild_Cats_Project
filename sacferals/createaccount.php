<?php
	session_start();
	include('authenticate.php');
	$link = connectdb($host, $user, $pass, $db);
?>

<!DOCTYPE html>
<html lang="en">

<head>	
	<title>Create Account</title>
	<style type="text/css">
    .fieldset-auto-width 
	{
         display: inline-block;
    }
	</style>

	<link rel="stylesheet" type="text/css" href="userprofile.css" />
	
</head>

<body class="main_body">
<!-- <a href="createaccount.php">Clean</a> <br>

	<form method="post" action="createaccount.php">
		<div>
			<fieldset class='fieldset-auto-width'><legend>Create Account</legend>
			<label><input type='text' name='username'>User Name</label><br>
			<label><input type='password' name='password'>Password</label><br>
			<label><input type='password' name='repassword'>Re-Enter Password</label><br>
			<label><input type='text' name='email'>Email</label><br>
			<label><input type='submit' name='register' value='Register'></label><br>
			</fieldset>
		</div>
	</form>

	<h4>Please use the same email you used when submitting the volunteer form, otherwise we will have to manually add the jobs you selected.</h4>
 -->
 	<div class='main_login' style='margin-top:20px'>
		<div class='page-wrap'>
			<div class='main'>
				<div class='main_container'>
					<h1 class='main_heading'>Create Account</h1>
					<form class='form' role='form' method='post' action='createaccount.php'>
						<fieldset class='form_field'>
							<label class='form_label required'>Username</label>
							<input type='username' class='form_input' placeholder='Enter your username or email' required='required' name='username' value=''>
						</fieldset>
						<fieldset class='form_field'>
							<label class='form_label required'>Password</label>
								<input type='password' class='form_input' name='password' id='password_field' required='required' placeholder='Enter your password'>
						</fieldset>
						<fieldset class='form_field'>
							<label class='form_label required'>Re-Enter Password</label>
								<input type='password' class='form_input' name='repassword' id='password_field' required='required' placeholder='Re-Enter your password'>
						</fieldset>
						<fieldset class='form_field'>
							<label class='form_label required'>Email
								<i class="tooltip"><img src="https://shots.jotform.com/kade/Screenshots/blue_question_mark.png" height="13px"/>
									<span class="tooltiptext">Please use the same email used during submitting the volunteer form.</span>
								</i>
							</label>
								<input type='text' class='form_input' name='email' id='email_field' required='required' placeholder='Enter your email'>
						</fieldset>
						<button type='submit' class='button' name='register' style='background-color: #BE1D2C'>
		 					<div class='button_label'>Register</div>
						</button>

						<div class='main_heading-2'>
							<a href='userprofile.php'>Back to login</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

<?php	


if(isset($_POST['register'])) //this processes after user submits data.
{
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	
	$re =  "/^[a-zA-Z0-9]{4,10}$/";	//username must be length 4+ with only number and letters
	$reEmail = "/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/";	//check proper format of email
	
	if($username == "" || $email == "" || $password == "" || $repassword == "")//doesn't execute? 
	{
		print "error: please fil out all fields";
	}
	else if($password != $repassword)
	{
		print "error: passwords do not match";
	}
	else 
	{	
		//if user passes re test
		if( (preg_match($re, $username)) && (preg_match($reEmail, $email)) )
		{	//display current table
			$querycheck = "select * from SacFeralsUsers where username='$username' or email='$email'";
			$resultcheck = mysqli_query($link, $querycheck); //link query to database
			
			if(mysqli_num_rows($resultcheck) == 0)// test if query does "nothing", and thus has no records
			{	//if not, record doesn't exist so you can process the insert query
				$query = "insert into SacFeralsUsers values('', '$username', '$email', '$password', '0')";
				mysqli_query($link, $query); //link query to database
				print "Account Created"; // print confirmation	
				
			
			}
			else
			{
				print "error: That account name or email already exists";
			}
		}
		else
		{
			print "error: Please use no special characters when creating username and make sure your email is valid.";
		}
	}
} 
	
?>
	

</body>

</html>
