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

	$preferedcontact= $contact[0].", ".$contact[1].", ".$contact[2];
	//$typeofworkstring = $typeofwork[0].", ".$typeofwork[1].", ".$typeofwork[2].", ".$typeofwork[3].", ".$typeofwork[4].", ".$typeofwork[5];
	$typeofworkstring='';
	if (count($typeofwork)!=0){
		$typeofworkstring = $typeofwork[0];
		for ($i=1; $i<count($typeofwork); $i++){
			$typeofworkstring = $typeofworkstring.",".$typeofwork[$i];
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
				$query = "insert into VolunteerForm values('', Now(), '$fullname', '$completeaddress', '$email', '$phone1', '$phone2', '$preferedcontact',
				'$contactemail', '$contactphone1', '$contactphone2', '$typeofworkstring', '$transporting', '$helptrap', '$helpeducate', '$usingphone', '$helpingclinic',
				'$other', '$othertasks', '$experience', '', '', '' )";

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
		padding: 14;    
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
	.todisplay 
	{
		display:none;
	}
	.indent
	{
		padding-left: 2em;
	}
	#imageToShow
	{
		display: none;
		position: absolute;
	}
	#imageToShow1
	{
		display: none;
		position: absolute;
	}
	#imageToShow2
	{
		display: none;
		position: absolute;
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

<?php echo $result; ?>

<h2> Volunteer </h2>
<form method="post" action="volunteerform.php">
	
	<b><small><font color="red">* Required Fields</font></small></b><br><br>
	<b>*Full Name</b><br>
	<input type="text" name="fullname" required><br><br>
	<b>Your Complete Mailing Address</b><br>
	Optional<br>
	<input type="text" size="40" name="completeaddress"><br><br>

	<b>*Your Email</b><br>
	<input type="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" placeholder="email@domain.com" required><br><br>

	<b>Your Phone #1</b><br>
	<input type="tel" id="phone1" name="phone1" placeholder="1234567890" pattern=".{10,13}" maxlength="10" onkeyup="formatPhone('phone1');" /><br><br>
	<b>Your Phone #2</b><br>
	<input type="tel" id="phone2" name="phone2" placeholder="1234567890" pattern=".{10,13}" maxlength="10" onkeyup="formatPhone('phone2');" /><br><br>

	<b>Prefered Method Of Contact?</b><br>
	Check one or all<br>
	<input type="checkbox" name="contact[]" value="contactemail"> Email<br>
	<input type="checkbox" name="contact[]" value="contactphone1"> Phone #1<br>
	<input type="checkbox" name="contact[]" value="contactphone2"> Phone #2<br><br>

	<b>*Type of Work You Would Like To Volunteer For</b><br>
	Check as many as you like<br>
	<input type="checkbox" name="typeofwork[]" value="transporting" > Transporting cats to and from spay/neuter clinics<br>
	<input type="checkbox" name="typeofwork[]" value="helptrap"> Helping others trap feral cats<br>
	<input type="checkbox" name="typeofwork[]" value="helpeducate"> Helping educate the public about ferals<br>
	<input type="checkbox" name="typeofwork[]" value="usingphone"> Using the phone and computer to respond to feral inquiries and help resolve feral issues<br>
	<input type="checkbox" name="typeofwork[]" value="helpingclinic"> Helping at feral spay/neuter clinics<br>
	<input type="checkbox" name="typeofwork[]" value="other" class='checkdisplay' > Other (write in below)<br><br>


	<div class='todisplay indent'>
		<b>Other Tasks</b><br>
		Please type in the type of work you would like to volunteer for.<br>
		<textarea rows="4" cols="50" name="othertasks"></textarea><br><br>
	</div>


	<b>Describe Your Experience Working with Ferals</b><br>
	Please describe your level of experience and knowledge regarding feral cats and feral issues.<br>
	<textarea rows="4" cols="50" name="experience"></textarea><br><br>


	<input type="submit" name="submit" value="Submit" > <!-- button itself -->
</form>
<br>

</body>
</html>
