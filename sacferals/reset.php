<?php
	session_start();
	include('authenticate.php');
	$link = connectdb($host, $user, $pass, $db);

	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{
		authenticateUser();
	}	
?>

<script type="text/javascript"> //phone validation

</script>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Reset</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!--<link rel="shortcut icon" href="images/sacferals.png" type="image/x-icon">-->
	<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="css/updateprofile.css">
	
	<!-- This must preceed any code that uses JQuery. It links out to that library so you can use it -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/script.js"></script>	
</head>
<body>

<?php
	if(isset($_POST['submit'])){
		//for users table
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];		
		
		if($username == "" || $email == "" || $password == "" || $repassword == ""){ //doesn't execute? 
			print "error: empty username, email, password";
		}
		else if($password != $repassword){
			/*echo '<div style="padding-bottom:10px">
					<div class="alert">
						<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
						error: passwords do not match</div></div>';*/
			$passerror = "style='border:1px solid #d66'";
			$passerrmsg = "<small>passwords do not match</small>";
		}
		else{ //all fields correct so far
			$querycheck = "select * from SacFeralsUsers where username='$username' or email='$email'";
			$resultcheck = mysqli_query($link, $querycheck);
						
			if(mysqli_num_rows($resultcheck)!= 0) {//for all users & user exists				
					$row = mysqli_fetch_array($resultcheck);
					$level = $row['level'];
					$query = "update SacFeralsUsers set username='$username',email='$email',password=SHA1('$password')
								where username='$username';";
					if(mysqli_query($link, $query)){
						echo "Password reset successfully. ";
						header('Refresh: .8; url=userprofile.php');
					}else{
						echo "Password reset failed. ";
					}								
			}
			else{ //error retrieving info from SacFeralsUsers table
				echo "You're not a SacFeralsUsers";
			}
		}
	}
	
	$level = $_SESSION['level'];
	if(($_SESSION['authenticate234252432341'] != 'validuser09821') || ($level != 1)){ //not logged in
		print "<h1>you aren't supposed to be here.. STOP SNEAKING AROUND</h1><br><br>";
		print "<a href='userprofile.php'>Back to Login page</a>";
	}
	else{ //logged in		
		$Ausername = $_SESSION['Ausername'];	
		
		if($_GET['RecordNumber'] != ''){
			$_SESSION['ResetRecordNumber'] = $_GET['RecordNumber'];
		}
		$RecordNumber=$_SESSION['ResetRecordNumber'];
		$query2 = "select * from SacFeralsUsers where email=(select Email from VolunteerForm where RecordNumber=$RecordNumber);";
		$result2 = mysqli_query($link, $query2);
		
		if (mysqli_num_rows($result2)==0){ 	 			
			print "<h4 style='color: RED'>No record found for this user. </h4>";			
		}
		else{
			$row2 = mysqli_fetch_array($result2);
			$email = $row2['email'];
			$Ausername = $row2['username'];
		}		
?>
	<h2> Reset User's Password </h2>
	<div id="form-wrapper">
		<form id="updateform" method="post" action="reset.php">
			<label for="inner-form"><h4>Account Information</h4></label>
			<div class="form-row" id="inner-form">
				<div class="form-group row">
					<label class="col-sm-4 col-form-label" for="username"> Username: </label>
					<div class="col-sm-6"><input class="form-control" type="text" id="username" name="username" required value="<?php echo $Ausername?>" readonly></div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label" for="email">Email:</label>
					<div class="col-sm-6">
						<input class="form-control" type="email" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" 
							placeholder="email@domain.com" required value="<?php echo $email?>" readonly>
						<span id="emailnote"><small>This is used to varify your identity, cannot be changed</small></span>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label" for="password">Password:</label>
					<div class="col-sm-6"><input class="form-control" type="password" id="password" name="password" required value="<?php echo $password?>" <?php echo $passerror?>></div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label" for="repass">Re-enter Password:</label>
					<div class="col-sm-6">
						<input class="form-control" type="password" id="repass" name="repassword" required value="<?php echo $password?>" <?php echo $passerror?>>
						<span id="passerrmsg"><?php echo $passerrmsg; ?></span>
					</div>
				</div>
			</div>
			<div class="form-row" id="buttons">
				<input class="btn" type="button" onclick="location.href='adminprofile.php'" value="Cancel">
				<input class="btn btn-primary" type="submit" name="submit" id="updatebtn" value="Update" >
			</div>
		</form>
	</div>
	
<?php 
} 
?>

<script>
$(document).ready(function () {
	$('#updateform input').on('keyup change', function(){
		var id = $(this)[0].id;
		if(id=='password' || id=='repass'){
			var pwd = $('#password').val();
			var repwd = $('#repass').val();
			if(pwd != repwd){
				$('#password').attr('style','border: 1px solid #d66');
				$('#repass').attr('style','border: 1px solid #d66');
				$('#passerrmsg').html("<small>passwords do not match</small>");
			} else if(pwd=='' || repwd==''){
				$('#repass').attr('style','border: 1px solid #d66');
				$('#passerrmsg').html("<small>passwords cannot be empty</small>");
			} else {
				$('#password').attr('style','');
				$('#repass').attr('style','');
				$('#passerrmsg').html("");
			}
		}
	});
	
	$('form input').on('keyup change', function(){
		var id = $(this)[0].id;
		if(id=='password' || id=='repass'){
			var pwd = $('#password').val();
			var repwd = $('#repass').val();
			if(pwd != repwd){
				$('#password').attr('style','border: 1px solid #d66');
				$('#repass').attr('style','border: 1px solid #d66');
				$('#passerrmsg').html("<small>passwords do not match</small>");
				$('#updatebtn').prop('disabled',true);
			} else if(pwd=='' || repwd==''){
				$('#repass').attr('style','border: 1px solid #d66');
				$('#passerrmsg').html("<small>passwords cannot be emtpy</small>");
				$('#updatebtn').prop('disabled',true);
			} else {
				$('#password').attr('style','');
				$('#repass').attr('style','');
				$('#passerrmsg').html("");
				$('#updatebtn').prop('disabled',false);
			}
		}
	});
});
</script>

</body>
</html>
