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

function formatPhone(phoneId) {
	var startCursor = $("#"+phoneId).get(0).selectionStart,
		endCursor = $("#"+phoneId).get(0).selectionEnd;

	var output;
    var input = $("#"+phoneId).val();
	input = input.replace(/[^0-9]/g, '');
	var area = input.substr(0, 3);
    var pre = input.substr(3, 3);
    var tel = input.substr(6, 4);

	if (input.length >= 10){
		output = input.replace(/^(\d{3})(\d{3})(\d{4})+$/, "($1)$2-$3");

	} else {
		output = input;
	}
	$("#"+phoneId).val(output);
	$("#"+phoneId).get(0).setSelectionRange(startCursor, endCursor);
}

</script>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Edit Profile</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!--<link rel="shortcut icon" href="images/sacferals.png" type="image/x-icon">-->
	<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="css/updateprofile.css">
	
	<!-- This must preceed any code that uses JQuery. It links out to that library so you can use it -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="script.js"></script>
	
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
				
				//else {
					$row = mysqli_fetch_array($resultcheck);
					$level = $row['level'];
					$query = "update SacFeralsUsers set username='$username',email='$email',password='$password'
								where username='$username'";
					
					if($level==2){ //if a triage user
						//for report form
						$fullname = $_POST['fullname'];
						$completeaddress = $_POST['completeaddress'];
						$phone1 = $_POST['phone1'];
						$phone2 = $_POST['phone2'];

						//arrays of checkboxes
						$contact = $_POST['contact'];
						$typeofwork = $_POST['typeofwork'];

						$contactemail;
						$contactphone1;
						$contactphone2;

						//put in loop like typeofworkstring
						$preferedcontact= $contact[0].", ".$contact[1].", ".$contact[2];
						$typeofworkstring='';
						if (count($typeofwork)!=0){
							$typeofworkstring = $typeofwork[0];
							for ($i=1; $i<count($typeofwork); $i++){
								$typeofworkstring = $typeofworkstring.",".$typeofwork[$i];
							}
						}

						if($contact[0]!='') $contactemail=1; else $contactemail=0;
						if($contact[1]!='') $contactphone1=1; else $contactphone1=0;
						if($contact[2]!='') $contactphone2=1; else $contactphone2=0;
						
						if($typeofwork[0]!='') $transporting=1; else $transporting=0;
						if($typeofwork[1]!='') $helptrap=1; else $helptrap=0;
						if($typeofwork[2]!='') $helpeducate=1; else $helpeducate=0;
						if($typeofwork[3]!='') $usingphone=1; else $usingphone=0;
						if($typeofwork[4]!='') $helpingclinic=1; else $helpingclinic=0;
						if($typeofwork[5]!='') $other=1; else $other=0;

						$othertasks = $_POST['othertasks'];
						$experience = $_POST['experience'];

						//re's need updating for all fields. or we can use javascript (better)
						$reEmail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/";
						$re2 = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
						
						if(preg_match($re2, $fullname) ) {
							if (isset($_POST['typeofwork'])) {
								$querycheck2 = "select * from VolunteerForm where Fullname='$fullname' AND Email='$email'";
								$resultcheck2 = mysqli_query($link, $querycheck); //link query to database
								
								if(mysqli_num_rows($resultcheck2) != 0) {
									$query2 = "update VolunteerForm set FullName='".$fullname."',CompleteAddress='".$completeaddress."',Email='".$email."',Phone1='".$phone1."',
										Phone2='".$phone2."',PreferedContact='".$preferedcontact."',contactemail=".$contactemail.",contactphone1=".$contactphone1.",
										contactphone2=".$contactphone2.",TypeOfWork='".$typeofworkstring."',transporting=".$transporting.",helptrap=".$helptrap.",
										helpeducate=".$helpeducate.",usingphone=".$usingphone.",helpingclinic=".$helpingclinic.",other=".$other.",OtherTasks='".$othertasks."'
										where Fullname='".$fullname."';";
									
									mysqli_query($link, $query2); //link query to database
									
									mysqli_query($link, $query); //update passwords also..
									echo "<h3>Profile Successfully Updated!</h3>";
									header('Refresh: .8; url=userprofile.php');
								}
								else { //error retrieving info from VolunteerForm table
									echo '<div style="padding-bottom:10px">
										<div class="alert">
											<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
											That record already exists.</div></div>';
								}
							}
							else {
								echo '<div style="padding-bottom:10px">
										<div class="alert">
											<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
											Must select at least one type of work to volunteer for.</div></div>';
							}
						}
						else { //fullname didn't match re2
							echo '<div style="padding-bottom:10px">
										<div class="alert">
											<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
											Illegal FullName!</div></div>';
						}
					}
					else {
						mysqli_query($link, $query); //update passwords also..
						echo "<h3>Profile Successfully Updated!</h3>";
						header('Refresh: .8; url=userprofile.php');
					}
				//}
			}
			else{ //error retrieving info from SacFeralsUsers table
				echo "You're not a SacFeralsUsers";
			}
		}
	}

	//not logged in
	if($_SESSION['authenticate234252432341'] != 'validuser09821'){
		print "<h1>you aren't supposed to be here.. STOP SNEAKING AROUND</h1><br><br>";
		print "<a href='userprofile.php'>Back to Login page</a>";
	}
	//logged in
	else {
		$Ausername = $_SESSION['Ausername'];
		$level = $_SESSION['level'];
		$query2 = "select * from SacFeralsUsers where username='".$Ausername."';";
		$result2 = mysqli_query($link, $query2);
		if (mysqli_num_rows($result2)==0){ 
			print "<h4 style='color: RED'>Failed to pull your info from SacFeralsUsers table</h4>";
		}
		else{
			$row2 = mysqli_fetch_array($result2);
			$email = $row2['email'];
			$password = $row2['password'];
		
			if($level==2){ //only if traige user
				$query = "select * from VolunteerForm where email='".$email."';";
				$result = mysqli_query($link, $query);
				//$row = mysql_fetch_assoc($result);
				if (mysqli_num_rows($result)==0){ 
					print "<h4 style='color: RED'>Failed to pull your info from VolunteerForm table</h4>";
				}
				else{
					$row = mysqli_fetch_array($result);
					$fullname = $row['FullName'];
					$address = $row['CompleteAddress'];
					$phone1 = $row['Phone1'];
					$phone2 = $row['Phone2'];
					$contactemail = $row['contactemail'];
					$contactphone1 = $row['contactphone1'];
					$contactphone2 = $row['contactphone2'];
					$transporting = $row['transporting'];
					$helptrap = $row['helptrap'];
					$helpeducate = $row['helpeducate'];
					$usingphone = $row['usingphone'];
					$helpingclinic = $row['helpingclinic'];
					$other = $row['other'];
					$othertasks = $row['OtherTasks'];
					//list($RecordNumber,$DateAndTime,$FullName,$CompleteAddress,$Email,$Phone1,$Text1,$Phone2,$Text2,
						//$PreferedContact,$contactemail,$contactphone1,$contactphone2,$TypeOfWork,$transporting)=$row;
				}
			}
		}
		
?>
	<h2> Update Profile </h2>
	<div id="form-wrapper">
		<form id="updateform" method="post" action="updateprofile.php">
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
<?php
		if($level==2){ //if triage user
?>
			<hr>
			
			<label for="inner-form2"><h4>Profile Information</h4></label>
			<div class="form-row" id="inner-form2">
				<div class="form-group row">
					<label class="col-sm-4 col-form-label" for="fullname">Full Name:</label>
					<div class="col-sm-6"><input class="form-control" type="text" name="fullname" id="fullname" pattern="[a-zA-Z]{3,}\s[a-zA-Z]{3,}" 
						title="Enter first and last name" placeholder="First Last" value="<?php echo $fullname?>" required></div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label" for="completeaddress">Complete Address:</label>
					<div class="col-sm-6"><input class="form-control" type="text" id="completeaddress" name="completeaddress"  
						id="completeaddress" value="<?php echo $address?>"></div> <!--pattern="[[0-9]{1,3}.?[0-9]{0,3}\s[a-zA-Z0-9]{2,30}\s[a-zA-Z]{2,15}]{0,1}" title="Enter street# and street name" -->
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label" for="phone1">Phone1:</label>
					<div class="col-sm-6"><input class="form-control" type="tel" id="phone1" name="phone1" placeholder="1234567890" pattern=".{10,13}" 
								maxlength="10" onkeyup="formatPhone('phone1');" value="<?php echo $phone1?>"/></div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label" for="phone2">Phone2:</label>
					<div class="col-sm-6"><input class="form-control" type="tel" id="phone2" name="phone2" placeholder="1234567890" pattern=".{10,13}" 
								maxlength="10" onkeyup="formatPhone('phone2');" value="<?php echo $phone2?>"/></div>
				</div>
			</div>

			<div class="form-row" id="inner-form3">
				<div class="form-group row">
					<div class="col-sm-12">
						<label class="form-check-label">Prefered Method Of Contact:</label>
						<div class="form-check">
							<label><input type="checkbox" name="contact[]" value="contactemail" <?php if($contactemail==1) echo "checked" ?>> Email</label></div>
						<div class="form-check">
							<label><input type="checkbox" name="contact[]" value="contactphone1" <?php if($contactphone1==1) echo "checked" ?>> Phone #1</label></div>
						<div class="form-check">
							<label><input type="checkbox" name="contact[]" value="contactphone2" <?php if($contactphone2==1) echo "checked" ?>> Phone #2</label></div>
					</div>
				</div>
			</div>

			<div class="form-row" id="inner-form3">
				<div class="form-group row">
					<div class="col-sm-12">
						<label class="form-check-label">Type of Work You Would Like To Volunteer For:</label>
						<div class="form-check">
							<label><input type="checkbox" name="typeofwork[]" id="cb1" value="transporting" <?php if($transporting==1) echo "checked" ?>>
							Transporting cats to and from spay/neuter clinics</label>
						</div>
						<div class="form-check">
							<label><input type="checkbox" name="typeofwork[]" id="cb2" value="helptrap" <?php if($helptrap==1) echo "checked" ?>>
							Helping others trap feral cats</label>
						</div>
						<div class="form-check">
							<label><input type="checkbox" name="typeofwork[]" id="cb3" value="helpeducate" <?php if($helpeducate==1) echo "checked" ?>>
							Helping educate the public about ferals</label>
						</div>
						<div class="form-check">
							<label><input type="checkbox" name="typeofwork[]" id="cb4" value="usingphone" <?php if($usingphone==1) echo "checked" ?>>
							Using the phone and computer to respond to feral inquiries and help resolve feral issues</label>
						</div>
						<div class="form-check">
							<label><input type="checkbox" name="typeofwork[]" id="cb5" value="helpingclinic" <?php if($helpingclinic==1) echo "checked" ?>>
							Helping at feral spay/neuter clinics</label>
						</div>
						<div class="form-check">
							<label><input type="checkbox" name="typeofwork[]" id="cb6" value="other" class='checkdisplay' <?php if($other==1) echo "checked" ?>>
							Other</label>
						</div>
						<div class='todisplay indent' <?php if($other==0) echo 'style="display: none"' ?>>
							Other work you would like to volunteer for.<br>
							<textarea class="form-control" id="othertasks" rows="4" cols="10" name="othertasks"><?php if($other==1) echo $othertasks ?></textarea>
						</div>
					</div>
				</div>
			</div>
<?php
	}
?>
			<div class="form-row" id="buttons">
				<input class="btn" type="button" onclick="location.href='userprofile.php'" value="Cancel">
				<input class="btn btn-primary" type="submit" name="submit" value="Update" >
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
});
</script>

</body>
</html>
