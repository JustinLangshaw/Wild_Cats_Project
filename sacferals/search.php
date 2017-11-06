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


<?php
	//if no ones logged in, print login screen
	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{
		header("Location: userprofile.php");
		exit();
	}
	//once you're logged in, show menu/options

	else 
	{ 	//print out errors:
		//error_reporting(-1);
		//ini_set('display_errors', 'On');
		
		$Ausername = $_SESSION['Ausername'];
		$level = $_SESSION['level'];

		if($level == 1)
		{
?>
	<div style='float:right'>
		<div class='dropdown'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'><img src='images/menu_icon.png' width='20' height='20'>
			<span class='caret'></span></button>
			<ul class='dropdown-menu dropdown-menu-right'>
				<li><a href='https://www.catstats.org/' target='_blank'>CatStats Website</a></li>
				<li class='divider'></li>
				<li><a href='./updateprofile.php'>Update Profile</a></li>
				<li><a href='./logout.php'>Sign Out</a></li>
			</ul>
		</div>
	</div>

	<b>Logged in as <?php echo $Ausername ?></b> <br><br>

	- <a href='userprofile.php' align='right'>Back to Admin Hub</a><br><br>

	<div class="container" style="margin: 0 0">
	<div class="row">
		<div class="col-md-4">
			<div style='color:red' >Note: Hold down ctrl or shift to select multiple columns</div>
			<form id='form1' name='form1' method='get' action='search.php'>
				<select name='select2[]' size='7' multiple='multiple' tabindex='1'>
					<option value='Comments1'>Comments</option>
					<option value='Responder'>Responder</option>
					<option value='Status'>Status</option>
					<option value='RecordNumber'>Record Number</option>
					<option value='DateAndTime'>Date And Time</option>
					<option value='FullName'>Full Name</option>
					<option value='Email'>Email</option>
					<option value='Phone1'>Phone1</option>
					<option value='Phone2'>Phone2</option>
					<option value='ColonyAddress'>Colony Address</option>
					<option value='City'>City</option>
					<option value='County'>County</option>
					<option value='ZipCode'>ZipCode</option>
					<option value='AnyoneAttempted'>Anyone Attempted</option>
					<option value='ApproximateCats'>Approximate Cats</option>
					<option value='Kittens'>Kittens</option>
					<option value='ColonyCareGiver'>Colony Caregiver</option>
					<option value='FeederDescription'>Feeder Description</option>
					<option value='Injured'>Injured/Pregnant</option>
					<option value='InjuryDescription'>Injury Description</option>
					<option value='FriendlyPet'>Friendly/Pet</option>
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
				 <input type='submit' name='Select All' value='Reset'/>
			</form>
		</div>
		<div class="col-md-8">
			<form id="queryform" method='get' action='search.php'>
			<!-- Custom Query -->
			<div class="row"> <b>Custom Query</b> </div>
			<div class="row" style="padding: 10px 0">
				<select name="query[]" tabindex='3'>
					<option value='Comments1'>Comments</option>
					<option value='Responder'>Responder</option>
					<option value='Status'>Status</option>
					<option value='RecordNumber'>Record Number</option>
					<option value='DateAndTime'>Date And Time</option>
					<option value='FullName'>Full Name</option>
					<option value='Email'>Email</option>
					<option value='Phone1'>Phone1</option>
					<option value='Phone2'>Phone2</option>
					<option value='ColonyAddress'>Colony Address</option>
					<option value='City'>City</option>
					<option value='County'>County</option>
					<option value='ZipCode'>ZipCode</option>
					<option value='AnyoneAttempted'>Anyone Attempted</option>
					<option value='ApproximateCats'>Approximate Cats</option>
					<option value='Kittens'>Kittens</option>
					<option value='ColonyCareGiver'>Colony Caregiver</option>
					<option value='FeederDescription'>Feeder Description</option>
					<option value='Injured'>Injured/Pregnant</option>
					<option value='InjuryDescription'>Injury Description</option>
					<option value='FriendlyPet'>Friendly/Pet</option>
					<option value='ColonySetting'>Colony Setting</option>
					<option value='Comments'>Comments</option>
					<option value='VolunteerResponding'>Volunteer Responding</option>
					<option value='ResponseDate'>Response Date</option>
					<option value='CustNeedOutcome'>Customer Need Outcome</option>
					<option value='BeatTeamLeader'>Beat Team Leader</option>
					<option value='Outcome'>Outcome</option>
					<option value='CompletionDate'>Completion Date</option>
				</select>

				<select name="condition[]" tabindex='4'>
					<option value='='>=</option>
					<option value='!='>!=</option>
					<option value='<'><</option>
					<option value='>'>></option>
					<option value='<='><=</option>
					<option value='>='>>=</option>
					<option value='contains'>contains</option>
				</select>

				<input type="text" name="queryvalue" placeholder="By value" tabindex='5'/>
				<input type="submit" name="submitquery" value="Search" tabindex='5'/>
			</div>
			</form>
		</div>
	</div>
	</div>

<?php		
			$thString="";
			$tdString="";
			$thEditString="";
			$tdEditString="";
			
			//change selected columns only if unset
			//if(!isset($_SESSION['selectedColumns'])){ 

			if(count($_SESSION['selectedColumns']) > 0 && ( count($_GET['editrow']) != 0 || count($_POST['recordEdit']) != 0 ))
			{
				$_GET['select2'] = $_SESSION['selectedColumns'];
			}

			if(count($_GET['select2']) >= 0)
			{
				$_SESSION['selectedColumns'] = $_GET['select2'];
			}

			foreach ($_GET['select2'] as $selectedOption)
			{
				$thEditString.="<th><a>".$selectedOption."</a></th>";
			}

			foreach ($_GET['select2'] as $selectedOption)
			{
				$tdString.="<td>$".$selectedOption."</td>";
			}

			foreach ($_GET['select2'] as $selectedOption)
			{
				$thString.="<th><a href='search.php?sort=".$selectedOption."'>".$selectedOption."</a></th>";
			}

			foreach ($_GET['select2'] as $selectedOption)
			{
				if($selectedOption=="RecordNumber" || $selectedOption=="DateAndTime" )
					$tdEditString.="<td><input type='hidden' name='".$selectedOption."' value='$".$selectedOption."'>$".$selectedOption."</td>";
				else
					$tdEditString.="<td><input type='text' name='".$selectedOption."' value='".$selectedOption."'>$".$selectedOption."</td>";
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

			//custom query builder search
			if(isset($_GET['submitquery'])){
				unset($_SESSION['querysearch']); //refresh variable
				//mysql: contains == like
					// column like '%value%'
				$value = $_GET['queryvalue'];
				if($value!=NULL) {
					$column = $_GET['query'];
					$condition = $_GET['condition'];
					if($condition[0]=='contains'){
						$condition[0]=" like ";
						$value="%".$value."%";
					}
					
					$search = "select * from ReportColonyForm where ".$column[0].$condition[0]."'".$value."'";
					$r = mysqli_query($link, $search);
					if(mysqli_num_rows($r)==0)
						echo "<h3 style='color:RED'> EMPTY QUERY </h3>";
					else $_SESSION['querysearch'] = $search;
				}
			}
			
			if(isset($_GET['Reset']))
			{
				unset($_SESSION['selectedColumns']);
			}
			if(isset($_GET['RefreshTable'])){ //nullify the query
				unset($_SESSION['querysearch']);
			}
			
			///////////////////////////////////////////////////////////////////////////////////////////
			//edit detector
			if(isset($_GET['editrow']))
			{
				$RecordNumber1 = $_GET['RecordNumber'];
				$query = "select * from ReportColonyForm  where RecordNumber = ".$RecordNumber1."";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($Comments1, $Responder, $Status, $RecordNumber, $DateAndTime, $FullName, $Email, $Phone1, $Phone2, $ColonyAddress,
						$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $Kittens, $ColonyCareGiver, $FeederDescription,
						$Injured, $InjuryDescription, $FriendlyPet, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader,
						$Outcome, $CompletionDate) = $row;

					$sort = $_GET['sort']; //'sort' is magic sorting variable
					if(!isset($sort))
					{
						$sort = "RecordNumber";
					}
				if(isset($_SESSION['querysearch'])){
					//query search
					$s = mysqli_query($link, $_SESSION['querysearch']);
					if (mysqli_num_rows($s)!=0) $result = $s;
				}
				else{
					//regular search
					$query = "select * from ReportColonyForm order by $sort";
					$result = mysqli_query($link, $query);
				}
				
				//////////////////////////////////////////////////////////////////////////////////////
				// print table (happens first before input)

					// first print row of links/headers that sort
					print "
					<form method='post' action='search.php'>

					<br><b>Report A Feral Cat Colony</b><br><br>

					<table id='reportTable'>
						<thead style='width: 6594px;'>
							<tr>
								<th> </th>";

							if($thString != '')
							{
								print $thString;
								print"</tr></thead>";
								//print"(getEditRow is set header)";
							}
							else
							{
								print "
								<th><a>Comments1</a></th>
								<th><a>Responder</a></th>
								<th><a>Status</a></th>
								<th><a>Record_Number</a></th>
								<th><a>Date_And_Time</a></th>
								<th><a>Full_Name</a></th>
								<th><a>Email</a></th>
								<th><a>Phone_1</a></th>
								<th><a>Phone_2</a></th>
								<th id='addressHead'><a>ColonyAddress</a></th>
								<th><a>City</a></th>
								<th><a>County</a></th>
								<th><a>Zip_Code</a></th>
								<th><a>Anyone_Attempted</a></th>
								<th><a>Approximate_Cats</a></th>
								<th><a>Kittens</a></th>
								<th><a>Colony_Caregiver</a></th>
								<th><a>Feeder_Description</a></th>
								<th><a>Injured/Pregnant</a></th>
								<th><a>Injury_Description</a></th>
								<th><a>Friendly/Pet</a></th>
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

						print "<tbody style='width: 6594px;'>";

						//while the next row (set by query) exists?



						while($row = mysqli_fetch_row($result))
						{
							list($Comments1, $Responder, $Status, $RecordNumber, $DateAndTime, $FullName, $Email, $Phone1, $Phone2, $ColonyAddress,
							$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $Kittens, $ColonyCareGiver, $FeederDescription,
							$Injured, $InjuryDescription, $FriendlyPet, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader,
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
									$tdEditString = '';

									/*
									if(in_array($RecordNumber, $_GET['select2']))
									{
										echo "howdy";
										$tdEditString.="<td><input name='RecordNumber' value='".$RecordNumber1."' readonly></td>";
									}*/



									foreach ($_GET['select2'] as $selectedOption)
									{
										if($selectedOption=="RecordNumber" || $selectedOption=="DateAndTime" )
										{
											$tdEditString.="<td>".$$selectedOption."</td>";
										}
										else
										{
											$tdEditString.="<td><input type='text' name='".$selectedOption."' value='".$$selectedOption."'></td>";
										}
										//echo $selectedOption."\n";
									}


									if(!in_array($RecordNumber, $_GET['select2']))
									{

										$tdEditString.="<input type='hidden' name='RecordNumber' value='".$RecordNumber1."' readonly>";
									}

									print $tdEditString;
									print"</tr>";
									//print"(editable geteditRow is set Body)";
								}
								else
								{
									print "
									<td><input type='text' name='Comments1' value='$Comments1'></td>
									<td><input type='text' name='Responder' value='$Responder'></td>
									<td><div style='text-align:Center'>Current Status: ' $Status '
									<div style='text-align:Center'><div class='dropdown'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Change Report Status<span class='caret'></span></button>
										<ul class='dropdown-menu dropdown-menu-center'>
											<li><div style='text-align:Center'>Changes Applied when Submit Edit is clicked</li>
											<li><div style='text-align:Center'><form id='form1' name='form1' method='get' action='search.php' width: 400px>
												<select name='Status' size='4' abindex='1' style='width:150px'>
													<option value='Open'>Open</option>
													<option value='Closed'>Closed</option>
													<option value='Critical'>Critical</option>
													<option value='Kittens'>Kittens!</option>
												</select><br>
									</form></li></ul></div></div></div></td>
									<td><input type='hidden' name='RecordNumber' value='$RecordNumber'>$RecordNumber</td>
									<td><input type='hidden' name='DateAndTime' value='$DateAndTimes'>$DateAndTime</td>
									<td><input type='text' name='FullName' value='$FullName'></td>
									<td><input type='text' name='Email' value='$Email'></td>
									<td><input type='text' name='Phone1' value='$Phone1'></td>
									<td><input type='text' name='Phone2' value='$Phone2'></td>
									<td><input type='text' name='ColonyAddress' value='$ColonyAddress'></td>
									<td><input type='text' name='City' value='$City'></td>
									<td><input type='text' name='County' value='$County'></td>
									<td><input type='text' name='ZipCode' value='$ZipCode'></td>
									<td><input type='text' name='AnyoneAttempted' value='$AnyoneAttempted'></td>
									<td><input type='text' name='ApproximateCats' value='$ApproximateCats'></td>
									<td><input type='text' name='Kittens' value='$Kittens'></td>
									<td><input type='text' name='ColonyCareGiver' value='$ColonyCareGiver'></td>
									<td><input type='text' name='FeederDescription' value='$FeederDescription'></td>
									<td><input type='text' name='Injured' value='$Injured'></td>
									<td><input type='text' name='InjuryDescription' value='$InjuryDescription'></td>
									<td><input type='text' name='FriendlyPet' value='$FriendlyPet'></td>
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
									<td><a style='background-color:lightgreen;' href='search.php?editrow=yes&RecordNumber=$RecordNumber'>Edit</a> <a style='background-color:#ff8080;' href='search.php?del=yes&RecordNumber=$RecordNumber'  class='confirmation'>Delete</a> <a style = 'background-color:#00ffff;' href='form_view.php' target = '_blank'>Form View </a> </td>
								";

								if($tdString != '')
								{
									$tdString = "";
									foreach ($_GET['select2'] as $selectedOption)
									{
										$tdString.="<td>".$$selectedOption."</td>";
										//echo $selectedOption."\n";
									}
									print $tdString;
									print"</tr>";
									//$tdString = " ";
									//print"(un editable getEditRow is set Body )";
								}
								else
								{
									print "
									<td>$Comments1</td>
									<td>$Responder</td>
									<td id='statusCol'>$Status</td>
									<td>$RecordNumber</td>
									<td id='dateTimeCol'>$DateAndTime</td>
									<td>$FullName</td>
									<td>$Email</td>
									<td>$Phone1</td>
									<td>$Phone2</td>
									<td id='addressCol'>$ColonyAddress</td>
									<td id='cityCol'>$City</td>
									<td>$County</td>
									<td id='zipCodeCol'>$ZipCode</td>
									<td>$AnyoneAttempted</td>
									<td>$ApproximateCats</td>
									<td>$Kittens</td>
									<td>$ColonyCareGiver</td>
									<td>$FeederDescription</td>
									<td>$Injured</td>
									<td>$InjuryDescription</td>
									<td>$FriendlyPet</td>
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
				//echo "In the recordEdit IF loop!!";
				$Comments1 = $_POST['Comments1'];
				$Responder = $_POST['Responder'];
				$Status = $_POST['Status'];
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
				$VolunteerResponding = $_POST['VolunteerResponding'];
				$ResponseDate = $_POST['ResponseDate'];
				$CustNeedOutcome = $_POST['CustNeedOutcome'];
				$BeatTeamLeader = $_POST['BeatTeamLeader'];
				$Outcome = $_POST['Outcome'];
				$CompletionDate = $_POST['CompletionDate'];

				//echo $_POST['RecordNumber'];
				//echo $RecordNumber1;

				$reName = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";

				if(true) //preg_match($reName, $FullName) &&
				{
					//print  "count is : ".count($_GET['select2']);
					//print_r($_GET['select2']);

					if(count($_GET['select2']) !=0 )
					{
						/* Build $query*/

						$query = "select * from ReportColonyForm where ";

						foreach($_GET['select2'] as $selectedItem)
						{
							$query.=$selectedItem." ='".$$selectedItem."'";
							$query.=" and ";
						}

						$query=rtrim($query," and ");

						//print $query;

						$result = mysqli_query($link, $query);

						if(mysqli_num_rows($result) == 0)
						{
							$queryupdate = " update ReportColonyForm set ";

							if(count($_GET['select2'] == 0))
							{
								//print "hi?";
							}

							foreach($_GET['select2'] as $selectedItem)
							{
								if($selectedItem == "RecordNumber" || $selectedItem == "DateAndTime")
								{
									continue;
								}

								$queryupdate.=$selectedItem."='".$$selectedItem."'";
								$queryupdate.=", ";
							}
							$queryupdate=rtrim($queryupdate,", ");


							$queryupdate.=" where RecordNumber='$RecordNumber1'";

							//print $queryupdate;

							mysqli_query($link, $queryupdate);

						}
					}
					else
					{


						$query = "select * from ReportColonyForm where RecordNumber='$RecordNumber1'";
						$result = mysqli_query($link, $query);

						if(mysqli_num_rows($result) == 1)//if query does nothing, then update
						{
							$queryupdate = "update ReportColonyForm set Comments1='$Comments1', Responder='$Responder', Status='$Status',
								 FullName='$FullName', Email='$Email',
								 Phone1='$Phone1', Phone2='$Phone2', ColonyAddress='$ColonyAddress',
								 City='$City', County='$County', ZipCode='$ZipCode', AnyoneAttempted='$AnyoneAttempted',
								 ApproximateCats='$ApproximateCats', Kittens='$Kittens', ColonyCareGiver='$ColonyCareGiver', FeederDescription='$FeederDescription',
								 Injured='$Injured', InjuryDescription='$InjuryDescription', FriendlyPet='$FriendlyPet', ColonySetting='$ColonySetting', Comments='$Comments',
								 VolunteerResponding='$VolunteerResponding', ResponseDate='$ResponseDate', CustNeedOutcome='$CustNeedOutcome',
								 BeatTeamLeader='$BeatTeamLeader', Outcome='$Outcome', CompletionDate='$CompletionDate' where RecordNumber='$RecordNumber1'";

							//echo $queryupdate;
							mysqli_query($link, $queryupdate);
							print "<h2>Record was updated</h2>";
						}

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
				//print $query;
				print "<h2>Record Deleted</h2>";
				//showReportColony();
			}

			$sort = $_GET['sort']; //'sort' is magic sorting variable
			if(!isset($sort))
			{
				$sort = "RecordNumber";
			}

			if(isset($_SESSION['querysearch'])){
				//query search
				$s = mysqli_query($link, $_SESSION['querysearch']);
				if (mysqli_num_rows($s)!=0)
					$result = $s;
			}
			else{
				//regular search
				$query = "select * from ReportColonyForm order by $sort";
				$result = mysqli_query($link, $query);
			}
			if(!isset($_GET['editrow']))
			{
			//if edit is not set

			// print table (happens first before input)

				// first print row of links/headers that sort
				print "
				<br><b>Report A Feral Cat Colony</b><br><br>

				<table id='reportTable'>
					<thead style='width: 6594px;'>
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

							<th><a href='search.php?sort=Comments1'>Comments</a></th>
							<th><a href='search.php?sort=Responder'>Responder</a></th>
							<th><a href='search.php?sort=Status'>Status</a></th>
							<th><a href='search.php?sort=RecordNumber'>Record_Number</a></th>
							<th><a href='search.php?sort=DateAndTime'>Date_And_Time</a></th>
							<th><a href='search.php?sort=FullName'>Full_Name</a></th>
							<th><a href='search.php?sort=Email'>Email</a></th>
							<th><a href='search.php?sort=Phone1'>Phone_1</a></th>
							<th><a href='search.php?sort=Phone2'>Phone_2</a></th>
							<th><a href='search.php?sort=ColonyAddress'>ColonyAddress</a></th>
							<th><a href='search.php?sort=City'>City</a></th>
							<th><a href='search.php?sort=County'>County</a></th>
							<th><a href='search.php?sort=ZipCode'>Zip_Code</a></th>
							<th><a href='search.php?sort=AnyoneAttempted'>Anyone_Attempted</a></th>
							<th><a href='search.php?sort=ApproximateCats'>Approximate_Cats</a></th>
							<th><a href='search.php?sort=Kittens'>Kittens</a></th>
							<th><a href='search.php?sort=ColonyCareGiver'>Colony_Caregiver</a></th>
							<th><a href='search.php?sort=FeederDescription'>Feeder_Description</a></th>
							<th><a href='search.php?sort=Injured'>Injured/Pregnant</a></th>
							<th><a href='search.php?sort=InjuryDescription'>InjuryDescription</a></th>
							<th><a href='search.php?sort=FriendlyPet'>Friendly/Pet</a></th>
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

					<tbody style='width: 6594px;'>";

					//while the next row (set by query) exists?

					while($row = mysqli_fetch_row($result))
					{
						list($Comments1, $Responder, $Status, $RecordNumber, $DateAndTime, $FullName, $Email, $Phone1, $Phone2, $ColonyAddress,
						$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $Kittens, $ColonyCareGiver, $FeederDescription,
						$Injured, $InjuryDescription, $FriendlyPet, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader,
						$Outcome, $CompletionDate) = $row; // variables are set to current row
																		// then printed in one table row


						$myArray[0]=$Comments1;
						$myArray[1]=$Responder;
						$myArray[2]=$Status;
						$myArray[3]=$RecordNumber;
						$myArray[4]=$DateAndTime;
						$myArray[5]=$FullName;
						$myArray[6]=$Email;
						$myArray[7]=$Phone1;
						$myArray[8]=$Phone2;
						$myArray[9]=$ColonyAddress;
						$myArray[10]=$City;
						$myArray[11]=$County;
						$myArray[12]=$ZipCode;
						$myArray[13]=$AnyoneAttempted;
						$myArray[14]=$ApproximateCats;
						$myArray[15]=$Kittens;
						$myArray[16]=$ColonyCareGiver;
						$myArray[17]=$FeederDescription;
						$myArray[18]=$Injured;
						$myArray[19]=$InjuryDescription;
						$myArray[20]=$FriendlyPet;
						$myArray[21]=$ColonySetting;
						$myArray[22]=$Comments;
						$myArray[23]=$VolunteerResponding;
						$myArray[24]=$ResponseDate;
						$myArray[25]=$CustNeedOutcome;
						$myArray[26]=$BeatTeamLeader;
						$myArray[27]=$Outcome;
						$myArray[28]=$CompletionDate;

						$myArray1[0]="Comments1";
						$myArray1[1]="Responder";
						$myArray1[2]="Status";
						$myArray1[3]="RecordNumber";
						$myArray1[4]="DateAndTime";
						$myArray1[5]="FullName";
						$myArray1[6]="Email";
						$myArray1[7]="Phone1";
						$myArray1[8]="Phone2";
						$myArray1[9]="ColonyAddress";
						$myArray1[10]="City";
						$myArray1[11]="County";
						$myArray1[12]="ZipCode";
						$myArray1[13]="AnyoneAttempted";
						$myArray1[14]="ApproximateCats";
						$myArray1[15]="Kittens";
						$myArray1[16]="ColonyCareGiver";
						$myArray1[17]="FeederDescription";
						$myArray1[18]="Injured";
						$myArray1[19]="InjuryDescription";
						$myArray1[20]="FriendlyPet";
						$myArray1[21]="ColonySetting";
						$myArray1[22]="Comments";
						$myArray1[23]="VolunteerResponding";
						$myArray1[24]="ResponseDate";
						$myArray1[25]="CustNeedOutcome";
						$myArray1[26]="BeatTeamLeader";
						$myArray1[27]="Outcome";
						$myArray1[28]="CompletionDate";

						print "
						<tr>
							<td><a style='background-color:lightgreen;' href='search.php?editrow=yes&RecordNumber=$RecordNumber'>Edit</a> <a style='background-color:#ff8080;' href='search.php?del=yes&RecordNumber=$RecordNumber'  class='confirmation'>Delete</a> <a style = 'background-color:#00ffff;' href='form_view.php' target = '_blank'>Form View </a> </td>
							";

							//$_GET['select2'] as RecordNumber
							foreach ($_GET['select2'] as $selectedOption)//only once every time.. record number
							{
								for ($i = 0; $i<29; $i++)
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
								$tdString = "";
									foreach ($_GET['select2'] as $selectedOption)
									{
										switch($selectedOption){
											case 'Status': $tdString.="<td = id='statusCol'>".$$selectedOption."</td>"; break;
											case 'DateAndTime': $tdString.="<td = id='dateTimeCol'>".$$selectedOption."</td>"; break;
											case 'ColonyAddress': $tdString.="<td = id='addressCol'>".$$selectedOption."</td>"; break;
											case 'City': $tdString.="<td = id='cityCol'>".$$selectedOption."</td>"; break;
											case 'ZipCode': $tdString.="<td = id='zipCodeCol'>".$$selectedOption."</td>"; break;
											default: $tdString.="<td>".$$selectedOption."</td>";

										}
										//echo $selectedOption."\n";
									}
								print $tdString;
								print"</tr>";
								$tdString=" ";
								//print"(editRow not set Body)";
							}
							else
							{
								print "

							<td>$Comments1 </td>
							<td>$Responder </td>
							<td id='statusCol'>$Status </td>
							<td>$RecordNumber </td>
							<td id='dateTimeCol'>$DateAndTime</td>
							<td>$FullName</td>
							<td>$Email</td>
							<td>$Phone1</td>
							<td>$Phone2</td>
							<td id='addressCol'>$ColonyAddress</td>
							<td id='cityCol'>$City</td>
							<td>$County</td>
							<td id='zipCodeCol'>$ZipCode</td>
							<td>$AnyoneAttempted</td>
							<td>$ApproximateCats</td>
							<td>$Kittens</td>
							<td>$ColonyCareGiver</td>
							<td>$FeederDescription</td>
							<td>$Injured</td>
							<td>$InjuryDescription</td>
							<td>$FriendlyPet</td>
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

<!DOCTYPE html>
<html lang="en">
   	<head>
		<title>Record Search</title>
	    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	    <link rel="stylesheet" type="text/css" href="search.css" />
  	</head>
   	<body onload="initialize()">
   		<br>
   		<form id="resettable" method='get' action='search.php'>
			<input type="submit" value="Refresh Table" name="RefreshTable"/>
   		</form>
   		<div>
      		<br><label><b>Clustered Hot Spot</b></label>
      		<br><button id='clusterAddrBtn' type='button' onclick='mapQuery(); setTimeout(unfoundAddrCount, 1000);'>Map Query</button>
      		<button id='clusterAddrClearBtn' type='button' onclick='clearMap()'>Clear Map</button>
      		<div style='padding-bottom:10px'>
         		<div class='alert' id='alert' style='display:none'>
            		<span class='closebtn' onclick=this.parentElement.style.display='none';>&times</span>
            		<label id='errorMsg'></label>
         		</div>
      		</div>
     		<div id="map-canvas" style="height:90%;top:30px"></div>
   		</div>
   		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
   		<script src="searchScript.js"></script>
   		<script async defer
      		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDz2ZSC6IJEf38QeSbLwIxTEohm4ATem9M&callback=initMap"></script>
   		<script type="text/javascript" src="clustermapScript.js"></script>
   		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</body>
</html>
