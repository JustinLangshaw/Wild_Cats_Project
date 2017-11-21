<?php
	session_start();
	include('authenticate.php');
	$link = connectdb($host, $user, $pass, $db);
?>

<script type="text/javascript">

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


<?php

if(isset($_POST['submit'])) //this processes after user submits data.
{
	$fullname = $_POST['fullname'];
	$completeaddress = $_POST['completeaddress'];
	$email = $_POST['email'];
	$phone1 = $_POST['phone1'];
	$phone2 = $_POST['phone2'];

	//arrays of checkboxes
	$contact = $_POST['contact'];
	$typeofwork = $_POST['typeofwork'];

	$contactemail;
	$contactphone1;
	$contactphone2;

	//$preferedcontact= $contact[0].", ".$contact[1].", ".$contact[2];
	$preferedcontact='';
	if (count($contact)!=0){
		$preferedcontact = $contact[0];
		for ($i=1; $i<count($contact); $i++){
			$preferedcontact = $preferedcontact.", ".$contact[$i];
		}
	}
	//$typeofworkstring = $typeofwork[0].", ".$typeofwork[1].", ".$typeofwork[2].", ".$typeofwork[3].", ".$typeofwork[4].", ".$typeofwork[5];
	$typeofworkstring='';
	if (count($typeofwork)!=0){
		$typeofworkstring = $typeofwork[0];
		for ($i=1; $i<count($typeofwork); $i++){
			$typeofworkstring = $typeofworkstring.", ".$typeofwork[$i];
		}
	}

	if($contact[0]!='')
		$contactemail=1;
	else
		$contactemail=0;

	if($contact[1]!='')
		$contactphone1=1;
	else
		$contactphone1=0;

	if($contact[2]!='')
		$contactphone2=1;
	else
		$contactphone2=0;

	
	if($typeofwork[0]!='')
		$transporting=1;
	else
		$transporting=0;

	if($typeofwork[1]!='')
		$helptrap=1;
	else
		$helptrap=0;

	if($typeofwork[2]!='')
		$helpeducate=1;
	else
		$helpeducate=0;

	if($typeofwork[3]!='')
		$usingphone=1;
	else
		$usingphone=0;

	if($typeofwork[4]!='')
		$helpingclinic=1;
	else
		$helpingclinic=0;

	if($typeofwork[5]!='')
		$other=1;
	else
		$other=0;

	$othertasks = $_POST['othertasks'];

	$experience = $_POST['experience'];

	//re's need updating for all fields. or we can use javascript (better)
	$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
	
	//if user passes re test
	if(preg_match($re, $fullname) )
	{	//display current table
		$querycheck = "select * from VolunteerForm where fullname='$fullname' AND Email='$email'";
		$resultcheck = mysqli_query($link, $querycheck); //link query to database

		if (isset($_POST['typeofwork'])) {
			if(mysqli_num_rows($resultcheck) == 0)// magically check if this made a duplicate row
			{	//if not process the insert query
				$query = "insert into VolunteerForm values('', '', 'Inactive', Now(), '$fullname', '$completeaddress', '$email', '$phone1', '$phone2', '$preferedcontact',
				'$contactemail', '$contactphone1', '$contactphone2', '$typeofworkstring', '$transporting', '$helptrap', '$helpeducate', '$usingphone', '$helpingclinic',
				'$other', '$othertasks', '$experience', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')";

				mysqli_query($link, $query); //link query to database
				echo "<script type='text/javascript'> document.location = 'formsubmitted.php'; </script>";
			}
			else
			{
				$result='<div style="padding-bottom:10px">
							<div class="alert">
								<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
								That record already exists.</div></div>';
			}
		}else{
			$result='<div style="padding-bottom:10px">
							<div class="alert">
								<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
								Must select at least one type of work to volunteer for.</div></div>';
		}		
	}
	else
	{
		$result='<div style="padding-bottom:10px">
							<div class="alert">
								<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
								You did not fill out the form correctly!</div></div>';
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Volunteer Form</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!--<link rel="shortcut icon" href="images/sacferals.png" type="image/x-icon">-->
	<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="css/reportform.css">
	
	<!-- This must preceed any code that uses JQuery. It links out to that library so you can use it -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="script.js"></script>
</head>
<body>

<?php echo $result; ?>

<h2> Volunteer </h2>
<form method="post" action="volunteerform.php" id="volform">
	<div class="form-group"><font color="red">* Required Fields</font></div>
	<div class="form-group row">
		<div class="col-xs-5 col-sm-5 col-md-4 col-lg-3">
			<label class="col-form-label" for="fullname">*Full Name </label>									<!--L+ [-] L+ 							middle          L+ [-'] L+-->				    
			<input class="form-control" type="text" name="fullname" id="fullname" pattern="[a-zA-Z]+[-]{0,1}[a-zA-Z]+\s[a-zA-Z\s]{0,}[a-zA-Z]+[-']{0,1}[a-zA-Z]+" 
				title="Enter first and last name" placeholder="First Last" required>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-xs-10 col-sm-10 col-md-8 col-lg-6">
			<label class="col-form-label" for="completeaddress">Complete Mailing Address<br><small>(Optional)</small></label>
			<input class="form-control" type="text" name="completeaddress" placeholder="1234 Sesame St, City, State, Zip"
				pattern="[0-9]{1,3}.?[0-9]{0,3}\s[a-zA-Z0-9]{2,30}\s[a-zA-Z]{2,15}[,\s]{0,1}[a-zA-Z0-9\s]{3,}[,\s]{0,1}[a-zA-Z\s]{3,}[,\s]{0,1}[0-9]{5,5}" 
				title="Enter Street, City, State, and Zip" id="completeaddress" size="40">
		</div>
	</div>
	<div class="form-group row">
		<div class="col-xs-6 col-sm-6 col-md-5 col-lg-4">
			<label class="col-form-label" for="email">*Email Address
				<div id="tooltip"><img src="images/blue_question_mark.png" alt="?"/>
					<span class="tooltiptext">This is our preferred method of contact.</span>
				</div>
			</label>
			<input class="form-control" type="email" name="email" id="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" placeholder="email@domain.com" required>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 col-xl-3">
			<label class="col-form-label" for="phone1">Primary Phone</label>
			<input class="form-control" type="tel" id="phone1" name="phone1" placeholder="1234567890" 
				pattern=".{10,13}" maxlength="10" onkeyup="formatPhone('phone1');" />
		</div>
		<div class="col-xs-5 col-sm-5 col-md-5 col-lg-4 col-xl-3">
			<label class="col-form-label" for="phone2">Secondary Phone</label>
			<input class="form-control" type="tel" id="phone2" name="phone2" placeholder="1234567890" 
				pattern=".{10,13}" maxlength="10" onkeyup="formatPhone('phone2');" />
		</div>
	</div>
	<div class="form-group">
		<label class="form-check-label">Prefered Method of Contact<br><small>(Check one, or more)</small></label>
		<div class="form-check">
			<label><input type="checkbox" name="contact[]" value="contactemail"> Email</label></div>
		<div class="form-check">
			<label><input type="checkbox" name="contact[]" value="contactphone1"> Primary Phone</label></div>
		<div class="form-check">
			<label><input type="checkbox" name="contact[]" value="contactphone2"> Secondary Phone</label></div>
	</div>
	<div class="form-group" id="workchecks">
		<span hidden id="workerror"></span>
		<label class="form-check-label" id="worklabel">*Type of Work You Would Like To Volunteer For<br><small>(Check as many as you like, but at least one)</small></label>
		<div class="form-check">
			<label><input type="checkbox" name="typeofwork[]" value="transporting" > Transporting cats to and from spay/neuter clinics</label></div>
		<div class="form-check">
			<label><input type="checkbox" name="typeofwork[]" value="helptrap"> Helping others trap feral cats</label></div>
		<div class="form-check">
			<label><input type="checkbox" name="typeofwork[]" value="helpeducate"> Helping educate the public about ferals</label></div>
		<div class="form-check">
			<label><input type="checkbox" name="typeofwork[]" value="usingphone"> Using the phone and computer to respond to feral inquiries and help resolve feral issues</label></div>
		<div class="form-check">
			<label><input type="checkbox" name="typeofwork[]" value="helpingclinic"> Helping at feral spay/neuter clinics</label></div>
		<div class="form-check">
			<label><input type="checkbox" name="typeofwork[]" value="helpeducate"> Helping educate the public about ferals</label></div>
		<div class="form-check">
			<label><input type="checkbox" name="typeofwork[]" value="Yes" onClick="displayForm(this)"> Other</input></label>
		</div>
		<div class='form-group indent todisplay' id="othertasks">
			Enter the type of work you would like to volunteer for<br>
			<textarea class="form-control" rows="4" name="othertasks"></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="form-check-label">Your Experience Working with Ferals
			<br><span>Please describe your level of experience and knowledge regarding feral cats and feral issues.</span>
		</label>
		<textarea class="form-control" rows="4" name="experience" id="experience"></textarea>
	</div>

	<br>
	<div class="form-group row" id="buttons">
		<input class="btn btn-primary" type="submit" name="submit" value="Submit"  > <!-- button itself -->
	</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$('form').submit(function(){ //dont submit form (clear out) if work not chosen
		var work = $('#workchecks').find('input');
		for(var i=0; i<work.length; i++){
			if(work[i].checked) return true;
		}
		
		$('#worklabel').attr('style','color: red');
		$('#workerror').html('<small>Must select at least one</small>');
		$('#workerror').removeAttr('hidden');
		return false;
	});
});
</script>

</body>
</html>
