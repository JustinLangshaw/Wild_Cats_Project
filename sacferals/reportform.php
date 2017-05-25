<?php
	session_start();
	include('authenticate.php');
	$link = connectdb($host, $user, $pass, $db);
?>

<!DOCTYPE html>
<html lang="en">
<head>	
	<title>Report Colony Form</title>
	<style type="text/css">
    .fieldset-auto-width 
	{
         display: inline-block;
    }
	.todisplay 
	{
    display:none;
	}
	.todisplay1
	{
    display:none;
	}
	</style>
	
	<!-- This must preceed any code that uses JQuery. It links out to that library so you can use it -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="script.js"></script> 
</head>
<body>

<form method="post" action="reportform.php" id='reportform'>


	<b>First Name</b><br>
	<input type="text" name="firstname"><br><br>
	<b>Last Name</b><br>
	<input type="text" name="lastname"><br><br>
	<b>Your Email Address</b><br>
	<input type="text" name="email"><br><br>
	<b>Your Phone #1</b><br>
	<input type="text" name="phone1"><br><br>
	<b>Your Phone #2</b><br>
	<input type="text" name="phone2"><br><br>

	<b>Are you reporting a cat colony or another type of problem?</b><br>
	<input type="checkbox" name="problemtype[]" value="catcolony" class='checkdisplay' > Cat Colony<br>
	<input type="checkbox" name="problemtype[]" value="intervention" class='checkdisplay1' > Another Problem<br><br>
	
	
	<!-- report colony -->
	<div class='todisplay'>
	
		<b>Colony Name</b><br>
		You can name your colony by the street name, your name or any name that will identify this group of cats<br>
		<input type="text" name="colonyname"><br><br>
		
		<b>Colony Street</b><br>
		<input type="text" name="colonystreet"><br><br>
		<b>City</b><br>
		<input type="text" name="city"><br><br>
		<b>County</b><br>
		<input type="text" name="county"><br><br>
		<b>Zip Code</b><br>
		<input type="text" name="zipcode"><br><br>
		
		<b>Has anyone atempted to trap this colony?</b><br>
		<input type="radio" name="trapattempt[]" value="Yes"> Yes<br>
		<input type="radio" name="trapattempt[]" value="No"> No<br><br>
		
		<b>Approx # of Cats</b><br>
		<input type="text" name="numberofcats"><br><br>
		
		<b>Ear Tipped?</b><br>
		<input type="radio" name="eartipped[]" value="Yes"> Yes<br>
		<input type="radio" name="eartipped[]" value="No"> No<br><br>
		
		<b>Pregnant Cats?</b><br>
		<input type="radio" name="pregnant[]" value="Yes"> Yes<br>
		<input type="radio" name="pregnant[]" value="No"> No<br><br>
		
		<b>Injured Cats?</b><br>
		<input type="radio" name="injured[]" value="Yes"> Yes<br>
		<input type="radio" name="injured[]" value="No"> No<br><br>

		<b>What is the setting of this colony?</b><br>
		<input type="radio" name="setting[]" value="Rural"> Rural<br>
		<input type="radio" name="setting[]" value="Suburban"> Suburban<br>
		<input type="radio" name="setting[]" value="Wilderness"> Wilderness<br>
		<input type="radio" name="setting[]" value="Urban"> Urban<br>
		<input type="radio" name="setting[]" value="Residential"> Residential<br>
		<input type="radio" name="setting[]" value="Commercial"> Commercial<br>
		<input type="radio" name="setting[]" value="Industrial"> Industrial<br><br>

		<b>Comments</b><br>
		<input type="text" name="comments"><br><br>
		
		<input type="submit" name="submit" value="Submit"> <!-- button itself -->
	
	</div>

	<!-- report problem -->
	<div class='todisplay1'>
	
		<b>Where Does the Feral Problem Exist?</b><br>
		Please enter identifying information about where the feral problem exists. Enter information such as business or apartment name, address, cross streets, etc.<br>
		<input type="text" name="problemlocation"><br><br>
		
		<b>Describe the problem that is occuring.</b><br>
		<input type="text" name="problemdescription"><br><br>
		<b>Describe the measures you have taken to fix the problem. (if any)</b><br>
		<input type="text" name="measurestaken"><br><br>
		
		<b>Are there other people working to resolve this problem?</b><br>
		<input type="radio" name="othersworking[]" value="othersworkingyes"> Yes<br>
		<input type="radio" name="othersworking[]" value="othersworkingno"> No<br><br>
		
		
		<b>If others are working to resolve this problem, please enter their names and contact information (phone/email)</b><br>
		<input type="text" name="resolverscontact"><br><br>
		
		<b>Any additional comments?</b><br>
		<input type="text" name="additionalcomments"><br><br>
		
		<input type="submit" name="submit" value="Submit"> <!-- button itself -->
		
	</div>
	
	
</form>
<br>


<?php

if(isset($_POST['submit'])) //this processes after user submits data.
{
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$fullname = $firstname." ".$lastname;
	$email = $_POST['email'];
	$phone1 = $_POST['phone1'];
	$phone2 = $_POST['phone2'];
	
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
	$setting = $_POST['setting'];
	$comments = $_POST['comments'];
	
	
	//re's need updating for all fields. or we can use javascript (better)
	$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
	
	//if user passes re test
	if(preg_match($re, $fullname) )
	{	//display current table
		$querycheck = "select * from ReportColonyForm where colonyname='$colonyname'";
														
		$resultcheck = mysqli_query($link, $querycheck); //link query to database
		
		if(mysqli_num_rows($resultcheck) == 0)// magically check if this made a duplicate row
		{	//if not process the insert query
			$query = "insert into ReportColonyForm values('', Now(), '$fullname', '$email', '$phone1', '$phone2', 
			'$colonyname', '$colonystreet', '$city', '$county', '$zipcode', '$trapattempt[0]', '$numberofcats', 
			'No', '$eartipped[0]', '$pregnant[0]', '$injured[0]', '$setting[0]', '$comments', '', '', '', '', '', '')";
			
			print $query;
			
			mysqli_query($link, $query); //link query to database
			print "form submited!"; // print confirmation
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


?>
</body>
</html>
