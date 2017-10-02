<?php
	session_start();
	include('authenticate.php');
	$link = connectdb($host, $user, $pass, $db);
?>

<script type="text/javascript">

function formatPhone(phoneId) {
	var startCursor = $("#"+phoneId).get(0).selectionStart;
	var	endCursor = $("#"+phoneId).get(0).selectionEnd;
	
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

function validateReportCatColony(){
	var colonyradio = document.getElementById("catcolonyradio");
	var anotherradio = document.getElementById("interventionradio")
	if(colonyradio.checked == true){
		document.getElementById("zipcode").required = true;
		document.getElementById("numberofcats").required = true;
		
		document.getElementById("problemlocation").required = false;
		document.getElementById("problemdescription").required = false;
	}else if(anotherradio.checked==true){
		document.getElementById("zipcode").required = false;
		document.getElementById("numberofcats").required = false;
		
		document.getElementById("problemlocation").required = true;
		document.getElementById("problemdescription").required = true;
	}
}

</script>

<!DOCTYPE html>
<html lang="en">
<head>	
	<title>Report Colony/Caregiver Registration</title>
	<style type="text/css">
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
	</style>
	
	<!-- This must preceed any code that uses JQuery. It links out to that library so you can use it -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="script.js">
	</script> 
</head>
<body>

<form method="post" action="reportform.php" id='reportform'>

	<b><small><font color="red">* Required Fields</font></small></b><br><br>
	<b>*First Name</b><br>
	<input type="text" name="firstname" id="firstname" required><br><br>
	<b>Last Name</b><br>
	<input type="text" name="lastname" id="lastname"><br><br>
	<b>*Email Address</b><br>
	<input type="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" placeholder="email@domain.com" required><br><br>
	<b>Primary Phone</b><br>
	<input type="tel" id="phone1" name="phone1" placeholder="1234567890" pattern=".{10,13}" maxlength="10" onkeyup="formatPhone('phone1');" /><br><br>
	<b>Secondary Phone</b><br>
	<input type="tel" id="phone2" name="phone2" placeholder="1234567890" pattern=".{10,13}" maxlength="10" onkeyup="formatPhone('phone2');" /><br><br>

	<b>*Report Type</b><br><!-- class='checkdisplay' -->
	<input type="radio" name="problemtype[]" value="catcolony" id="catcolonyradio" onClick="displayForm(this); validateReportCatColony();"></input> Cat Colony<br>
	<input type="radio" name="problemtype[]" value="intervention" id="interventionradio" onClick="displayForm(this); validateReportCatColony();"></input> Other Issues<br><br>
	
	
	<!-- report colony -->
	<div class='todisplay indent' id="catcolony1">
	
		<b>Register as Caregiver?</b><br>	
		<input type="radio" name="caregiver[]" value="Yes"> Yes<br>
		<input type="radio" name="caregiver[]" value="No"> No<br><br>
	
		<b>Colony Name</b><br>
		You can name your colony by the street name, your name or any name that will identify this group of cats<br>
		<input type="text" name="colonyname" id="colonyname"><br><br>
		
		<b>Address</b><br>
		<input type="text" name="colonystreet" id="colonystreet"><br><br>
		<b>City</b><br>
		<input type="text" name="city" id="city"><br><br>
		<b>County</b><br>
		<input type="text" name="county" id="county"><br><br>
		<b>*Zip Code</b><br>
		<input type="text" name="zipcode"  id="zipcode"><br><br>
		
		<b>Has anyone atempted to trap this colony?</b><br>
		<input type="radio" name="trapattempt[]" value="Yes" id="trapattemtyes"> Yes<br>
		<input type="radio" name="trapattempt[]" value="No" id="trapattemptno"> No<br><br>
		
		<b>*Approx # of Cats</b><br>
		<input type="number" name="numberofcats" min="1" max="99" id="numberofcats"><br><br>
		
		<b>Ear Tipped?</b>
		<img id="imageToHover" src="images/question_mark.png" height= "18" width= "18" alt="hover me"/>
		<img id="imageToShow" src="images/ears_tipped.png"  alt="image to show"/><br>

		<input type="radio" name="eartipped[]" value="Yes" id="eartippedyes"> Yes<br>
		<input type="radio" name="eartipped[]" value="No" id="eartippedno"> No<br><br>
		
		<b>Pregnant Cats?</b>
		<img id="imageToHover1" src="images/question_mark1.png" height= "18" width= "18" alt="hover me"/>
		<img id="imageToShow1" src="images/pregnant_cats.png"  alt="image to show"/><br>
		
		<input type="radio" name="pregnant[]" value="Yes" id="pregnantyes"> Yes<br>
		<input type="radio" name="pregnant[]" value="No" id="pregnantno"> No<br><br>
		
		<b>Injured Cats?</b>
		<img id="imageToHover2" src="images/question_mark2.png" height= "18" width= "18" alt="hover me"/>
		<img id="imageToShow2" src="images/injured_cats.png"  alt="image to show"/><br>
					
		<input type="radio" name="recentlyinjured[]" value="Yes" id="recentlyinjuredinjuredyes" onClick="displayForm(this)"> Yes<br>
		<input type="radio" name="recentlyinjured[]" value="No" id="recentlyinjuredinjuredno" onClick="displayForm(this)"> No<br><br>
				
		<div class='indent todisplay' id="recentlyinjuredID">
			<b>Describe Injury/Condition</b><br>
			<textarea rows="4" cols="50" name="injurydescription"></textarea><br><br>
		</div>
		
		<b>What is the setting of this colony?</b><br>
		<input type="radio" name="setting[]" value="Rural" id="rualsetting"> Rural<br>
		<input type="radio" name="setting[]" value="Suburban" id="suburbansetting"> Suburban<br>
		<input type="radio" name="setting[]" value="Wilderness" id="wildernesssetting"> Wilderness<br>
		<input type="radio" name="setting[]" value="Urban" id="urbansetting"> Urban<br>
		<input type="radio" name="setting[]" value="Residential" id="residentialsetting"> Residential<br>
		<input type="radio" name="setting[]" value="Commercial" id="commercialsetting"> Commercial<br>
		<input type="radio" name="setting[]" value="Industrial"id="industrialsetting"> Industrial<br><br>

		<b>Additional Comments</b><br>
		<textarea rows="4" cols="50" name="comments"></textarea><br><br>
		
		<input type="submit" name="submitcolony" value="Submit"  > <!-- button itself -->
	
	</div>

	<!-- report problem -->
	<div class='todisplay indent' id="intervention1">
	
		<b>*Where Does the Feral Problem Exist?</b><br>
		Please enter identifying information about where the feral problem exists. Enter information such as business or apartment name, address, cross streets, etc.<br>
		<input type="text" name="problemlocation" id="problemlocation"><br><br>
		
		<b>*Describe the problem that is occuring.</b><br>
		<textarea rows="4" cols="50" name="problemdescription" id="problemdescription"></textarea><br><br>

		<b>Describe the measures you have taken to fix the problem. (if any)</b><br>
		<textarea rows="4" cols="50" name="measurestaken" id="measurestaken"></textarea><br><br>

		
		<b>Are there other people working to resolve this problem?</b><br>
		<input type="radio" name="othersworking[]" value="Yes" onClick="displayForm(this)"> Yes<br>
		<input type="radio" name="othersworking[]" value="No" onClick="displayForm(this)"> No<br><br>
		
		<div class='indent todisplay' id="othersworkingID">
			<b>Please enter their names and contact information (phone/email)</b><br>
			<textarea rows="4" cols="50" name="resolverscontact"></textarea><br><br>
		</div>
		
		<b>Additional Comments</b><br>
		<textarea rows="4" cols="50" name="additionalcomments"></textarea><br><br>
		
		<input type="submit" name="submitintervention" value="Submit"> <!-- button itself -->
		
	</div>
	
	
</form>
<br>


<?php

if(isset($_POST['submitcolony'])) //this processes after user submits data.
{
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$fullname = $firstname." ".$lastname;
	$email = $_POST['email'];
	$phone1 = $_POST['phone1'];
	$phone2 = $_POST['phone2'];	
	
	$caregiver = $_POST['caregiver'];
	$colonyname = $_POST['colonyname'];
	$colonystreet = $_POST['colonystreet'];
	$city = $_POST['city'];
	$county = $_POST['county'];
	$zipcode = $_POST['zipcode'];
	$trapattempt = $_POST['trapattempt'];
	$numberofcats = $_POST['numberofcats'];
	$eartipped = $_REQUEST['eartipped'];
	$pregnant = $_POST['pregnant'];
	$injured = $_POST['injured'];
	$injurydescription = $_POST['injurydescription'];
	$setting = $_POST['setting'];
	$comments = $_POST['comments'];
	
	
	// Required field names
	$required = array('firstname', 'email','zipcode');

	// Loop over field names, make sure each one exists and is not empty
	$error = false;
	foreach($required as $field) 
	{
		if (empty($_POST[$field])) 
		{
			$error = true;
		}
	}
	
	//re's need updating for all fields. or we can use javascript (better)
	$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
	
	//if user passes re test
	if(!$error)
	{
		if(preg_match($re, $firstname) )
		{	//display current table
			$querycheck = "select * from ReportColonyForm where colonyname='$colonyname' && colonyname<>''" ;
															
			$resultcheck = mysqli_query($link, $querycheck); //link query to database
			
			if(mysqli_num_rows($resultcheck) == 0)// magically check if this made a duplicate row
			{	//if not process the insert query
				$query = "insert into ReportColonyForm values('', Now(), '$fullname', '$email', '$phone1', '$phone2', 
				'$colonyname', '$colonystreet', '$city', '$county', '$zipcode', '$trapattempt[0]', '$numberofcats', 
				'$caregiver[0]', '$eartipped[0]', '$pregnant[0]', '$injured[0]', '$setting[0]', '$comments', '', '', '', '', '', '', '$injurydescription')";
				
				//print $query;
				
				mysqli_query($link, $query); //link query to database
				echo "<script type='text/javascript'> document.location = 'formsubmitted.php'; </script>";
			}
			else
			{
				print "'".$colonyname."' has already been reported.";
			}
		}
		else
		{
			print "You did not fill out the form correctly!";
		}
	}
	else
	{
		print "<b>ERROR!!</b> Please fill out all fields";
	}

	
}
else if(isset($_POST['submitintervention'])) //this processes after user submits data.
{
	$FirstName = $_POST['firstname'];
	$LastName = $_POST['lastname'];
	$FullName = $FirstName." ".$LastName;
	$Phone1 = $_POST['phone1'];
	$Phone2 = $_POST['phone2'];	
	
	$ProblemLocation = $_POST['problemlocation'];
	$ProblemDescription = $_POST['problemdescription'];
	$MeasuresTaken = $_POST['measurestaken'];
	$OthersWorking = $_POST['othersworking'];
	$OtheresContact = $_POST['resolverscontact'];
	$AdditionalComments = $_POST['additionalcomments'];
	
	// Required field names
	$required = array('problemlocation', 'problemdescription');

	// Loop over field names, make sure each one exists and is not empty
	$error = false;
	foreach($required as $field) 
	{
		if (empty($_POST[$field])) 
		{
			$error = true;
		}
	}
	
	
	if(!$error)
	{	//display current table
		$querycheck = "select * from FeralInterventionForm where problemlocation='$problemlocation'";
														
		$resultcheck = mysqli_query($link, $querycheck); //link query to database
		
		if(mysqli_num_rows($resultcheck) == 0)// magically check if this made a duplicate row
		{	//if not process the insert query
			$query = "insert into FeralInterventionForm values('', Now(), '$FullName', '$Phone1', '$Phone2', 
			'$ProblemLocation', '$ProblemDescription ', '$MeasuresTaken ', '$OthersWorking[0]', '$AdditionalComments', '$OthersContact', 
			'', '', '', '', '', '')";
			
			//print $query;
			
			mysqli_query($link, $query); //link query to database
			echo "<script type='text/javascript'> document.location = 'formsubmitted.php'; </script>";
		}
		else
		{
			print "problem at '".$ProblemLocation."' has already been reported.";
		}
	}
	else
	{
		print "<b>ERROR!!</b> Please fill out all fields";
	}
}

?>
</body>
</html>
