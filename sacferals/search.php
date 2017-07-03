<?php
	session_start();
	include('authenticate.php');
	include('functions1.php');
	$link = connectdb($host, $user, $pass, $db);

	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{
	authenticateUser();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>	
	<title>Record Search</title> 
	
	<link rel="stylesheet" type="text/css" href="search.css"  />
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="searchScript.js"></script>
	 
	
</head>

<body>
<?php

	//if no ones logged in, print login screen
	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{ 
		
		print "<form method='post' action='search.php'>
		<div><fieldset class='fieldset-auto-width'>
		<legend>Login</legend>
		<label><input type='text' name='username'>User Name</label><br>
		<label><input type='password' name='pass'>Password</label><br>
		<label><input type='submit' name='login' value='Login'></label>
		</fieldset></div>
		</form>
		
		<h3>Level 1 access (admin): Guest1, 123</h3>
		<h3>Level 2 access (pleb): Guest2, abc</h3>";
	}
	//once you're logged in, show menu/options
	else 
	{
		$Ausername = $_SESSION['Ausername'];
		$level = $_SESSION['level'];
		
		if($level == 1)
		{
			print "<a href='logout.php' align='right'>Log out</a><br><br>";
			print "<b>Logged in as ".$Ausername."</b> <br><br>";
			
			//print "<div><fieldset class='fieldset-auto-width'>";
			print "- <a href='userprofile.php' align='right'>Back to Admin Hub</a><br><br>";
			//print "</fieldset></div>";
					
			
			
			
			
			///////////////////////////////////////////////////////////////////////////////////////////
			//edit detector
			if(isset($_GET['editrow']))
			{
				$RecordNumber1 = $_GET['RecordNumber'];
				$query = "select * from ReportColonyForm  where RecordNumber = ".$RecordNumber1.""; //
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($RecordNumber, $DateAndTime, $FullName, $Email, $Phone1, $Phone2, $ColonyName, $ColonyAddress, 
						$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $ColonyCareGiver, $EarTipped, $Pregnant, 
						$Injured, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader, 
						$Outcome, $CompletionDate) = $row;


						
				$sort = $_GET['sort']; //'sort' is magic sorting variable
				if(!isset($sort))
				{
					$sort = "RecordNumber";
				}

				$query = "select * from ReportColonyForm  where RecordNumber = ".$RecordNumber1." order by $sort";
				$result = mysqli_query($link, $query);
				
				
				// print table (happens first before input)

					// first print row of links/headers that sort
					print "
					<form method='post' action='search.php'>
					
					<table>
						<thead>
							<tr>
								<th> </th>
								<th><a>Record_Number</a></th>
								<th><a>Date_And_Time</a></th>
								<th><a>Full_Name</a></th>
								<th><a>Email</a></th>
								<th><a>Phone_1</a></th>
								<th><a>Phone_2</a></th>
								<th><a>Colony_Name</a></th>
								<th><a>ColonyAddress</a></th>
								<th><a>City</a></th>
								<th><a>County</a></th>
								<th><a>Zip_Code</a></th>
								<th><a>Anyone_Attempted</a></th>
								<th><a>Approximate_Cats</a></th>
								<th><a>Colony_Caregiver</a></th>
								<th><a>Ear_Tipped</a></th>
								<th><a>Pregnant</a></th>
								<th><a>Injured</a></th>
								<th><a>Colony_Setting</a></th>
								<th><a>Comments</a></th>
								<th><a>Volunteer_Responding</a></th>
								<th><a>Response_Date</a></th>
								<th><a>Customer_Needed_Outcome</a></th>
								<th><a>Beat_Team_Leader</a></th>
								<th><a>Outcome</a></th>
								<th><a>Completion_Date</a></th>
							</tr>
						</thead>
						
						<tbody class='editBody'>";
						
						//while the next row (set by query) exists?
						
						//$query = "select * from ReportColonyForm";
						//$result = mysqli_query($link, $query);
						//$row = mysqli_fetch_row($result);
						
						while($row = mysqli_fetch_row($result))
						{
							list($RecordNumber, $DateAndTime, $FullName, $Email, $Phone1, $Phone2, $ColonyName, $ColonyAddress, 
							$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $ColonyCareGiver, $EarTipped, $Pregnant, 
							$Injured, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader, 
							$Outcome, $CompletionDate) = $row; // variables are set to current row
																			// then printed in one table row
							print "
							<tr>
								<td> Make Changes Here ---></td>
								<td><input type='hidden' name='RecordNumber' value='$RecordNumber'>$RecordNumber</td>
								<td><input type='hidden' name='DateAndTime' value='$DateAndTimes'>$DateAndTime</td>
								<td><input type='text' name='FullName' value='$FullName'></td>
								<td><input type='text' name='Email' value='$Email'></td>
								<td><input type='text' name='Phone1' value='$Phone1'></td>
								<td><input type='text' name='Phone2' value='$Phone2'></td>
								<td><input type='text' name='ColonyName' value='$ColonyName'></td>
								<td><input type='text' name='ColonyAddress' value='$ColonyAddress'></td>
								<td><input type='text' name='City' value='$City'></td>
								<td><input type='text' name='County' value='$County'></td>
								<td><input type='text' name='ZipCode' value='$ZipCode'></td>
								<td>";
								AnyoneAttempteddd($AnyoneAttempted);
								print" </td>
								<td><input type='text' name='ApproximateCats' value='$ApproximateCats'></td>
								<td><input type='text' name='ColonyCareGiver' value='$ColonyCareGiver'></td>
								<td><input type='text' name='EarTipped' value='$EarTipped'></td>
								<td><input type='text' name='Pregnant' value='$Pregnant'></td>
								<td><input type='text' name='Injured' value='$Injured'></td>
								<td><input type='text' name='ColonySetting' value='$ColonySetting'></td>
								<td><textarea name='Comments'>$Comments</textarea></td>
								<td><input type='text' name='VolunteerResponding' value='$VolunteerResponding'></td>
								<td><input type='text' name='ResponseDate' value='$ResponseDate'></td>
								<td><input type='text' name='CustNeedOutcome' value='$CustNeedOutcome'></td>
								<td><input type='text' name='BeatTeamLeader' value='$BeatTeamLeader'></td>
								<td><input type='text' name='Outcome' value='$Outcome'></td>
								<td><input type='text' name='CompletionDate' value='$CompletionDate'></td>
							</tr>
							";
						}
						print "
						</tbody></div>
					</table>
					<label><input type='submit' name='recordEdit' value='Submit Edit'></label>
					<label><input type='submit' name='cancel' value='Cancel Edit'></label>
					
					

				</form>";
			}
			if(isset($_POST['cancel']))
			{
				//print "edit canceled";
			}
			if(isset($_POST['recordEdit']))
			{
				$FullName = $_POST['FullName'];
				$RecordNumber1 = $_POST['RecordNumber'];
				$DateAndTime = $_POST['DateAndTime'];
				$Email = $_POST['Email'];
				$Phone1 = $_POST['Phone1'];
				$Phone2 = $_POST['Phone2'];
				$ColonyName = $_POST['ColonyName'];
				$ColonyAddress = $_POST['ColonyAddress'];
				$City = $_POST['City'];
				$County = $_POST['County'];
				$ZipCode = $_POST['ZipCode'];
				$AnyoneAttempted = $_POST['AnyoneAttempted'];
				$ApproximateCats = $_POST['ApproximateCats'];
				$ColonyCareGiver = $_POST['ColonyCareGiver'];
				$EarTipped = $_POST['EarTipped'];
				$Pregnant = $_POST['Pregnant'];
				$Injured = $_POST['Injured'];
				$ColonySetting = $_POST['ColonySetting'];
				$Comments = $_POST['Comments'];
				$VolunteerResponding = $_POST['VolunteerResponding'];
				$ResponseDate = $_POST['ResponseDate'];
				$CustNeedOutcome = $_POST['CustNeedOutcome'];
				$BeatTeamLeader = $_POST['BeatTeamLeader'];
				$Outcome = $_POST['Outcome'];
				$CompletionDate = $_POST['CompletionDate'];

				$reName = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
				if($AnyoneAttempted != "") //preg_match($reName, $FullName) && 
				{
					//$query = "select * from ReportColonyForm";
					//$result = mysqli_query($link, $query);
					$query = "select * from ReportColonyForm where RecordNumber='$RecordNumber1' and FullName='$FullName' and Email='$Email' 
							and Phone1='$Phone1' and Phone2='$Phone2' and ColonyName='$ColonyName' and ColonyAddress='$ColonyAddress' 
							and City='$City' and County='$County' and ZipCode='$ZipCode' and AnyoneAttempted='$AnyoneAttempted'
							and ApproximateCats='$ApproximateCats' and ColonyCareGiver='$ColonyCareGiver' and EarTipped='$EarTipped' 
							and Pregnant='$Pregnant' and Injured='$Injured' and ColonySetting='$ColonySetting' and Comments='$Comments'
							and VolunteerResponding='$VolunteerResponding' and ResponseDate='$ResponseDate' and CustNeedOutcome='$CustNeedOutcome'
							and BeatTeamLeader='$BeatTeamLeader' and Outcome='$Outcome' and CompletionDate='$CompletionDate'";
							
					$result = mysqli_query($link, $query);
					
					if(mysqli_num_rows($result) == 0)//if query does nothing, then update
					{
						$queryupdate = "update ReportColonyForm set FullName='$FullName',  Email='$Email' ,
							 Phone1='$Phone1',  Phone2='$Phone2',  ColonyName='$ColonyName' , ColonyAddress='$ColonyAddress' ,
							 City='$City',  County='$County',  ZipCode='$ZipCode',  AnyoneAttempted='$AnyoneAttempted',
							 ApproximateCats='$ApproximateCats' , ColonyCareGiver='$ColonyCareGiver',  EarTipped='$EarTipped' ,
							 Pregnant='$Pregnant',  Injured='$Injured',  ColonySetting='$ColonySetting',  Comments='$Comments',
							 VolunteerResponding='$VolunteerResponding',  ResponseDate='$ResponseDate',  CustNeedOutcome='$CustNeedOutcome',
							 BeatTeamLeader='$BeatTeamLeader',  Outcome='$Outcome' , CompletionDate='$CompletionDate' where RecordNumber='$RecordNumber1'";
							
						mysqli_query($link, $queryupdate);
						print "<h2>Record was updated</h2>";
					}
				}
				else
				{
					print "<h2>Please check all fields</h2>";
				}
			
			}
			//end edit
			///////////////////////////////////////////////////////////////////////////////////
			
			if(isset($_GET['del']))
			{
				$RecordNumber = $_GET['RecordNumber'];
				$query = "delete from ReportColonyForm where RecordNumber='$RecordNumber'";
				mysqli_query($link, $query);
				print $query;
				print "<h2>Record Deleted</h2>";
				//showReportColony();
			}
			
			$sort = $_GET['sort']; //'sort' is magic sorting variable
			if(!isset($sort))
			{
				$sort = "RecordNumber";
			}

			$query = "select * from ReportColonyForm order by $sort";
			$result = mysqli_query($link, $query);
			
			print "Select which tables you would like to view: <br>
			<input type='checkbox' name='searchtables[]' value='ReportColonyForm' class='checkdisplay' > ReportColonyForm <br>
			<input type='checkbox' name='searchtables[]' value='FeralInterventionForm' class='checkdisplay1' > FeralInterventionForm <br>
			<input type='checkbox' name='searchtables[]' value='VolunteerForm' class='checkdisplay2' > VolunteerForm <br>
			<input type='checkbox' name='searchtables[]' value='SundaySSPCA' class='checkdisplay3' > SundaySSPCA <br>
			<input type='checkbox' name='searchtables[]' value='EmergencyC4CCVouchers' class='checkdisplay4' > EmergencyC4CCVouchers <br>

			
			<div class='todisplay'>";
			
			// print table (happens first before input)
			
				// first print row of links/headers that sort
				print "
				<br><b>Report A Feral Cat Colony</b><br><br>
				
				<table>
					<thead>
						<tr>
							<th>  </th>
							<th><a href='search.php?sort=RecordNumber'>Record_Number</a></th>
							<th><a href='search.php?sort=DateAndTime'>Date_And_Time</a></th>
							<th><a href='search.php?sort=FullName'>Full_Name</a></th>
							<th><a href='search.php?sort=Email'>Email</a></th>
							<th><a href='search.php?sort=Phone1'>Phone_1</a></th>
							<th><a href='search.php?sort=Phone2'>Phone_2</a></th>
							<th><a href='search.php?sort=ColonyName'>Colony_Name</a></th>
							<th><a href='search.php?sort=ColonyAddress'>ColonyAddress</a></th>
							<th><a href='search.php?sort=City'>City</a></th>
							<th><a href='search.php?sort=County'>County</a></th>
							<th><a href='search.php?sort=ZipCode'>Zip_Code</a></th>
							<th><a href='search.php?sort=AnyoneAttempted'>Anyone_Attempted</a></th>
							<th><a href='search.php?sort=ApproximateCats'>Approximate_Cats</a></th>
							<th><a href='search.php?sort=ColonyCareGiver'>Colony_Caregiver</a></th>
							<th><a href='search.php?sort=EarTipped'>Ear_Tipped</a></th>
							<th><a href='search.php?sort=Pregnant'>Pregnant</a></th>
							<th><a href='search.php?sort=Injured'>Injured</a></th>
							<th><a href='search.php?sort=ColonySetting'>Colony_Setting</a></th>
							<th><a href='search.php?sort=Comments'>Comments</a></th>
							<th><a href='search.php?sort=VolunteerResponding'>Volunteer_Responding</a></th>
							<th><a href='search.php?sort=ResponseDate'>Response_Date</a></th>
							<th><a href='search.php?sort=CustNeedOutcome'>Customer_Needed_Outcome</a></th>
							<th><a href='search.php?sort=BeatTeamLeader'>Beat_Team_Leader</a></th>
							<th><a href='search.php?sort=Outcome'>Outcome</a></th>
							<th><a href='search.php?sort=CompletionDate'>Completion_Date</a></th>
							
						</tr>
					</thead>
					
					<tbody>";
					
					//while the next row (set by query) exists?
					
					//$query = "select * from ReportColonyForm";
					//$result = mysqli_query($link, $query);
					//$row = mysqli_fetch_row($result);
					
					while($row = mysqli_fetch_row($result))
					{
						list($RecordNumber, $DateAndTime, $FullName, $Email, $Phone1, $Phone2, $ColonyName, $ColonyAddress, 
						$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $ColonyCareGiver, $EarTipped, $Pregnant, 
						$Injured, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader, 
						$Outcome, $CompletionDate) = $row; // variables are set to current row
																		// then printed in one table row
						print "
						<tr>
							<td><a style='background-color:lightgreen;' href='search.php?editrow=yes&RecordNumber=$RecordNumber'>Edit</a> <a style='background-color:#ff8080;' href='search.php?del=yes&RecordNumber=$RecordNumber'  class='confirmation'>Delete</a> </td>
							<td>$RecordNumber </td>
							<td>$DateAndTime</td>
							<td>$FullName</td>
							<td>$Email</td>
							<td>$Phone1</td>
							<td>$Phone2</td>
							<td>$ColonyName</td>
							<td>$ColonyAddress</td>
							<td>$City</td>
							<td>$County</td>
							<td>$ZipCode</td>
							<td>$AnyoneAttempted</td>
							<td>$ApproximateCats</td>
							<td>$ColonyCareGiver</td>
							<td>$EarTipped</td>
							<td>$Pregnant</td>
							<td>$Injured</td>
							<td>$ColonySetting</td>
							<td>$Comments</td>
							<td>$VolunteerResponding</td>
							<td>$ResponseDate</td>
							<td>$CustNeedOutcome</td>
							<td>$BeatTeamLeader</td>
							<td>$Outcome</td>
							<td>$CompletionDate</td>
						</tr>
						";
					}
					print "
					</tbody>
				</table>
			</div>";	
			
			print "
			<div class='todisplay1'>
			</div>";	
				
			print "
			<div class='todisplay2'>
			</div>";		
			
			print "
			<div class='todisplay3'>
			</div>";	
			
			print "
			<div class='todisplay4'>
			</div>";	
			


			
				
		}
		else if($level == 2)
		{
			print "you aren't supposed to be here.. STOP SNEAKING AROUND";
		}

		
	}
?>

</body>
</html>