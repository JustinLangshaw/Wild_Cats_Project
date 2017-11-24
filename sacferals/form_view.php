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
		table, th, td 
		{
			border: 1px solid black;
			background-color: #b3ffcc;
		}
	</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="js/searchScript.js"></script> 
	
</head>
<body>

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
		
		print"<b>Logged in as $Ausername </b> 
				<h1>Form View</h1>";
		
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
			
			while($row = mysqli_fetch_row($result))
			{
				list($Comments1, $Responder, $Status, $RecordNumber, $DateAndTime, $FeedIfReturned, $FullName, $Email, $Phone1, $Phone2, $ColonyAddress,
						$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $Kittens, $ColonyCareGiver, $FeederDescription,
						$Injured, $InjuryDescription, $FriendlyPet, $ColonySetting, $Comments, $ReqAssistance, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader,
						$Outcome, $CompletionDate, $Lat, $Lng) = $row;
						
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
					<a style='background-color:lightgreen;' href='form_view.php?editrow=yes&RecordNumber=$RecordNumber'>Edit</a> 
					<a style='background-color:#ff8080;' href='form_view.php?del=yes&RecordNumber=$RecordNumber'  class='confirmation'>Delete</a> 					
					</br>";
					
					if(isset($_GET['del']))
					{
						$RecordNumber = $_GET['RecordNumber'];
						$query = "delete from ReportColonyForm where RecordNumber='$RecordNumber'";
						mysqli_query($link, $query);
						//print $query;
						print "<span id='recupdate'><h2>Record Deleted</h2></span>";
						
					}
					
					if(isset($_GET['editrow'])&& !(isset($_GET['del'])))
					{
						$RecordNumber1 = $_GET['RecordNumber'];
						$query = "select * from ReportColonyForm  where RecordNumber = ".$RecordNumber1."";
						$result = mysqli_query($link, $query);
						$row = mysqli_fetch_row($result);
						list($Comments1, $Responder, $Status, $RecordNumber, $DateAndTime, $FeedIfReturned, $FullName, $Email, $Phone1, $Phone2, $ColonyAddress,
								$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $Kittens, $ColonyCareGiver, $FeederDescription,
								$Injured, $InjuryDescription, $FriendlyPet, $ColonySetting, $Comments, $ReqAssistance, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader,
								$Outcome, $CompletionDate, $Lat, $Lng) = $row;

							
						
						//////////////////////////////////////////////////////////////////////////////////////
						// print table (happens first before input)
							print "
							<form method='post' action='form_view.php?&RecordNumber=$RecordNumber'>";
							
							print "
							 <br><label><input type='submit' name='recordEdit' value='Submit Edit'> <input type='submit' name='cancel' value='Cancel Edit'></label> ";
							 
								print "<table>
								<tr><td><b>RecordNumber: </b></td><td><input class='form-control' type='hidden' name='RecordNumber' value='$RecordNumber'>$RecordNumber </td>
								<tr><td><b>Comments: </b></td><td><textarea class='form-control' name='Comments1' rows='4' value='$Comments1'>$Comments1</textarea></td> 
								<tr><td><b>Responder: </b></td><td><input class='form-control' type='text' name='Responder' value='$Responder'> </td>
								<tr><td><b>Status: </b></td><td><input class='form-control' type='text' name='Status' value='$Status'> </td>
								<tr><td><b>DateAndTime: </b></td> <td><input class='form-control' type='hidden' name='DateAndTime' value='$DateAndTimes'>$DateAndTime </td>
								<tr><td><b>FeedIfReturned: </b></td> <td><input class='form-control' type='text' name='FeedIfReturned' value='$FeedIfReturned'> </td>
								<tr><td><b>Full Name: </b></td> <td><input class='form-control' type='text' name='FullName' value='$FullName'> </td>
								<tr><td><b>Email: </b></td><td><input class='form-control' type='text' name='Email' value='$Email'> </td>
								<tr><td><b>Phone1: </b></td> <td><input class='form-control' type='text' name='Phone1' value='$Phone1'> </td>
								<tr><td><b>Phone2: </b> <td><input class='form-control' type='text' name='Phone2' value='$Phone2'> </td>
								<tr><td><b>Colony Address: </b></td> <td><input class='form-control' type='text' name='ColonyAddress' value='$ColonyAddress'> </td>
								<tr><td><b>City: </b></td> <td><input class='form-control' type='text' name='City' value='$City'> </td>
								<tr><td><b>County: </b></td> <td><input class='form-control' type='text' name='County' value='$County'> </td>
								<tr><td><b>Zip Code: </b></td> <td><input class='form-control' type='text' name='ZipCode' value='$ZipCode'> </td>
								<tr><td><b>Anyone Attempted: </b></td> <td><input class='form-control' type='text' name='AnyoneAttempted' value='$AnyoneAttempted'> </td>
								<tr><td><b>Approximate Cats: </b></td> <td><input class='form-control' type='text' name='ApproximateCats' value='$ApproximateCats'> </td>
								<tr><td><b>Kittens: </b></td> <td><input class='form-control' type='text' name='Kittens' value='$Kittens'> </td>
								<tr><td><b>Colony Care Giver: </b></td> <td><input class='form-control' type='text' name='ColonyCareGiver' value='$ColonyCareGiver'> </td>
								<tr><td><b>Feeder Description: </b> <td><textarea class='form-control' name='FeederDescription'  rows='4' value='$FeederDescription'>$FeederDescription</textarea></td> 
								<tr><td><b>Injured: </b></td> <td><input class='form-control' type='text' name='Injured' value='$Injured'> </td>
								<tr><td><b>Injury Description: </b></td> <td><textarea class='form-control' name='InjuryDescription'  rows='4' value='$InjuryDescription'>$InjuryDescription</textarea></td> 
								<tr><td><b>Friendly Pet: </b></td> <td><input class='form-control' type='text' name='FriendlyPet' value='$FriendlyPet'> </td>
								<tr><td><b>Colony Setting: </b></td> <td><input class='form-control' type='text' name='ColonySetting' value='$ColonySetting'> </td>
								<tr><td><b>Comments: </b></td> <td><textarea class='form-control' name='Comments'  rows='4' value='$Comments'>$Comments</textarea></td> </td>
								<tr><td><b>Req Assistance: </b> <td><input class='form-control' type='text' name='ReqAssistance' value='$ReqAssistance'> </td>
								<tr><td><b>Volunteer Responding: </b></td> <td><input class='form-control' type='text' name='VolunteerResponding' value='$VolunteerResponding'> </td>
								<tr><td><b>Response Date: </b></td> <td><input class='form-control' type='text' name='ResponseDate' value='$ResponseDate'> </td>
								<tr><td><b>Cust Need Outcome: </b></td> <td><input class='form-control' type='text' name='CustNeedOutcome' value='$CustNeedOutcome'> </td>
								<tr><td><b>Beat Team Leader: </b></td> <td><input class='form-control' type='text' name='BeatTeamLeader' value='$BeatTeamLeader'> </td>
								<tr><td><b>Outcome: </b></td> <td><input class='form-control' type='text' name='Outcome' value='$Outcome'> </td>
								<tr><td><b>Completion Date: </b></td> <td><input class='form-control' type='text' name='CompletionDate' value='$CompletionDate'> </td>
								<tr><td><b>Latitude: </b></td> <td><input class='form-control' type='text' name='Lat' value='$Lat'> </td>
								<tr><td><b>Longitude: </b></td> <td><input class='form-control' type='text' name='Lng' value='$Lng'></td>
							</table>";
										
							print "
							 <label><input type='submit' name='recordEdit' value='Submit Edit'> <input type='submit' name='cancel' value='Cancel Edit'></label> 

						</form>";
					}		
				}
				
			}			
					
					
					
					
					
			///////////////////////////////////////////////////////////////////////////////////////////
			//edit detector
			
			if(isset($_POST['cancel'])&& !(isset($_GET['del'])))
			{
				//print "edit canceled";
			}
			if(isset($_POST['recordEdit']))
			{
				//echo "In the recordEdit IF loop!!";
				$Comments1 = $_POST['Comments1'];
				$Responder = $_POST['Responder'];
				$Status = $_POST['Status'];
				$FeedIfReturned = $_POST['FeedIfReturned'];
				$FullName = $_POST['FullName'];
				$RecordNumber1 = $_POST['RecordNumber'];
				$DateAndTime = $_POST['DateAndTime'];
				$Email = $_POST['Email'];
				$Phone1 = $_POST['Phone1'];
				$Phone2 = $_POST['Phone2'];
				$ColonyAddress = $_POST['ColonyAddress'];
				$City = $_POST['City'];
				$County = $_POST['County'];
				$ZipCode = $_POST['ZipCode'];
				$AnyoneAttempted = $_POST['AnyoneAttempted'];
				$ApproximateCats = $_POST['ApproximateCats'];
				$Kittens = $_POST['Kittens'];
				$ColonyCareGiver = $_POST['ColonyCareGiver'];
				$FeederDescription = $_POST['FeederDescription'];
				$Injured = $_POST['Injured'];
				$InjuryDescription = $_POST['InjuryDescription'];
				$FriendlyPet = $_POST['FriendlyPet'];
				$ColonySetting = $_POST['ColonySetting'];
				$Comments = $_POST['Comments'];
				$ReqAssistance = $_POST['ReqAssistance'];
				$VolunteerResponding = $_POST['VolunteerResponding'];
				$ResponseDate = $_POST['ResponseDate'];
				$CustNeedOutcome = $_POST['CustNeedOutcome'];
				$BeatTeamLeader = $_POST['BeatTeamLeader'];
				$Outcome = $_POST['Outcome'];
				$CompletionDate = $_POST['CompletionDate'];
				$Lat = $_POST['Lat'];
				$Lng = $_POST['Lng'];

				
				$query = "select * from ReportColonyForm where RecordNumber='$RecordNumber1'";
				$result = mysqli_query($link, $query);

				if(mysqli_num_rows($result) == 1)
				{
					$queryupdate = "update ReportColonyForm set Comments1='$Comments1', Responder='$Responder', Status='$Status',
						 FullName='$FullName', Email='$Email',
						 Phone1='$Phone1', Phone2='$Phone2', ColonyAddress='$ColonyAddress',
						 City='$City', County='$County', ZipCode='$ZipCode', AnyoneAttempted='$AnyoneAttempted',
						 ApproximateCats='$ApproximateCats', Kittens='$Kittens', ColonyCareGiver='$ColonyCareGiver', FeederDescription='$FeederDescription',
						 Injured='$Injured', InjuryDescription='$InjuryDescription', FriendlyPet='$FriendlyPet', ColonySetting='$ColonySetting', Comments='$Comments',
						 VolunteerResponding='$VolunteerResponding', ResponseDate='$ResponseDate', CustNeedOutcome='$CustNeedOutcome',
						 BeatTeamLeader='$BeatTeamLeader', Outcome='$Outcome', CompletionDate='$CompletionDate', FeedIfReturned='$FeedIfReturned', ReqAssistance='$ReqAssistance', 
						 Lat='$Lat', Lng='$Lng' where RecordNumber='$RecordNumber1'";

					//echo $queryupdate;
					mysqli_query($link, $queryupdate);
					print "<span id='recupdate'><h2>Record was updated</h2></span>";
				}

				

			}
			//end edit
			///////////////////////////////////////////////////////////////////////////////////
			if(!isset($_GET['editrow'])&& !(isset($_GET['del'])))
			{
				print"<br><table>
				<tr><td><b>RecordNumber: </b></td><td>$RecordNumber</td></tr>
				<tr><td><b>Comments: </b></td><td>$Comments1</td></tr>
				<tr><td><b>Responder: </b></td><td>$Responder</td></tr>
				<tr><td><b>Status: </b></td><td>$Status</td></tr>
				<tr><td><b>DateAndTime: </b></td><td> $DateAndTime</td></tr>
				<tr><td><b>FeedIfReturned: </b></td><td> $FeedIfReturned</td></tr>
				<tr><td><b>Full Name: </b></td><td> $FullName</td></tr>
				<tr><td><b>Email: </b></td><td> $Email</td></tr>
				<tr><td><b>Phone1: </b></td><td> $Phone1</td></tr>
				<tr><td><b>Phone2: </b></td><td> $Phone2</td></tr>
				<tr><td><b>ColonyAddress: </b></td><td> $ColonyAddress</td></tr>
				<tr><td><b>City: </b></td><td> $City</td></tr>
				<tr><td><b>County: </b></td><td> $County</td></tr>
				<tr><td><b>ZipCode: </b></td><td> $ZipCode</td></tr>
				<tr><td><b>AnyoneAttempted: </b></td><td> $AnyoneAttempted</td></tr>
				<tr><td><b>ApproximateCats: </b></td><td> $ApproximateCats</td></tr>
				<tr><td><b>Kittens: </b></td><td> $Kittens</td></tr>
				<tr><td><b>ColonyCareGiver: </b></td><td> $ColonyCareGiver</td></tr>
				<tr><td><b>FeederDescription: </b></td><td> $FeederDescription</td></tr>
				<tr><td><b>Injured: </b></td><td> $Injured</td></tr>
				<tr><td><b>InjuryDescription: </b></td><td> $InjuryDescription</td></tr>
				<tr><td><b>FriendlyPet: </b></td><td> $FriendlyPet</td></tr>
				<tr><td><b>ColonySetting: </b></td><td> $ColonySetting</td></tr>
				<tr><td><b>Comments: </b></td><td> $Comments</td></tr>
				<tr><td><b>ReqAssitance: </b></td><td> $ReqAssitance</td></tr>
				<tr><td><b>VolunteerResponding: </b></td><td> $VolunteerResponding</td></tr>
				<tr><td><b>ResponseDate: </b></td><td> $ResponseDate</td></tr>
				<tr><td><b>CustNeedOutcome: </b></td><td> $CustNeedOutcome</td></tr>
				<tr><td><b>BeatTeamLeader: </b></td><td> $BeatTeamLeader</td></tr>
				<tr><td><b>Outcome: </b></td><td> $Outcome</td></tr>
				<tr><td><b>CompletionDate: </b></td><td> $CompletionDate</td></tr>
				<tr><td><b>Latitude: </b></td><td> $Lat</td></tr>
				<tr><td><b>Longitude: </b></td><td> $Lng</td></tr>
				</table>
				";
			}
			
			print"
			<br>
			<a style='background-color:lightgreen;' href='form_view.php?editrow=yes&RecordNumber=$RecordNumber'>Edit</a> 
			<a style='background-color:#ff8080;' href='form_view.php?del=yes&RecordNumber=$RecordNumber'  class='confirmation'>Delete</a> 
			</br>
			";	
			
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
			
					
					
					
			
		}
		else if($level == 2)
		{
			print "you aren't supposed to be here.. STOP SNEAKING AROUND";
		}
	}

	
?>
</body>
</html>
