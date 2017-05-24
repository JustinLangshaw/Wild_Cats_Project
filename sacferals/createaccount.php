<?php
	session_start();
	include('authenticate.php');
	$link = connectdb($host, $user, $pass, $db);
?>

<!DOCTYPE html>
<html lang="en">

<head>	
	<title>Create Account</title>
	<style>
	label {display: block;}
	</style>
</head>

<body>
	<h1>Enter Details</h1>

<a href="createaccount.php">Clean</a> <br>

	<form method="post" action="createaccount.php">
		<fieldset><legend>Create Account</legend>
		<label><input type='text' name='username'>User Name</label>
		<label><input type='password' name='password'>Password</label>
		<label><input type='password' name='repassword'>Re-Enter Password</label>
		<label><input type='text' name='email'>Email</label>
		<label><input type='submit' name='register' value='Register'></label>
		</fieldset>
	</form>


<?php	


if(isset($_POST['register'])) //this processes after user submits data.
{
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	
	$re = "/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
	$reEmail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/";
	
	//if user passes re test
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
		if( preg_match($re, $username) && preg_match($reEmail, $email) )
		{	//display current table
			$querycheck = "select * from SacFeralsUsers where username='$username' or email='$email'";
			$resultcheck = mysqli_query($link, $querycheck); //link query to database
			
			if(mysqli_num_rows($resultcheck) == 0)// test if query does "nothing", and thus has no records
			{//if not, record doesn't exist so you can process the insert query
				$query = "insert into SacFeralsUsers values('', '$username', '$email', '$password', '2')";
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
			print "error: Please use no special characters when creating username";
		}
	}
} 
	
?>
	
	
	<br>
	<a href="userprofile.php">Back to login</a>

</body>

</html>
