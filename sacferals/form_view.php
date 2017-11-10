<?php
	session_start();
	include('authenticate.php');
	$link = connectdb($host, $user, $pass, $db);

	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{
	authenticateUser();
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>	
	<title>Form View</title>
	<style>
		body {background-color: #5ab1c5;}
		label {display: block;}
	</style>
</head>
<body>
<h1>Form View</h1>

<?php
	//if no ones logged in, print login screen
	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{
		header("Location: userprofile.php");
		exit();
	}
	//once you're logged in, show menu/options

	else 
	{ 	
		$Ausername = $_SESSION['Ausername'];
		$level = $_SESSION['level'];

		if($level == 1)
		{

			$RecordNumber1 = $_GET['RecordNumber'];
			$RecordNumber1MinusOne = (int)$RecordNumber1-1;
			$RecordNumber1PlusOne = (int)$RecordNumber1+1;
			
			$query = "select * from ReportColonyForm  where RecordNumber = ".$RecordNumber1."";
			$result = mysqli_query($link, $query);
				if(mysqli_num_rows($result)==0)
				{
					print"
						<br>
						<a href='form_view.php?&RecordNumber=$RecordNumber1MinusOne'>BACK</a>
						<a href='form_view.php?&RecordNumber=$RecordNumber1PlusOne'>NEXT</a>
						<br><br>
						Record Doesn't Exist.<br><br>";
				}
			//print $query."<br>";
			while($row = mysqli_fetch_row($result))
			{
				list($Comments1, $Responder, $Status, $RecordNumber, $DateAndTime, $FullName, $Email, $Phone1, $Phone2, $ColonyAddress,
				$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $Kittens, $ColonyCareGiver, $FeederDescription,
				$Injured, $InjuryDescription, $FriendlyPet, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader,
				$Outcome, $CompletionDate, $FeedIfReturned, $ReqAssitance) = $row; // variables are set to current row
																				// then printed in one table row
				if($RecordNumber1==$RecordNumber)
				{
					print "
					<br>
					<a href='form_view.php?&RecordNumber=$RecordNumber1MinusOne'>BACK</a>
					<a href='form_view.php?&RecordNumber=$RecordNumber1PlusOne'>NEXT</a>
					</br>
					
					<br><b>RecordNumber: </b>$RecordNumber</br>
					<br><b>Comments: </b>$Comments1</br>
					<br><b>Responder: </b>$Responder</br>
					<br><b>Status: </b>$Status</br>
					<br><b>DateAndTime: </b> $DateAndTime</br>
					<br><b>FeedIfReturned: </b> $FeedIfReturned</br>
					<br><b>Full Name: </b> $FullName</br>
					";
					//follow the pattern here
					print "
					<br>$Email</br>
					<br>$Phone1</br>
					<br>$Phone2</br>
					<br>$ColonyAddress</br>
					<br>$City</br>
					<br>$County</br>
					<br>$ZipCode</br>
					<br>$AnyoneAttempted</br>
					<br>$ApproximateCats</br>
					<br>$Kittens</br>
					<br>$ColonyCareGiver</br>
					<br>$FeederDescription</br>
					<br>$Injured</br>
					<br>$InjuryDescription</br>
					<br>$FriendlyPet</br>
					<br>$ColonySetting</br>
					<br>$Comments</br>
					<br>$ReqAssitance</br>
					<br>$VolunteerResponding</br>
					<br>$ResponseDate</br>
					<br>$CustNeedOutcome</br>
					<br>$BeatTeamLeader</br>
					<br>$Outcome</br>
					<br>$CompletionDate</br>
				";
				}
				else
				{
					
				}
			}
		}
		else if($level == 2)
		{
			print "you aren't supposed to be here.. STOP SNEAKING AROUND";
		}
	}

print"
<br>
<a href='form_view.php?&RecordNumber=$RecordNumber1MinusOne'>BACK</a>
<a href='form_view.php?&RecordNumber=$RecordNumber1PlusOne'>NEXT</a>
</br>
";
?>
</body>
</html>
