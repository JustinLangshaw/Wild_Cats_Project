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
				
		
			print "
				
			
			<div style='color:red'>Note: Hold down ctrl or shift to select multiple columns</div>
			
			<form id='form1' name='form1' method='get' action='search.php'>
			 
				<select name='select2[]' size='7' multiple='multiple' tabindex='1'>
					<option value='RecordNumber'>Record Number</option>
					<option value='DateAndTime'>Date And Time</option>
					<option value='FullName'>Full Name</option>
					<option value='Email'>Email</option>
					<option value='Phone1'>Phone1</option>
					<option value='Phone2'>Phone2</option>
					<option value='ColonyName'>Colony Name</option>
					<option value='ColonyAddress'>Colony Address</option>
					<option value='City'>City</option>
					<option value='County'>County</option>
					<option value='ZipCode'>ZipCode</option>
					<option value='AnyoneAttempted'>Anyone Attempted</option>
					<option value='ApproximateCats'>Approximate Cats</option>
					<option value='ColonyCareGiver'>Colony Caregiver</option>
					<option value='EarTipped'>Ear Tipped</option>
					<option value='Pregnant'>Pregnant</option>
					<option value='Injured'>Injured</option>
					<option value='ColonySetting'>Colony Setting</option>
					<option value='Comments'>Comments</option>
					<option value='VolunteerResponding'>Volunteer Responding</option>
					<option value='ResponseDate'>Response Date</option>
					<option value='CustNeedOutcome'>Customer Need Outcome</option>
					<option value='BeatTeamLeader'>Beat Team Leader</option>
					<option value='Outcome'>Outcome</option>
					<option value='CompletionDate'>Completion Date</option>
				  </select>
				 <br>
				 <input type='submit' name='Submit' value='Submit' tabindex='2' />
			
			</form>
			";
			
			$thString="";
			$tdString="";
			$thEditString="";
			$tdEditString="";
			foreach ($_GET['select2'] as $selectedOption)
			{
				$thEditString.="<th><a>".$selectedOption."</a></th>";
								
				//echo $selectedOption."\n";
			}
			
			//<td>$Comments</td>
			foreach ($_GET['select2'] as $selectedOption)
			{
				//$tdString.="<td>$".$selectedOption."</td>";
					$tdString.=" ";			
				//echo $selectedOption."\n";
			}
			
			//print $tdString;
			// how to do this correctly
			//				<th><a href='search.php?select2%5B%5D=Phone1&Submit=Submit&sort=RecordNumber'>Record_Number</a></th>
			foreach ($_GET['select2'] as $selectedOption)
			{
				$thString.="<th><a href='search.php?sort=".$selectedOption."'>".$selectedOption."</a></th>";
								
				//echo $selectedOption."\n";
			}
			
			foreach ($_GET['select2'] as $selectedOption)
			{
				if($selectedOption=="RecordNumber" || $selectedOption=="DateAndTime" )
					$tdEditString.="<td><input type='hidden' name='".$selectedOption."' value='$".$selectedOption."'>$".$selectedOption."</td>";
				else
					$tdEditString.="<td><input type='text' name='".$selectedOption."' value='".$selectedOption."'>$".$selectedOption."</td>";
									
				//echo $selectedOption."\n";
			}
			
			/*
			print"<table><thead><tr>";
			print $thString;
			print"</tr></thead>";
			
			
			print"<tbody><tr>";
			print $tdString;
			print"</tr></tbody></table>";
			
			print"<tbody><tr>";
			print $tdEditString;
			print"</tr></tbody></table>";
			*/
			
			
			/* this doesn't work with edit yet
			print "<b>Select which tables you would like to view: </b><br>
			<input type='checkbox' name='searchtables[]' value='ReportColonyForm' class='checkdisplay' > ReportColonyForm 
			<input type='checkbox' name='searchtables[]' value='FeralInterventionForm' class='checkdisplay1' > FeralInterventionForm 
			<input type='checkbox' name='searchtables[]' value='VolunteerForm' class='checkdisplay2' > VolunteerForm 
			<input type='checkbox' name='searchtables[]' value='SundaySSPCA' class='checkdisplay3' > SundaySSPCA 
			<input type='checkbox' name='searchtables[]' value='EmergencyC4CCVouchers' class='checkdisplay4' > EmergencyC4CCVouchers 
			<div class='todisplay'>"; */
			
			
			
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

				$query = "select * from ReportColonyForm order by $sort";
				$result = mysqli_query($link, $query);
				
				
				// print table (happens first before input)

					// first print row of links/headers that sort
					print "
					<form method='post' action='search.php'>
					
					<br><b>Report A Feral Cat Colony</b><br><br>
				
					<table>
						<thead>
							<tr>
								<th> </th>";
							
							if($thString != '')
							{
								print $thString;
								print"</tr></thead>";
								print"(getEditRow is set header)";
							}
							else
							{
								print "
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
						";
							}
						
						print "<tbody>"; 
						
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
																			
							if($RecordNumber1==$RecordNumber)
							{
								print "
								<tr>
									<td> <label><input type='submit' name='recordEdit' value='Submit Edit'></label>
										 <label><input type='submit' name='cancel' value='Cancel Edit'></label> </td>";
										 
								if($tdEditString != '')
								{
									print $tdEditString;
									print"</tr>";
									//print"(editable geteditRow is set Body)";
								}
								else
								{
									print "
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
									<td><input type='text' name='AnyoneAttempted' value='$AnyoneAttempted'></td>
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
							}
							else
							{
								print "
								<tr>
									<td><a style='background-color:lightgreen;' href='search.php?editrow=yes&RecordNumber=$RecordNumber'>Edit</a> <a style='background-color:#ff8080;' href='search.php?del=yes&RecordNumber=$RecordNumber'  class='confirmation'>Delete</a> </td>
								";
							
								if($tdString != '')
								{
									print $tdString;
									print"</tr>";
									//print"(un editable getEditRow is set Body )";
								}
								else
								{
									print "

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
							}
						}
						print "
						</tbody></div>
					</table>
					
					
					

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
			
			
			
			if(!isset($_GET['editrow']))
			{
			//if edit is not set
			
			// print table (happens first before input)
			
				// first print row of links/headers that sort
				print "
				<br><b>Report A Feral Cat Colony</b><br><br>
				
				<table>
					<thead>
						<tr>
							<th>  </th>";
							
							if($thString != '')
								{
									print $thString;
									print"</tr>";
									//print"(editRow not set header)";
								}
								else
								{
									print "

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
							
						</tr>";
								}
					print"
					</thead>
					
					<tbody>";
					
					//while the next row (set by query) exists?
					
					$k=0;
					while($row = mysqli_fetch_row($result))
					{
						list($RecordNumber, $DateAndTime, $FullName, $Email, $Phone1, $Phone2, $ColonyName, $ColonyAddress, 
						$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $ColonyCareGiver, $EarTipped, $Pregnant, 
						$Injured, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader, 
						$Outcome, $CompletionDate) = $row; // variables are set to current row
																		// then printed in one table row
						
						
						$myArray[0]=$RecordNumber;
						$myArray[1]=$DateAndTime;
						$myArray[2]=$FullName;
						$myArray[3]=$Email;
						$myArray[4]=$Phone1;
						$myArray[5]=$Phone2;
						$myArray[6]=$ColonyName;
						$myArray[7]=$ColonyAddress;
						$myArray[8]=$City;
						$myArray[9]=$County;
						$myArray[10]=$ZipCode;
						$myArray[11]=$AnyoneAttempted;
						$myArray[12]=$ApproximateCats;
						$myArray[13]=$ColonyCareGiver;
						$myArray[14]=$EarTipped;
						$myArray[15]=$Pregnant;
						$myArray[16]=$Injured;
						$myArray[17]=$ColonySetting;
						$myArray[18]=$Comments;
						$myArray[19]=$VolunteerResponding;
						$myArray[20]=$ResponseDate;
						$myArray[21]=$CustNeedOutcome;
						$myArray[22]=$BeatTeamLeader;
						$myArray[23]=$Outcome;
						$myArray[24]=$CompletionDate;
						
						$myArray1[0]="RecordNumber";
						$myArray1[1]="DateAndTime";
						$myArray1[2]="FullName";
						$myArray1[3]="Email";
						$myArray1[4]="Phone1";
						$myArray1[5]="Phone2";
						$myArray1[6]="ColonyName";
						$myArray1[7]="ColonyAddress";
						$myArray1[8]="City";
						$myArray1[9]="County";
						$myArray1[10]="ZipCode";
						$myArray1[11]="AnyoneAttempted";
						$myArray1[12]="ApproximateCats";
						$myArray1[13]="ColonyCareGiver";
						$myArray1[14]="EarTipped";
						$myArray1[15]="Pregnant";
						$myArray1[16]="Injured";
						$myArray1[17]="ColonySetting";
						$myArray1[18]="Comments";
						$myArray1[19]="VolunteerResponding";
						$myArray1[20]="ResponseDate";
						$myArray1[21]="CustNeedOutcome";
						$myArray1[22]="BeatTeamLeader";
						$myArray1[23]="Outcome";
						$myArray1[24]="CompletionDate";
						
						
						print "
						<tr>
							<td><a style='background-color:lightgreen;' href='search.php?editrow=yes&RecordNumber=$RecordNumber'>Edit</a> <a style='background-color:#ff8080;' href='search.php?del=yes&RecordNumber=$RecordNumber'  class='confirmation'>Delete</a> </td>
							";
							
							//$_GET['select2'] as RecordNumber
							foreach ($_GET['select2'] as $selectedOption)//only once every time.. record number
							{
								for ($i = 0; $i<25; $i++) 
								{
									//if recordNumber == recordNumber
									if ($myArray1[$i] == $selectedOption) 
									{
										$tdString.="<td>$myArray[$i]</td>";
										break;
									}
								}
									
							}
							
							if($tdString != '')
							{
								print $tdString;
								print"</tr>";
								$tdString=" ";
								//print"(editRow not set Body)";
							}
							else
							{
								print "
									
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
								$k++;
					}
					print "
					</tbody>
				</table>";
				
			}
			
			/* this doesn't work with edit yet
			print "
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
			*/


			
				
		}
		else if($level == 2)
		{
			print "you aren't supposed to be here.. STOP SNEAKING AROUND";
		}

		
	}
?>

</body>
</html>