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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<title>Edit Profile</title>
	<style type="text/css">
	body 
	{
		background-color: powderblue;
	}
	form
	{
		margin: auto;
		background-color: white;
		padding: 1em;    
		border-color: #0b61a4;
		border-style: solid;
		border-width: 1px;
		min-width: 580px;
		width: 70%;
	}
	h2
	{
		margin: auto;
		margin-top: 0px;
		margin-bottom: 10px;
		color: white;
		background-color: #0b61a4;
		margin-bottom: 0;
		padding: 14px;    
		border-color: #0b61a4;
		border-style: solid;
		border-width: 3px;
		min-width: 580px;
		width: 70%;
		font-family: Arial,sans-serif;
	}
	.fieldset-auto-width 
	{
		display: inline-block;
	}
	.indent
	{
		padding-left: 2em;
	}
	.buttons{
		text-align: right;
	}
	#info td input{
		width: 100%;
	}

	/*error msg*/
	.alert {
	    padding: 20px;
	    background-color: #f44336; /* Red */
	    color: white;
	    margin-bottom: 15px;
	}
	.closebtn {
	    margin-left: 15px;
	    color: white;
	    font-weight: bold;
	    float: right;
	    font-size: 22px;
	    line-height: 20px;
	    cursor: pointer;
	    transition: 0.3s;
	}
	.closebtn:hover {
	    color: black;
	}

	.tooltip {
	    position: relative;
	    display: inline-block;
	}
	.tooltip .tooltiptext {
	    visibility: hidden;
	    width: auto;
	    white-space: nowrap;
	    background-color: #0b61a4;
	    color: #fff;
	    text-align: left;
	    border-radius: 5px;
	    padding: 10px 15px;
	    font-size: 14px;
	    
	    /* Position the tooltip */
	    position: absolute;
	    z-index: 1;
	    top: -5px;
	    left: 150%;
	}
	.tooltip:hover .tooltiptext {
	    visibility: visible;
	}
	</style>

	<!-- This must preceed any code that uses JQuery. It links out to that library so you can use it -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="script.js"></script>

