<?php
	session_start();
	include('authenticate.php');
	$link = connectdb($host, $user, $pass, $db);
?>

<!DOCTYPE html>
<html lang="en">

<head>	
	<title>Create Account</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!--<link rel="shortcut icon" href="images/sacferals.png" type="image/x-icon">-->
	<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="css/userprofile.css">
	
	<!-- This must preceed any code that uses JQuery. It links out to that library so you can use it -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
	
</head>

<body class="main_body">

<?php
if(isset($_POST['register'])) //this processes after user submits data.
{	
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$repassword = $_POST['repassword'];
	
	$re = "/(?=^.{3,20}$)^[a-zA-Z][a-zA-Z0-9]*[_.-]?[a-zA-Z0-9]+$/";
	$reEmail = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$/";
	
	if($username == "" || $email == "" || $password == "" || $repassword == "")//doesn't execute? 
	{
		print "error: please fil out all fields";
	}
	else if($password != $repassword)
	{
		$passerror = "style='border:1px solid #d66'";
		$passerrmsg = "<small>passwords do not match</small>";
	}
	else 
	{
		//if user passes re test
		if( preg_match($re, $username) && preg_match($reEmail, $email) )
		{	//check if a current user already had the username and email
			$querycheck = $link->prepare("select * from SacFeralsUsers where username=? or email=?");
			$querycheck->bind_param("ss", $username, $email);
			$querycheck->execute();//link query to database
			$querycheck->store_result();
			if(!$querycheck->fetch()){ 
				$resultcheck = 0;
			} else{
				$resultcheck = $querycheck->num_rows;
			}
			$querycheck->close(); 

			if($resultcheck == 0)// test if query does "nothing", and thus has no records
			{	//if not, record doesn't exist check if filled out a volunteer form (using email)
				$reprtformcheck = $link->prepare("select * from VolunteerForm where email=?");
				$reprtformcheck->bind_param("s", $email);
				$reprtformcheck->execute();
				$reprtformcheck->store_result();
				if(!$reprtformcheck->fetch()){
					$res = 0;
				}else{
					$res = $reprtformcheck->num_rows;
				}
				$reprtformcheck->close();			
				
				if($res != 0){ //email not in user & is in volunteerform
					$query = $link->prepare("insert into SacFeralsUsers values(NULL, ?, ?, SHA1(?), '0')");
					$query->bind_param("sss", $username, $email, $password);
					$query->execute();
					$query->close();
					$msg="Success: Account created for $username."; // print confirmation	
					$fontcolor="green";
				}
				else {

					$msg="Error: Must fill out a volunteer form first.";
					$fontcolor="red";

				}
			}
			else
			{

				$msg="Error: That username or email already exists.";
				$fontcolor="red";
			}			
			$link->close();

		}
		else
		{
			$msg="Error: Username must start with a letter and end with a letter or number. Allowed special characters: underscore, dot, dash. Make sure your email is valid.";
			$fontcolor="red";
		}
	}
} 
	
?>

	<div class='main_login' style='margin-top:20px'>
		<div class='page-wrap'>
			<div class='main'>
				<div class='main_container'>
					<h1 class='main_heading'>Create Account</h1>
					<form class='form' id="createaccountform" role='form' method='post' action='createaccount.php'>
						<fieldset class='form_field'>
							<font color="<?php echo $fontcolor?>" size=2.5><label id="error" name="error" ><?php echo $msg?></label></font>
							<label class='form_label required'>Username</label>
							<input type='username' class='form_input' placeholder='Enter your username or email' required='required' name='username'
								pattern="(?=^.{3,20}$)^[a-zA-Z][a-zA-Z0-9]*[_.-]?[a-zA-Z0-9]+$" title="Must start with a letter and end with a letter or number. Allowed special characters: underscore, dot, dash">
						</fieldset>
						<fieldset class='form_field'>
							<label class='form_label required' for="email">Email Address
								<div id="tooltip"><img src="images/blue_question_mark.png" alt="?"/>
									<span class="tooltiptext">Use the exact same email used during submitting the volunteer form.</span>
								</div>
							</label>
							<input type='email' class='form_input' name='email' id='email_field' required='required' 
								pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" placeholder="email@domain.com">
						</fieldset>

						<fieldset class='form_field'>
							<label class='form_label required'>Password</label>
							<input type='password' class='form_input' name='password' id='password' required='required' placeholder='Enter your password' <?php echo $passerror?>>
						</fieldset>
						<fieldset class='form_field'>
							<label class='form_label required'>Re-Enter Password</label>
							<input type='password' class='form_input' name='repassword' id='repass' required='required' placeholder='Re-Enter your password' <?php echo $passerror?>>
							<span id="passerrmsg"><?php echo $passerrmsg; ?></span>	
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
	
<script>
$(document).ready(function () { 
	$('#createaccountform input').on('keyup change', function(){
		var id = $(this)[0].id;
		if(id=='password' || id=='repass'){
			var pwd = $('#password').val();
			var repwd = $('#repass').val();
			if(pwd != repwd){
				$('#password').attr('style','border: 1px solid #d66');
				$('#repass').attr('style','border: 1px solid #d66');
				$('#passerrmsg').html("<small>passwords do not match</small>");
				$('#reg').attr('disabled',true);
			} else if(pwd=='' || repwd==''){
				$('#repass').attr('style','border: 1px solid #d66');
				$('#password').attr('style','border: 1px solid #d66');
				$('#passerrmsg').html("<small>passwords cannot be emtpy</small>");
				$('#reg').attr('disabled',true);
			} else {
				$('#password').attr('style','');
				$('#repass').attr('style','');
				$('#passerrmsg').html("");
				$('#reg').attr('disabled',false);
			}
		}
	});
});
</script>

</body>
</html>
