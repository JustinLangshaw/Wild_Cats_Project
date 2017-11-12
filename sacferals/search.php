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

<!DOCTYPE html>
<html lang="en">
   	<head>
		<title>Record Search</title>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="https://unpkg.com/ng-table@2.0.2/bundles/ng-table.min.css">
		<link rel="stylesheet" href="css/search.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.2/angular.js"></script>
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="https://unpkg.com/ng-table@2.0.2/bundles/ng-table.min.js"></script>
       	
       	<script src="exportExcelScript.js?version=1.5"></script>
		<script src="js/customquery.js"></script> 
  	</head>
	<body>
	<div class="row">
		<div class="col-sm-6">
			<b>Logged in as <?php echo $Ausername ?></b> <br><br>
			
			- <a href='userprofile.php' align='right'>Back to Admin Hub</a>
		</div>
		<div class="col-sm-6">
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
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-4">
			<div id="columnselect">Note: Hold down ctrl or shift to select multiple columns</div>
			<form id='form1' name='form1' method='get' action='search.php'>
				<select class="input-sm" name='select2[]' size='7' multiple='multiple' tabindex='1'>
					<option value='RecordNumber'>ID</option>
					<option value='Comments1'>Comments</option>
					<option value='Responder'>Responder</option>
					<option value='Status'>Status</option>
					<option value='DateAndTime'>Date And Time</option>
					<option value='FeedIfReturned'>Feed If Returned</option>
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
					<option value='Comments'>Additional Comments</option>
					<option value='ReqAssitance'>Require Assitance</option>
					<option value='VolunteerResponding'>Volunteer Responding</option>
					<option value='ResponseDate'>Response Date</option>
					<option value='CustNeedOutcome'>Customer Need Outcome</option>
					<option value='BeatTeamLeader'>Beat Team Leader</option>
					<option value='Outcome'>Outcome</option>
					<option value='CompletionDate'>Completion Date</option>
					<option value='Lat'>Latitude</option>
					<option value='Lng'>Longitude</option>
				  </select>
				 <br>

				 <input class="btn btn-primary" type='submit' name='Submit' value='Submit' tabindex='2' />
				 <input class="btn" type='submit' name='Select All' value='Reset'/>
			</form>
		</div>
		<div class="col-md-8">
			<form id="queryform" method='get' action='search.php'>
			<!-- Custom Query -->
			<div class="row">
				<b>Custom Query</b>
			</div>
			<div class="row" id="cqrow">
				<div id="blueprint">
					<select class="input-sm" id="query" name="query[]" tabindex='3'>
						<option value='RecordNumber'>ID</option>
						<option value='Comments1'>Comments</option>
						<option value='Responder'>Responder</option>
						<option value='Status'>Status</option>
						<option value='DateAndTime'>Date And Time</option>
						<option value='FeedIfReturned'>Feed If Returned</option>
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
						<option value='Comments'>Additional Comments</option>
						<option value='ReqAssitance'>Require Assistance</option>
						<option value='VolunteerResponding'>Volunteer Responding</option>
						<option value='ResponseDate'>Response Date</option>
						<option value='CustNeedOutcome'>Customer Need Outcome</option>
						<option value='BeatTeamLeader'>Beat Team Leader</option>
						<option value='Outcome'>Outcome</option>
						<option value='CompletionDate'>Completion Date</option>
						<option value='Lat'>Latitude</option>
						<option value='Lng'>Longitude</option>
					</select>

					<select class="input-sm" id="condition" name="condition[]" tabindex='4'>
						<option value='='>=</option>
						<option value='!='>&ne;</option>
						<option value='<'>&lt;</option>
						<option value='>'>&gt;</option>
						<option value='<='>&le;</option>
						<option value='>='>&ge;</option>
						<option value='contains'>contains</option>
					</select>

					<input class="form-control" type="text" id="queryvalue" name="queryvalue[]" placeholder="By value" tabindex='5'/>
					<input class="btn btn-primary btn-outline" type="button" id="cqaddbtn" name="addquery" value="+"/>
				</div>
			</div>
			<div class="row">
				<input class="btn btn-primary" type="submit" name="submitquery" value="Search" tabindex='7'/>
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
				if($selectedOption=="RecordNumber") $printvalue = "ID";
				else $printvalue = $selectedOption;
				$thString.="<th><a href='search.php?sort=".$selectedOption."'>".$printvalue."</a></th>";
			}

			foreach ($_GET['select2'] as $selectedOption)
			{
				if($selectedOption=="RecordNumber" || $selectedOption=="DateAndTime" )
					$tdEditString.="<td><input type='hidden' name='".$selectedOption."' value='$".$selectedOption."'>$".$selectedOption."</td>";
				else if($selectedOption=="Status"){
					if($Status=='') $selected='';
					else if($Status=="Open") $selectedOpen='selected';
					else if($Status=="Closed") $selectedClosed='selected';
					else if($Status=="Critical") $selectedCritical='selected';
					else if($Status=="Kittens") $selectedKittens='selected';
			
					$tdEditString.="<td><div style='text-align:Center'>
						<form id='form1' name='form1' method='get' action='search.php'>
						<select name='Status'>
							<option value=''>Empty</option>
							<option value='Open'".$selectedOpen.">Open</option>
							<option value='Closed'".$selectedClosed.">Closed</option>
							<option value='Critical'".$selectedCritical.">Critical</option>
							<option value='Kittens'".$selectedKittens.">Kittens!</option>
						</select><br>
						</form></div></td>";
				}
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
				$value = $_GET['queryvalue'][0];
				if($value!=NULL) {
					$search = "select * from ReportColonyForm where ";
					$andor="";
					$i=0;
					foreach($_GET['queryvalue'] as $value){
						if($value!=NULL){
							$column = $_GET['query'][$i];
							$condition = $_GET['condition'][$i];
							if($condition=='contains'){
								$condition=" like ";
								$value="%".$value."%";
							}
							
							$search = $search." ".$andor." (".$column." ".$condition." '".$value."')";
							//$search = "select * from ReportColonyForm where ".$column[0].$condition[0]."'".$value."'";
						}
						$andor = $_GET['andor'][$i];
						$i++;
					}
					$r = mysqli_query($link, $search);
					if(mysqli_num_rows($r)==0)
						echo "<div id='emptyquerymsg'><h3> EMPTY QUERY </h3></div>";
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
						$Outcome, $CompletionDate, $FeedIfReturned, $ReqAssitance, $Lat, $Lng) = $row;

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
					if(isset($_SESSION['querysearch'])) $q="QUERY: ";
					// first print row of links/headers that sort
					print "
					<span id='querymsg'><h5>".$q.$_SESSION['querysearch']."</h5></span>
					<div class='row'>
					<div class='col-sm-12'>
					<form method='post' action='search.php'>

					<b>Report A Feral Cat Colony</b><br><br>

					<table id='reportTable' class='table table-striped table-bordered table-condensed'>
						<thead>
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
								<th><a>ID</a></th>
								<th><a>Comments1</a></th>
								<th><a>Responder</a></th>
								<th><a>Status</a></th>
								<th><a>Date_And_Time</a></th>
								<th><a>Feed_If_Returned</a></th>
								<th><a>Full_Name</a></th>
								<th><a>Email</a></th>
								<th><a>Phone_1</a></th>
								<th><a>Phone_2</a></th>
								<th><a>ColonyAddress</a></th>
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
								<th><a>Additional_Comments</a></th>
								<th><a>Require_Assistance</a></th>
								<th><a>Volunteer_Responding</a></th>
								<th><a>Response_Date</a></th>
								<th><a>Customer_Needed_Outcome</a></th>
								<th><a>Beat_Team_Leader</a></th>
								<th><a>Outcome</a></th>
								<th><a>Completion_Date</a></th>
								<th><a>Latitude</a></th>
								<th><a>Longitude</a></th>
							</tr>
						</thead>
						";
							}

						print "<tbody>";

						//while the next row (set by query) exists?



						while($row = mysqli_fetch_row($result))
						{
							list($Comments1, $Responder, $Status, $RecordNumber, $DateAndTime, $FullName, $Email, $Phone1, $Phone2, $ColonyAddress,
							$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $Kittens, $ColonyCareGiver, $FeederDescription,
							$Injured, $InjuryDescription, $FriendlyPet, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader,
							$Outcome, $CompletionDate, $FeedIfReturned, $ReqAssitance, $Lat, $Lng) = $row; // variables are set to current row
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
										else if($selectedOption=="Status"){
											if($Status=='') $selected='';
											else if($Status=="Open") $selectedOpen='selected';
											else if($Status=="Closed") $selectedClosed='selected';
											else if($Status=="Critical") $selectedCritical='selected';
											else if($Status=="Kittens") $selectedKittens='selected';
									
											$tdEditString.="<td><div style='text-align:Center'>
												<form id='form1' name='form1' method='get' action='search.php'>
												<select name='Status'>
													<option value=''>Empty</option>
													<option value='Open'".$selectedOpen.">Open</option>
													<option value='Closed'".$selectedClosed.">Closed</option>
													<option value='Critical'".$selectedCritical.">Critical</option>
													<option value='Kittens'".$selectedKittens.">Kittens!</option>
												</select><br>
												</form></div></td>";
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
									if($Status=='') $selected='';
									else if($Status=="Open") $selectedOpen='selected';
									else if($Status=="Closed") $selectedClosed='selected';
									else if($Status=="Critical") $selectedCritical='selected';
									else if($Status=="Kittens") $selectedKittens='selected';
									
									print "
									<td><input type='hidden' name='RecordNumber' value='$RecordNumber'>$RecordNumber</td>
									<td><input type='text' name='Comments1' value='$Comments1'></td>
									<td><input type='text' name='Responder' value='$Responder'></td>
									<td>"//<div style='text-align:Center;'>Current Status: ' $Status '
									."<div style='text-align:Center'>" //<div class='dropdown'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Change Report Status<span class='caret'></span></button>
										//<ul class='dropdown-menu dropdown-menu-center'>
											//<li><div style='text-align:Center'>Changes Applied when Submit Edit is clicked</li>
											/*<li><div style='text-align:Center'>*/."<form id='form1' name='form1' method='get' action='search.php' width: 400px>
												<select name='Status'>
													<option value=''>Empty</option>
													<option value='Open'".$selectedOpen.">Open</option>
													<option value='Closed'".$selectedClosed.">Closed</option>
													<option value='Critical'".$selectedCritical.">Critical</option>
													<option value='Kittens'".$selectedKittens.">Kittens!</option>
												</select><br>
									</form>"./*</li></ul></div></div>*/"</div></td>
									<td><input type='hidden' name='DateAndTime' value='$DateAndTimes'>$DateAndTime</td>
									<td><input type='text' name='FeedIfReturned' value='$FeedIfReturned'></td>
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
									<td><input type='text' name='ReqAssitance' value='$ReqAssitance'></td>
									<td><input type='text' name='VolunteerResponding' value='$VolunteerResponding'></td>
									<td><input type='text' name='ResponseDate' value='$ResponseDate'></td>
									<td><input type='text' name='CustNeedOutcome' value='$CustNeedOutcome'></td>
									<td><input type='text' name='BeatTeamLeader' value='$BeatTeamLeader'></td>
									<td><input type='text' name='Outcome' value='$Outcome'></td>
									<td><input type='text' name='CompletionDate' value='$CompletionDate'></td>
									<td><input type='text' name='Lat' value='$Lat'></td>
									<td><input type='text' name='Lng' value='$Lng'></td>
								</tr>
								";
								}
							}
							else
							{
								print "
								<tr>
									<td><a style='background-color:lightgreen;' href='search.php?editrow=yes&RecordNumber=$RecordNumber'>Edit</a> <a style='background-color:#ff8080;' href='search.php?del=yes&RecordNumber=$RecordNumber'  class='confirmation'>Delete</a> <a style = 'background-color:#00ffff;' href='form_view.php?&RecordNumber=$RecordNumber' target = '_blank'>Form_View</a> </td>
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
									<td>$RecordNumber</td>
									<td>$Comments1</td>
									<td>$Responder</td>
									<td id='statusCol'>$Status</td>
									<td id='dateTimeCol'>$DateAndTime</td>
									<td>$FeedIfReturned</td>
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
									<td>$ReqAssitance</td>
									<td>$VolunteerResponding</td>
									<td>$ResponseDate</td>
									<td>$CustNeedOutcome</td>
									<td>$BeatTeamLeader</td>
									<td>$Outcome</td>
									<td>$CompletionDate</td>
									<td id='latCol'>$Lat</td>
									<td id='lngCol'>$Lng</td>
								</tr>
								";
								}
							}
						}
						print "
						</tbody>
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
				$ReqAssitance = $_POST['ReqAssitance'];
				$VolunteerResponding = $_POST['VolunteerResponding'];
				$ResponseDate = $_POST['ResponseDate'];
				$CustNeedOutcome = $_POST['CustNeedOutcome'];
				$BeatTeamLeader = $_POST['BeatTeamLeader'];
				$Outcome = $_POST['Outcome'];
				$CompletionDate = $_POST['CompletionDate'];
				$Lat = $_POST['Lat'];
				$Lng = $_POST['Lng'];

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
								 BeatTeamLeader='$BeatTeamLeader', Outcome='$Outcome', CompletionDate='$CompletionDate', FeedIfReturned='$FeedIfReturned', ReqAssitance='$ReqAssitance', 
								 Lat='$Lat', Lng='$Lng', where RecordNumber='$RecordNumber1'";

							//echo $queryupdate;
							mysqli_query($link, $queryupdate);
							print "<span id='recupdate'><h2>Record was updated</h2></span>";
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
			$_SESSION['totalrecords']=mysqli_num_rows($result);
			
			if(!isset($_GET['editrow']))
			{
			//if edit is not set

			// print table (happens first before input)

				if(isset($_SESSION['querysearch'])) $q="QUERY: ";
				// first print row of links/headers that sort
				print "
				<span id='querymsg'><h5>".$q.$_SESSION['querysearch']."</h5></span>
				<div class='row'>
				<div class='col-sm-12'>
				<b>Report A Feral Cat Colony</b><br><br>
				
				<table id='reportTable' class='table table-striped table-bordered table-condensed'>
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

							<th><a href='search.php?sort=RecordNumber'>ID</a></th>
							<th><a href='search.php?sort=Comments1'>Comments</a></th>
							<th><a href='search.php?sort=Responder'>Responder</a></th>
							<th><a href='search.php?sort=Status'>Status</a></th>
							<th><a href='search.php?sort=DateAndTime'>Date_And_Time</a></th>
							<th><a href='search.php?sort=FeedIfReturned'>Feed_If_Returned</a></th>
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
							<th><a href='search.php?sort=Comments'>Additional_Comments</a></th>
							<th><a href='search.php?sort=ReqAssitance'>Require_Assistance</a></th>
							<th><a href='search.php?sort=VolunteerResponding'>Volunteer_Responding</a></th>
							<th><a href='search.php?sort=ResponseDate'>Response_Date</a></th>
							<th><a href='search.php?sort=CustNeedOutcome'>Customer_Needed_Outcome</a></th>
							<th><a href='search.php?sort=BeatTeamLeader'>Beat_Team_Leader</a></th>
							<th><a href='search.php?sort=Outcome'>Outcome</a></th>
							<th><a href='search.php?sort=CompletionDate'>Completion_Date</a></th>
							<th><a href='search.php?sort=Lat'>Latitude</a></th>
							<th><a href='search.php?sort=Lng'>Longitude</a></th>

						</tr>";
								}
					print"
					</thead>

					<tbody>";

					//while the next row (set by query) exists?

					while($row = mysqli_fetch_row($result))
					{
						list($Comments1, $Responder, $Status, $RecordNumber, $DateAndTime, $FullName, $Email, $Phone1, $Phone2, $ColonyAddress,
						$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $Kittens, $ColonyCareGiver, $FeederDescription,
						$Injured, $InjuryDescription, $FriendlyPet, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader,
						$Outcome, $CompletionDate, $FeedIfReturned, $ReqAssitance, $Lat, $Lng) = $row; // variables are set to current row
																		// then printed in one table row

						$myArray[0]=$RecordNumber;
						$myArray[1]=$Comments1;
						$myArray[2]=$Responder;
						$myArray[3]=$Status;
						$myArray[4]=$DateAndTime;
						$myArray[5]=$FeedIfReturned;
						$myArray[6]=$FullName;
						$myArray[7]=$Email;
						$myArray[8]=$Phone1;
						$myArray[9]=$Phone2;
						$myArray[10]=$ColonyAddress;
						$myArray[11]=$City;
						$myArray[12]=$County;
						$myArray[13]=$ZipCode;
						$myArray[14]=$AnyoneAttempted;
						$myArray[15]=$ApproximateCats;
						$myArray[16]=$Kittens;
						$myArray[17]=$ColonyCareGiver;
						$myArray[18]=$FeederDescription;
						$myArray[19]=$Injured;
						$myArray[20]=$InjuryDescription;
						$myArray[21]=$FriendlyPet;
						$myArray[22]=$ColonySetting;
						$myArray[23]=$Comments;
						$myArray[24]=$ReqAssitance;
						$myArray[25]=$VolunteerResponding;
						$myArray[26]=$ResponseDate;
						$myArray[27]=$CustNeedOutcome;
						$myArray[28]=$BeatTeamLeader;
						$myArray[29]=$Outcome;
						$myArray[30]=$CompletionDate;
						$myArray[31]="Lat";
						$myArray[32]="Lng";

						$myArray1[0]="RecordNumber";
						$myArray1[1]="Comments1";
						$myArray1[2]="Responder";
						$myArray1[3]="Status";
						$myArray1[4]="DateAndTime";
						$myArray1[5]="FeedIfReturned";
						$myArray1[6]="FullName";
						$myArray1[7]="Email";
						$myArray1[8]="Phone1";
						$myArray1[9]="Phone2";
						$myArray1[10]="ColonyAddress";
						$myArray1[11]="City";
						$myArray1[12]="County";
						$myArray1[13]="ZipCode";
						$myArray1[14]="AnyoneAttempted";
						$myArray1[15]="ApproximateCats";
						$myArray1[16]="Kittens";
						$myArray1[17]="ColonyCareGiver";
						$myArray1[18]="FeederDescription";
						$myArray1[19]="Injured";
						$myArray1[20]="InjuryDescription";
						$myArray1[21]="FriendlyPet";
						$myArray1[22]="ColonySetting";
						$myArray1[23]="Comments";
						$myArray1[24]="ReqAssitance";
						$myArray1[25]="VolunteerResponding";
						$myArray1[26]="ResponseDate";
						$myArray1[27]="CustNeedOutcome";
						$myArray1[28]="BeatTeamLeader";
						$myArray1[29]="Outcome";
						$myArray1[30]="CompletionDate";
						$myArray1[31]="Lat";
						$myArray1[32]="Lng";
						
						print "
						<tr>
							<td><a style='background-color:lightgreen;' href='search.php?editrow=yes&RecordNumber=$RecordNumber'>Edit</a> <a style='background-color:#ff8080;' href='search.php?del=yes&RecordNumber=$RecordNumber'  class='confirmation'>Delete</a> <a style = 'background-color:#00ffff;' href='form_view.php?&RecordNumber=$RecordNumber' target = '_blank'>Form_View </a> </td>
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
											case 'Lat': $tdString.="<td = id='latCol'>".$$selectedOption."</td>"; break;
											case 'Lng': $tdString.="<td = id='lngCol'>".$$selectedOption."</td>"; break;											
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

							<td>$RecordNumber </td>
							<td>$Comments1 </td>
							<td>$Responder </td>
							<td id='statusCol'>$Status </td>
							<td id='dateTimeCol'>$DateAndTime</td>
							<td>$FeedIfReturned</td>
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
							<td>$ReqAssitance</td>
							<td>$VolunteerResponding</td>
							<td>$ResponseDate</td>
							<td>$CustNeedOutcome</td>
							<td>$BeatTeamLeader</td>
							<td>$Outcome</td>
							<td>$CompletionDate</td>
							<td id='latCol'>$Lat</td>
							<td id='lngCol'>$Lng</td>
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

   		<form id="resettable" method='get' action='search.php'>
			<input class="btn" type="submit" value="Refresh" name="RefreshTable"/>
   			<input class="btn btn-success" type="button" id="exportButton" onclick="tableToExcel('reportTable', 'Reports')" value="Export" />
			<span id="ttlrecs">Total Records: <?php echo $_SESSION['totalrecords']; ?></span>
		</form>
		</div> <!-- end div class='col-sm'12' -->
		</div> <!-- end div class='row' -->
		<hr>
   		<div class="row">
			<div class="col-sm-12">
				<b>Clustered Hot Spot</b><br><br>
				<button class="btn btn-primary" id='clusterAddrBtn' type='button' onclick='setTimeout(errorCheck, 500);'>Map Query</button>
				<button class="btn" id='clusterAddrClearBtn' type='button' onclick='clearMap()'>Clear Map</button>
				<br><br>
				<div class="alert" id='alert' style='display:none'>
					<span class="closebtn" onclick="this.parentElement.style.display='none'">&times;</span>
					<label id='errorMsg'></label>
				</div>
				<div onload="initMap()" id="map"><div id="map-canvas"></div></div>
			</div>
		</div>
		
		<script src="plotMapScript.js?version=1.5"></script>
		<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDz2ZSC6IJEf38QeSbLwIxTEohm4ATem9M&callback=initMap"></script>
	</body>
</html>