</head>
<body>
<?php

	if(isset($_POST['submit'])){ //this processes after user submits data.
		//for users table
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$repassword = $_POST['repassword'];
		
		$re = "/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/";
		$reEmail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/";
		
		//for report form
		$fullname = $_POST['fullname'];
		$completeaddress = $_POST['completeaddress'];
		//$email = $_POST['email']; //get from Users table instead
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
		//$typeofworkstring = $typeofwork[0].", ".$typeofwork[1].", ".$typeofwork[2].", ".$typeofwork[3].", ".$typeofwork[4].", ".$typeofwork[5];
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
		$re2 = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
		
		if($username == "" || $email == "" || $password == "" || $repassword == ""){//doesn't execute? 
			print "error: please fill out all fields";
		}
		else if($password != $repassword){
			echo '<div style="padding-bottom:10px">
						<div class="alert">
							<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
							error: passwords do not match</div></div>';
			//print "error: passwords do not match";
			$passerror = "style='border:1px solid #d66'";
		}
		else {
			//if user passes re test
			if( preg_match($re, $username) && preg_match($reEmail, $email) ){
				//if user passes re2 test
				if(preg_match($re2, $fullname) ) {	//display current table
					if (isset($_POST['typeofwork'])) {
						//display current table
						$querycheck = "select * from SacFeralsUsers where username='".$username."' or email='".$email."'";
						$resultcheck = mysqli_query($link, $querycheck); //link query to database
						
						$querycheck2 = "select * from VolunteerForm where Fullname='".$fullname."' AND Email='".$email."';";
						$resultcheck2 = mysqli_query($link, $querycheck); //link query to database
						
						if(mysqli_num_rows($resultcheck)!= 0) {// test if found a match
							if(mysqli_num_rows($resultcheck2) != 0) {
								//if so, process the insert query
								$row = mysqli_fetch_array($resultcheck);
								$level = $row['level'];
								$query = "update SacFeralsUsers set username='".$username."',email='".$email."',password='".$password."'
									where username='".$username."';";
								mysqli_query($link, $query); //link query to database
								
								$query2 = "update VolunteerForm set FullName='".$fullname."',CompleteAddress='".$completeaddress."',Email='".$email."',Phone1='".$phone1."'
									,Phone2='".$phone2."',PreferedContact='".$preferedcontact."',contactemail=".$contactemail.",contactphone1=".$contactphone1.",
									contactphone2=".$contactphone2.",TypeOfWork='".$typeofworkstring."',transporting=".$transporting.",helptrap=".$helptrap.",
									helpeducate=".$helpeducate.",usingphone=".$usingphone.",helpingclinic=".$helpingclinic.",other=".$other.",OtherTasks='".$othertasks."'
									where Fullname='".$fullname."';";
								mysqli_query($link, $query2); //link query to database
								
								echo "<h3>Profile Successfully Updated!</h3>";
								header('Refresh: .8; url=userprofile.php');
								//echo "<script type='text/javascript'> document.location = 'userprofile.php'; </script>";
							}
							else {
								echo '<div style="padding-bottom:10px">
									<div class="alert">
										<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
										That record already exists.</div></div>';
							}
						}
						else{
							print "error: That account name or email doesn't exists";
						}
					}
					else {
						echo '<div style="padding-bottom:10px">
									<div class="alert">
										<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
										Must select at least one type of work to volunteer for.</div></div>';
					}
				}
				else {
					echo '<div style="padding-bottom:10px">
									<div class="alert">
										<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
										You did not fill out the form correctly!</div></div>';
				}
			}
			else{
				print "error: Please use no special characters when creating username and make sure your email is valid.";
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
		$query2 = "select * from SacFeralsUsers where username='".$Ausername."';";
		$result2 = mysqli_query($link, $query2);
		if (mysqli_num_rows($result2)==0){ 
			print "<h4 style='color: RED'>Failed to pull your info from SacFeralsUsers table</h4>";
		}
		else{
			$row2 = mysqli_fetch_array($result2);
			$email = $row2['email'];
			$password = $row2['password'];
		
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
		
?>
	<h2> Update Profile </h2>
	<form method="post" action="updateprofile.php">
		
		<b>Account Information</b><br>
		<div style="padding: 10px">
		<table id="info">
			<tr>
				<td>Username:</td>
				<td><input type="text" name="username" required value="<?php echo $Ausername?>" readonly></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><input type="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" 
						placeholder="email@domain.com" required value="<?php echo $email?>" readonly></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="text" size="40" name="password" required value="<?php echo $password?>" <?php echo $passerror?>></td>
			</tr>
			<tr>
				<td>Re-enter Password:</td>
				<td><input type="text" name="repassword" required value="<?php echo $password?>" <?php echo $passerror?>></td>
			</tr>
		</table>
		</div>

		<b>Profile Information</b><br>
		<div style="padding: 10px">
		<table id="info">
			<tr>
				<td>Full Name:</td>
				<td><input type="text" name="fullname" required value="<?php echo $fullname?>"></td>
			</tr>
			<tr>
				<td>Complete Address:</td>
				<td><input type="text" size="40" name="completeaddress" value="<?php echo $address?>"></td>
			</tr>
			<tr>
				<td>Phone1:</td>
				<td><input type="tel" id="phone1" name="phone1" placeholder="1234567890" pattern=".{10,13}" 
							maxlength="10" onkeyup="formatPhone('phone1');" value="<?php echo $phone1?>"/></td>
			</tr>
			<tr>
				<td>Phone2:</td>
				<td><input type="tel" id="phone2" name="phone2" placeholder="1234567890" pattern=".{10,13}" 
							maxlength="10" onkeyup="formatPhone('phone2');" value="<?php echo $phone2?>"/></td>
			</tr>
		</table><br>

		<table>
			<tr><td>Prefered Method Of Contact:</td></tr>
			<tr><td><input type="checkbox" name="contact[]" value="contactemail" <?php if($contactemail==1) echo "checked" ?>> Email</td></tr>
			<tr><td><input type="checkbox" name="contact[]" value="contactphone1" <?php if($contactphone1==1) echo "checked" ?>> Phone #1</td></tr>
			<tr><td><input type="checkbox" name="contact[]" value="contactphone2" <?php if($contactphone2==1) echo "checked" ?>> Phone #2</td></tr>
		</table><br>

		<table>
			<tr>Type of Work You Would Like To Volunteer For:</tr>
			<tr>
				<td><input type="checkbox" name="typeofwork[]" value="transporting" <?php if($transporting==1) echo "checked" ?>></td>
				<td>Transporting cats to and from spay/neuter clinics</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="typeofwork[]" value="helptrap" <?php if($helptrap==1) echo "checked" ?>></td> 
				<td>Helping others trap feral cats</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="typeofwork[]" value="helpeducate" <?php if($helpeducate==1) echo "checked" ?>></td> 
				<td>Helping educate the public about ferals</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="typeofwork[]" value="usingphone" <?php if($usingphone==1) echo "checked" ?>></td> 
				<td>Using the phone and computer to respond to feral inquiries and help resolve feral issues</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="typeofwork[]" value="helpingclinic" <?php if($helpingclinic==1) echo "checked" ?>></td> 
				<td>Helping at feral spay/neuter clinics</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="typeofwork[]" value="other" class='checkdisplay' <?php if($other==1) echo "checked" ?>></td> 
				<td>Other</td>
			</tr>
		</table>

		<div class='todisplay indent' <?php if($other==0) echo 'style="display: none"' ?>>
			Other work you would like to volunteer for.<br>
			<textarea rows="4" cols="50" name="othertasks"><?php if($other==1) echo $othertasks ?></textarea><br><br>
		</div>
		</div>

		<div class="buttons">
			<input type="button" onclick="location.href='userprofile.php'" value="Cancel">
			<input type="submit" name="submit" value="Update" >
		</div>
	</form>
	<br>
<?php 
} 
?>

</body>
</html>

<?php

?>

<script> //script.js include later
	$(document).ready(function () 
{
    $('.checkdisplay').change(function () 
	{
        if (this.checked) 
		{ 
          $('.todisplay').fadeIn('fast'); 
        }
        else 
		{
          $('.todisplay').fadeOut('fast'); 
        }

    });
});
</script>