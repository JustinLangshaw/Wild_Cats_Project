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
		$largestRecord;
		$smallestRecord;
		
		if($level == 1)
		{
			
			$query = "SELECT MAX( RecordNumber ) FROM ReportColonyForm";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result))
			{
				list($largestNumber) = $row;
				$largestRecord=$largestNumber;
			}
			$query = "SELECT MIN( RecordNumber ) FROM ReportColonyForm";
			$result = mysqli_query($link, $query);
			while($row = mysqli_fetch_row($result))
			{
				list($smallestNumber) = $row;
				$smallestRecord=$smallestNumber;
			}
			//print "Max record number is: ".$largestRecord;
			//print "<br> Min record number is: ".$smallestRecord."<br>";
			
			
			$RecordNumber1 = $_GET['RecordNumber'];
			$RecordNumber1MinusOne = (int)$RecordNumber1-1;
			$RecordNumber1PlusOne = (int)$RecordNumber1+1;
			
			do{
				$query = "select * from ReportColonyForm  where RecordNumber = ".$RecordNumber1PlusOne."";
				$result = mysqli_query($link, $query);
				if(mysqli_num_rows($result)==0 && $RecordNumber1PlusOne<$largestRecord)
				{
					$RecordNumber1PlusOne++;
				}
				
			}while(mysqli_num_rows($result)==0 && $RecordNumber1PlusOne<$largestRecord);
			
			do{
				$query = "select * from ReportColonyForm  where RecordNumber = ".$RecordNumber1MinusOne."";
				$result = mysqli_query($link, $query);
				if(mysqli_num_rows($result)==0 && $RecordNumber1MinusOne>$smallestRecord)
				{
					$RecordNumber1MinusOne--;
				}
				
			}while(mysqli_num_rows($result)==0 && $RecordNumber1MinusOne>$smallestRecord);
			
			
			
			$query = "select * from ReportColonyForm  where RecordNumber = ".$RecordNumber1."";
			$result = mysqli_query($link, $query);
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
					if($RecordNumber1MinusOne<$smallestRecord)
					{
						print "
						<br>
						(Beginning of Records) 
						<a href='form_view.php?&RecordNumber=$RecordNumber1PlusOne'>NEXT</a>
						</br>";
					}
					else if($RecordNumber1PlusOne>$largestRecord)
					{
						print "
						<br>
						<a href='form_view.php?&RecordNumber=$RecordNumber1MinusOne'>BACK</a>
						(End of Records)
						</br>";
					}
					else
					{
						print "
						<br>
						<a href='form_view.php?&RecordNumber=$RecordNumber1MinusOne'>BACK</a>
						<a href='form_view.php?&RecordNumber=$RecordNumber1PlusOne'>NEXT</a>
						</br>";
					}
					
					print "
					<br>
					<a href=''>EDIT</a>
					<a href=''>DELETE</a>
					</br>
					
					<br><b>RecordNumber: </b>$RecordNumber</br>
					<br><b>Comments: </b>$Comments1</br>
					<br><b>Responder: </b>$Responder</br>
					<br><b>Status: </b>$Status</br>
					<br><b>DateAndTime: </b> $DateAndTime</br>
					<br><b>FeedIfReturned: </b> $FeedIfReturned</br>
					<br><b>Full Name: </b> $FullName</br>
					<br><b>Email: </b> $Email</br>
					<br><b>Phone1: </b> $Phone1</br>
					<br><b>Phone2: </b> $Phone2</br>
					<br><b>ColonyAddress: </b> $ColonyAddress</br>
					<br><b>City: </b> $City</br>
					<br><b>County: </b> $County</br>
					<br><b>ZipCode: </b> $ZipCode</br>
					<br><b>AnyoneAttempted: </b> $AnyoneAttempted</br>
					<br><b>ApproximateCats: </b> $ApproximateCats</br>
					<br><b>Kittens: </b> $Kittens</br>
					<br><b>ColonyCareGiver: </b> $ColonyCareGiver</br>
					<br><b>FeederDescription: </b> $FeederDescription</br>
					<br><b>Injured: </b> $Injured</br>
					<br><b>InjuryDescription: </b> $InjuryDescription</br>
					<br><b>FriendlyPet: </b> $FriendlyPet</br>
					<br><b>ColonySetting: </b> $ColonySetting</br>
					<br><b>Comments: </b> $Comments</br>
					<br><b>ReqAssitance: </b> $ReqAssitance</br>
					<br><b>VolunteerResponding: </b> $VolunteerResponding</br>
					<br><b>ResponseDate: </b> $ResponseDate</br>
					<br><b>CustNeedOutcome: </b> $CustNeedOutcome</br>
					<br><b>BeatTeamLeader: </b> $BeatTeamLeader</br>
					<br><b>Outcome: </b> $Outcome</br>
					<br><b>CompletionDate: </b> $CompletionDate</br>
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

	if($RecordNumber1MinusOne<$smallestRecord)
	{
		print "
		<br>
		(Beginning of Records) 
		<a href='form_view.php?&RecordNumber=$RecordNumber1PlusOne'>NEXT</a>
		</br>";
	}
	else if($RecordNumber1PlusOne>$largestRecord)
	{
		print "
		<br>
		<a href='form_view.php?&RecordNumber=$RecordNumber1MinusOne'>BACK</a>
		(End of Records)
		</br>";
	}
	else
	{
		print "
		<br>
		<a href='form_view.php?&RecordNumber=$RecordNumber1MinusOne'>BACK</a>
		<a href='form_view.php?&RecordNumber=$RecordNumber1PlusOne'>NEXT</a>
		</br>";
	}
	
	print"
	<br>
	<a href=''>EDIT</a>
	<a href=''>DELETE</a>
	</br>
	";
?>
</body>
</html>
