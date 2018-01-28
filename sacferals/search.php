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

		//prevent page from appending same query to current query
		/*$curr_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if(strpos($curr_url,"?query")>0){
			$cleared_url = strtok($curr_url, "?"); //remove get variables
			header("Location: ".$cleared_url);
		}*/

		if($level == 1 || $level == 2)
		{
?>

<!DOCTYPE html>
<html lang="en">
   	<head>
		<title>Record Search</title>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="css/search.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>	
       	
		<script src="js/exportExcelScript.js?version=1.5"></script>
		<script src="js/customquery.js"></script> 
		<script src="js/searchScript.js"></script> 
  	</head>
	<body>
	<div class="header"> <!-- navbar -->
		<nav class="navbar navbar-inverse navbar-default navbar-static-top" role="navbar">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand">Logged in as <?php echo $Ausername ?></a>
				</div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">View Records</a></li>
					<li><a href="<?php if($level==1) echo 'adminprofile.php'; else echo 'volunteerlist.php'; ?>">View Volunteers</a></li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown">Forms
							<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="./reportform.php" target="_blank">Report a Colony Form</a></li>
							<li><a href="./volunteerform.php" target="_blank">Volunteer Form</a></li>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown">Useful Links
							<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="https://www.catstats.org/Sacramento" target="_blank">CatStats</a></li>
							<li><a href="https://www.gmail.com" target="_blank">Gmail</a></li>
							<li><a href="https://www.latlong.net/" target="_blank">LatLong</a></li>
							<li><a href="http://assessorparcelviewer.saccounty.net/JSViewer/assessor.html" target="_blank">Assessor Parcel Viewer</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<span class="glyphicon glyphicon-menu-hamburger"></span>
							<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href='./updateprofile.php'>Update Profile</a></li>
						<li><a href='./logout.php'>Sign Out</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div> 
	
	<div class="maindiv"> <!-- rest of page -->
	<div class="row">
		<div class="col-md-4"> <!-- Column Selector -->
			<form id='form1' name='form1' method='get' action='search.php'>
				<div>
					<p id="columnselect"><small>Note: Hold down ctrl or shift to select multiple columns to display in table.<br> Click 'Reset' to get full table.</small></p>
					<label><b>Column Selector</b></label>
				</div>
				<select class="input-sm" id="colsel" name='select2[]' size='8' multiple='multiple' tabindex='1'>
					<option value='RecordNumber'>ID</option>
					<option value='DateAndTime'>Date And Time</option>
					<option value='Responder'>Responder</option>
					<option value='Comments1'>Comments</option>
					<option value='Status'>Status</option>
					<option value='FullName'>Full Name</option>
					<option value='Email'>Email</option>
					<option value='Phone1'>Phone1</option>
					<option value='Phone2'>Phone2</option>
					<option value='ColonyAddress'>Address</option>
					<option value='City'>City</option>
					<option value='County'>County</option>
					<option value='ZipCode'>ZipCode</option>
					<option value='AnyoneAttempted'>Trap/Tip</option>
					<option value='FeedIfReturned'>Feed If Returned</option>
					<option value='ApproximateCats'>Approximate Cats</option>
					<option value='Kittens'>Kittens</option>
					<option value='ColonyCareGiver'>Colony Caregiver</option>
					<option value='FeederDescription'>Feeder Description</option>
					<option value='Injured'>Injured/Pregnant</option>
					<option value='InjuryDescription'>Injury Description</option>
					<option value='FriendlyPet'>Friendly/Pet</option>
					<option value='ColonySetting'>Colony Setting</option>
					<option value='Comments'>Additional Comments</option>			
					<option value='Lat'>Latitude</option>
					<option value='Lng'>Longitude</option>
				</select>
				<br>
				<input class="btn btn-primary" type='submit' name='Submit' value='Submit' tabindex='2' />
				<input class="btn btn-default" type='submit' name='SelectAll' value='Reset'/>
			</form>
		</div>
		<div class="col-md-8"> <!-- Manual Query -->
			<form id='writtenqueryform' name='writtenquery' method='get' action='search.php'>
				<label><b>Manual Query</b></label>
				&nbsp;&nbsp;&nbsp;
				<span style="color: darkgray;"><small>(Do not include semicolon)</small></span>
				<div class="row">
					<textarea class="form-control" id="manquery" name="manquery" rows="6" placeholder="Enter your Query" required ></textarea>
					<br>
					<input class="btn btn-primary" type="submit" name="runwrittenqry" id="runwrittenqry" value="Run" tabindex='7'/>
					<input class='btn btn-success' type='submit' id="savewrittenqry" name='savewrittenqry' value="Save"/>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4"> <!-- Canned Query -->
			<form id="cannedqueryform" method='get' action='search.php'>
				<label><b>Canned Queries</b></label>
				<div class="row" id="cannedqrow">
					<select class="input-sm col-md-6 col-sm-4 col-xs-8" id="cannedquery" name="cannedquery[]" tabindex='3'>
<?php
						$cannedq = "select * from CannedQueries";
						$cannedr = mysqli_query($link, $cannedq);
						if($cannedr==null) print "<option value=''>No Canned Queries Available</option>";
						else {
							while($cannedrow = mysqli_fetch_row($cannedr)){
								print "<option value='".$cannedrow[1]."'>".$cannedrow[1]."</option>";
							}
						}
						
?>
					</select>
				</div>
				<div class="row">
					<input class="btn btn-primary" type="submit" name="submitcannedquery" value="Search" tabindex='7'/>
					<input class='btn btn-success' type='submit' id="savecurrentquery" name='savecurrentquery' value="Save Current" />
					&nbsp;&nbsp;&nbsp;<input class='btn btn-danger' type='submit' name='deletecannedquery' value='Delete'/>
				</div> <!-- data-toggle="modal" data-target="#addnewqueryModal" -->
			</form>
		</div>
		<div class="col-md-8"> <!-- Custom Query -->
			<form id="queryform" method='get' action='search.php'>
				<label><b>Custom Query</b>
					<div id="tooltip"><img src="images/info.png" alt="i"/>
						<span class="tooltiptext">
							<b>Run</b> - run a new query<br>
							<b>Append</b> - add onto current query<br>
							<b>Reset</b> - run initial query (open reports)
						</span>
					</div>
				</label>
				&nbsp;&nbsp;&nbsp;
				<span style="color: darkgray;"><small>(Enter null for empty value. Exclude quotes for integers.)</small></span>
				<div class="row" id="cqrow">
					<div id="blueprint">
						<select class="input-sm" id="query" name="query[]" tabindex='3'>
							<option value='RecordNumber'>ID</option>
							<option value='DateAndTime'>Date And Time</option>
							<option value='Responder'>Responder</option>
							<option value='Comments1'>Comments</option>
							<option value='Status'>Status</option>
							<option value='FullName'>Full Name</option>
							<option value='Email'>Email</option>
							<option value='Phone1'>Phone1</option>
							<option value='Phone2'>Phone2</option>
							<option value='ColonyAddress'>Address</option>
							<option value='City'>City</option>
							<option value='County'>County</option>
							<option value='ZipCode'>ZipCode</option>
							<option value='AnyoneAttempted'>Trap/Tip</option>
							<option value='FeedIfReturned'>Feed If Returned</option>
							<option value='ApproximateCats'>Approximate Cats</option>
							<option value='Kittens'>Kittens</option>
							<option value='ColonyCareGiver'>Colony Caregiver</option>
							<option value='FeederDescription'>Feeder Description</option>
							<option value='Injured'>Injured/Pregnant</option>
							<option value='InjuryDescription'>Injury Description</option>
							<option value='FriendlyPet'>Friendly/Pet</option>
							<option value='ColonySetting'>Colony Setting</option>
							<option value='Comments'>Additional Comments</option>
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
							<option value='!contains'>not contain</option>
						</select>

						<input class="form-control" type="text" id="queryvalue" name="queryvalue[]" placeholder="By value" title="Enter null or '' for empty value" required tabindex='5'/>
						<input class="btn btn-primary btn-outline" type="button" id="cqaddbtn" name="addquery" value="+"/>
					</div>
				</div>
				<div class="row">
					<input class="btn btn-primary" type="submit" name="runquery" value="Run" tabindex='7'/>
					<input class="btn btn-primary" type="submit" name="submitquery" value="Append" tabindex='8'/>
					<!--&nbsp;&nbsp;&nbsp;
					<span id="columnselect"><small>Note: Press "Reset" to clear the query</small></span>-->
				</div>
			</form>
		</div>
	</div>
	
	<!-- modal for saving canned query name -->
	<div class="modal fade" id="getcndqnameModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="addcurrqry" method='get' action='search.php'>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="motal-title" id="myModalLabel">Name your Canned Query</h4>
					</div>
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-sm-4 col-for-label" for="queryname" style="text-align: center">Query Name:</label>
							<div class="col-sm-6"><input class="form-control" id="queryname" name="queryname" type="text" maxlength="45" title="Cannot be empty" required /></div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-primary" name="addcurrentquery" value="Save"/>
					</div>
				</form> 
			</div>
		</div>
	</div>	
	<!-- modal for saving canned query name -->
	<div class="modal fade" id="getcndqnameModal2" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="addcurrqry2" method='get' action='search.php'>
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="motal-title" id="myModalLabel2">Name your Canned Query</h4>
					</div>
					<div class="modal-body">
						<div class="form-group row">
							<label class="col-sm-4 col-for-label" for="queryname2" style="text-align: center">Query Name:</label>
							<div class="col-sm-6"><input class="form-control" id="queryname2" name="queryname2" type="text" maxlength="45" title="Cannot be empty" required /></div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-primary" name="addcurrentquery2" value="Save"/>
					</div>
				</form> 
			</div>
		</div>
	</div>
	
<?php		

			if(isset($_GET['SelectAll'])) //reset all columns then set the variables
			{
				unset($_SESSION['selectedColumns']);
			}

			$thString="";
			$tdString="";
			$thEditString="";
			$tdEditString="";
			
			//change selected columns only if unset
			//if(!isset($_SESSION['selectedColumns'])){ 

			/*if(count($_SESSION['selectedColumns']) > 0 && ( count($_GET['editrow']) != 0 || count($_POST['recordEdit']) != 0 ))
			{
				$_GET['select2'] = $_SESSION['selectedColumns'];
			}*/

			if(isset($_GET['Submit']))//count($_GET['select2']) >= 0)
			{
				$_SESSION['selectedColumns'] = $_GET['select2'];
			}

			if(isset($_SESSION['selectedColumns'])){
				foreach ($_SESSION['selectedColumns'] as $selectedOption)
				{
					$thEditString.="<th><a>".$selectedOption."</a></th>";
					$tdString.="<td>$".$selectedOption."</td>";
					
					if($selectedOption=="RecordNumber") $printvalue = "ID";
					else if($selectedOption=="Comments1") $printvalue = "Comments";
					else if($selectedOption=="DateAndTime") $printvalue = "Date/Time";
					else if($selectedOption=="FeedIfReturned") $printvalue = "Feed";
					else if($selectedOption=="ColonyAddress") $printvalue = "Address";
					else if($selectedOption=="ZipCode") $printvalue = "Zip";
					else if($selectedOption=="AnyoneAttempted") $printvalue = "Trap/ Tip";
					else if($selectedOption=="ApproximateCats") $printvalue = "#Cats";
					else if($selectedOption=="ColonyCareGiver") $printvalue = "Caregiver";
					else if($selectedOption=="FeederDescription" || $selectedOption=="InjuryDescription") $printvalue = "Description";
					else if($selectedOption=="Injured") $printvalue = "Sick";
					else if($selectedOption=="FriendlyPet") $printvalue = "Friendly";
					else if($selectedOption=="ColonySetting") $printvalue = "Setting";
					else if($selectedOption=="VolunteerResponding") $printvalue = "Responder";
					else if($selectedOption=="ResponseDate") $printvalue = "Date";
					else if($selectedOption=="CustNeedOutcome") $printvalue = "Needs";
					else $printvalue = $selectedOption;
					$thString.="<th><a href='search.php?sort=".$selectedOption."'>".$printvalue."</a></th>";
					
					if($selectedOption=="RecordNumber" || $selectedOption=="DateAndTime" )
						$tdEditString.="<td><input type='hidden' name='".$selectedOption."' value='$".$selectedOption."'>$".$selectedOption."</td>";
					else if($selectedOption=="Status"){
						if($Status=='') $selected='';
						else if($Status=="Open") $selectedOpen='selected';
						else if($Status=="Assigned") $selectedAssigned='selected';
						else if($Status=="Closed") $selectedClosed='selected';
						else if($Status=="Critical") $selectedCritical='selected';
						else if($Status=="Kittens") $selectedKittens='selected';
				
						$tdEditString.="<td><div style='text-align:Center'>
							<form id='form1' name='form1' method='get' action='search.php'>
							<select class='input-sm' name='Status'> 
								<option value='Open'".$selectedOpen.">Open</option>
								<option value='Contacted'".$selectedContacted.">Contacted</option>
								<option value='In-Progress'".$selectedInProgress.">In-Progress</option>
								<option value='Priority'".$selectedPriority.">Priority</option>
								<option value='Closed'".$selectedClosed.">Closed</option>
							</select><br>
							</form></div></td>";
					}
					else
						$tdEditString.="<td><input type='text' name='".$selectedOption."' value='".$selectedOption."'>$".$selectedOption."</td>";
				}
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

			//custom query builder search - overwrite current
			if(isset($_GET['runquery'])){
				$value = $_GET['queryvalue'][0];
				if($value!=NULL) {
					$search = "select * from ReportColonyForm where (";
					$andor="";
					$i=0;
					foreach($_GET['queryvalue'] as $value){
						if($value!=NULL){
							$column = $_GET['query'][$i];
							$condition = $_GET['condition'][$i];
							if($condition=='contains'){
								$condition="like";
								$value="'%".str_replace("'","",str_replace('"',"",$value))."%'";
							}
							else if($condition=='!contains'){
								$condition="not like";
								$value="'%".str_replace("'","",str_replace('"',"",$value))."%'";
							} 
							if(strcasecmp($value,'null')==0 || $value=="''" || $value=='""'){
								if($condition=="=")
									$condition="is null or ".$column." = ''";
								else if($condition=="!=")
									$condition="is not null and ".$column." <> ''";
								$value="";
							}
							//else $value="'".$value."'";
							
							if($andor != "") $andor=" ".$andor." "; //dont include extra spaces
							$search = $search.$andor.$column." ".$condition." ".$value;		
						}
						$andor = $_GET['andor'][$i];
						$i++;
					}
					$search = $search.")";
					$r = mysqli_query($link, $search);
					if(mysqli_num_rows($r)==0)
						echo "<div id='emptyquerymsg'><h3> Error </h3> Query: ".$search."</div>";
					else $_SESSION['querysearch'] = $search;
				}
			}
			//custom query builder search - append
			if(isset($_GET['submitquery'])){
				//unset($_SESSION['querysearch']); //refresh variable
				//mysql: contains == like -> column like '%value%'
				$value = $_GET['queryvalue'][0];
				if($value!=NULL) {
					if(!(isset($_SESSION['querysearch']))) $search = "select * from ReportColonyForm where (";
					else $search = $_SESSION['querysearch']." AND (";
					$andor="";
					$i=0;
					foreach($_GET['queryvalue'] as $value){
						if($value!=NULL){
							$column = $_GET['query'][$i];
							$condition = $_GET['condition'][$i];
							if($condition=='contains'){
								$condition="like";
								$value="'%".str_replace("'","",str_replace('"',"",$value))."%'";
							}
							else if($condition=='!contains'){
								$condition="not like";
								$value="'%".str_replace("'","",str_replace('"',"",$value))."%'";
							} 
							if(strcasecmp($value,'null')==0 || $value=="''" || $value=='""'){
								if($condition=="=")
									$condition="is null or ".$column." = ''";
								else if($condition=="!=")
									$condition="is not null and ".$column." <> ''";
								$value="";
							}
							//else $value="'".$value."'";
							
							if($andor != "") $andor=" ".$andor." ";
							$search = $search.$andor.$column." ".$condition." ".$value;	
						}
						$andor = $_GET['andor'][$i];
						$i++;
					}
					$search = $search.")";
					$r = mysqli_query($link, $search);
					if(mysqli_num_rows($r)==0)
						echo "<div id='emptyquerymsg'><h3> Error </h3> Query: ".$search."</div>";
					else $_SESSION['querysearch'] = $search;
				}
			}
			//canned query search
			if(isset($_GET['submitcannedquery'])){
				//unset($_SESSION['querysearch']); //refresh variable
				$cannedqueryname = $_GET['cannedquery'][0];
				
				$sea = "select * from CannedQueries where QueryName='".$cannedqueryname."'";
				$res = mysqli_query($link, $sea);
				if(mysqli_num_rows($res)==0)
					echo "<div id='emptyquerymsg'><h3> Error </h3> Query: ".$sea."</div>";
				else {
					$rw = mysqli_fetch_row($res);
					$haha = mysqli_query($link, $rw[2]); //check if legal query
					if(mysqli_num_rows($haha)!=0)
						$_SESSION['querysearch'] = $rw[2];
					else echo "<div id='emptyquerymsg'><h3> Error </h3> Query: ".$rw[2]."</div>";
				}
			}
			//canned query check for existance & then display modal
			if(isset($_GET['savecurrentquery'])){
				if(isset($_SESSION['querysearch'])){
					$sea = 'select * from CannedQueries where QueryString="'.$_SESSION['querysearch'].'"';
					$res = mysqli_query($link, $sea);
					if(mysqli_num_rows($res)==0){
						echo "<script type='text/javascript'>
								$(document).ready(function(){
									$('#getcndqnameModal').modal('show');
								});
							</script>";
					} else {
						$rw = mysqli_fetch_row($res);
						echo "<div id='emptyquerymsg'><h3>This Canned Query already exists under the name \"".$rw[1]."\"</h3></div>";
					}
				} else {
					echo "<div id='emptyquerymsg'><h3>No Query to save</h3></div>";
				}
			}
			//canned query save
			if(isset($_GET['addcurrentquery'])){
				$qryname = $_GET['queryname'];

				//still check if exists so doesn't keep adding to db
				$sea = 'select * from CannedQueries where QueryString="'.$_SESSION['querysearch'].'"';
				$res = mysqli_query($link, $sea);
				if(mysqli_num_rows($res)==0){
					$savecannedqry = "insert into CannedQueries values(NULL, '".$qryname."', ".'"'.$_SESSION['querysearch'].'"'.")";
					mysqli_query($link, $savecannedqry);
				}
			}
			//canned query delete
			if(isset($_GET['deletecannedquery'])){
				$cannedqueryname = $_GET['cannedquery'][0];
				
				$sea = "delete from CannedQueries where QueryName='".$cannedqueryname."'";
				$res = mysqli_query($link, $sea);
				if(mysqli_num_rows($res)==0){
					print "<span id='recupdate'><h2>Query \"".$cannedqueryname."\" was removed</h2></span>";
				} else print "error";
			}
			//manual query run
			if(isset($_GET['runwrittenqry'])){
				//unset($_SESSION['querysearch']); //refresh variable
				$wrttnqry = $_GET['manquery'];
				$cols = explode(" ",$wrttnqry);
				$wrttnqryres = mysqli_query($link, $wrttnqry);
				if(mysqli_num_rows($wrttnqryres)==0 || ((strcasecmp($cols[0],'select'))!=0 && $cols[3]!='ReportColonyForm'))
					echo "<div id='emptyquerymsg'><h3> Error </h3> Query: ".$wrttnqry."</div>";
				else $_SESSION['querysearch'] = $wrttnqry;
			}
			//manual query check for existance & then display modal to get name
			if(isset($_GET['savewrittenqry'])){
				$qryname = str_replace("'", "\'", $_GET['queryname2']);
				$newq = str_replace("'", "\'", $_GET['manquery']);
				
				//dont do anything if empty
				if($newq != ''){
					$wrttnqry = "select * from CannedQueries where QueryString='".$newq."'";
					$wrttnqryres = mysqli_query($link, $wrttnqry);
					if(mysqli_num_rows($wrttnqryres)==0){
						$_SESSION['querytosave'] = $newq;
						echo "<script type='text/javascript'>
								$(document).ready(function(){
									$('#getcndqnameModal2').modal('show');
								});
							</script>";
					} else {
						$rw = mysqli_fetch_row($wrttnqryres);
						echo "<div id='emptyquerymsg'><h3>This Canned Query already exists under the name ".'"'.$rw[1].'"'."</h3></div>";
					}
				} else {
					echo "<div id='emptyquerymsg'><h3>No Query to save</h3></div>";
				}
			}
			//manual query save
			if(isset($_GET['addcurrentquery2'])){
				$qryname = str_replace("'", "\'", $_GET['queryname2']);
				
				$wrttnqry = "select * from CannedQueries where QueryString='".$_SESSION['querytosave']."'";
				$wrttnqryres = mysqli_query($link, $wrttnqry);
				if(mysqli_num_rows($wrttnqryres)==0){
					$savewrttnqry = "insert into CannedQueries values(NULL, '".$qryname."', '".$_SESSION['querytosave']."')";
					mysqli_query($link, $savewrttnqry);
				}
			}
			
			
			if(isset($_GET['RefreshTable'])){ //nullify the query 
				unset($_SESSION['querysearch']);
			}
			
			///////////////////////////////////////////////////////////////////////////////////////////
			//edit detector
			if(isset($_GET['editrow']))
			{
				$RecordNumber1 = $_GET['RecordNumber'];
				$query = "select * from ReportColonyForm  where RecordNumber = ".$RecordNumber1." order by RecordNumber desc";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($Comments1, $Responder, $Status, $RecordNumber, $DateAndTime, $FeedIfReturned, $FullName, $Email, $Phone1, $Phone2, $ColonyAddress,
						$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $Kittens, $ColonyCareGiver, $FeederDescription,
						$Injured, $InjuryDescription, $FriendlyPet, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, $BeatTeamLeader,
						$Outcome, $CompletionDate, $Lat, $Lng) = $row;

					$sort = $_GET['sort']; //'sort' is magic sorting variable
					if(!isset($sort))
					{
						$sort = "RecordNumber";
					}
				if(isset($_SESSION['querysearch'])){
					//query search
					$s = mysqli_query($link, $_SESSION['querysearch']." order by $sort desc");
					if (mysqli_num_rows($s)!=0) $result = $s;
				}
				else{
					//regular search
					$query = "select * from ReportColonyForm where Status='open' order by $sort desc";
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

					<b>Report A Feral Cat Colony</b>
					<div class='row' style='float: right'>
						<div class='col-xs-12 col-sm-12 col-md-12' style='text-align:right; padding-right:5px;'>
							<input class='btn btn-default' type='button' value='Reset' name='RefreshTable' onclick=\"location.href='search.php?RefreshTable=Reset'\"/>
							<input class='btn btn-success' type='button' id='exportButton' onclick=\"tableToExcel('reportTable', 'Reports')\" value='Export' />
						</div>
					</div>
					
					<table id='reportTable' class='table table-striped table-bordered table-condensed'>
						<thead>
							<tr>
								<th> </th>";

							if($thString != '')
							{
								print $thString;
								print"<th> </th></tr></thead>";
								//print"(getEditRow is set header)";
							}
							else
							{
								print "
								<th><a>ID</a></th>
								<th><a>Date/Time</a></th>
								<th><a>Responder</a></th>
								<th><a>Comments</a></th>
								<th><a>Status</a></th>
								<th><a>FullName</a></th>
								<th><a>Email</a></th>
								<th><a>Phone1</a></th>
								<th><a>Phone2</a></th>
								<th><a>Address</a></th>
								<th><a>City</a></th>
								<th><a>County</a></th>
								<th><a>Zip</a></th>
								<th><a>Trap/ Tip</a></th>
								<th><a>Feed</a></th>
								<th><a>#Cats</a></th>
								<th><a>Kittens</a></th>
								<th><a>Caregiver</a></th>
								<th><a>Description</a></th>
								<th><a>Sick</a></th>
								<th><a>Description</a></th>
								<th><a>Friendly</a></th>
								<th><a>Setting</a></th>
								<th><a>Additional Comments</a></th>						
								<th><a>Latitude</a></th>
								<th><a>Longitude</a></th>
							
								<th> </th>
							</tr>
						</thead>
						";
							}

						print "<tbody>";

						//while the next row (set by query) exists?



						while($row = mysqli_fetch_row($result))
						{
							list($Comments1, $Responder, $Status, $RecordNumber, $DateAndTime, $FeedIfReturned, $FullName, $Email, $Phone1, $Phone2, $ColonyAddress,
						$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $Kittens, $ColonyCareGiver, $FeederDescription,
						$Injured, $InjuryDescription, $FriendlyPet, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, 
						$CustNeedOutcome, $BeatTeamLeader, $Outcome, $CompletionDate, $Lat, $Lng) = $row; // variables are set to current row
																			// then printed in one table row

							if($RecordNumber1==$RecordNumber)
							{

								print "
								<tr>
									<td> <label><input type='submit' class='form-control' id='recordEdit' name='recordEdit' value='Submit Edit'></label>
										 <label><input type='submit' class='form-control' name='cancel' value='Cancel Edit' id='cancelEdit'></label> </td>";


								if($tdEditString != '')
								{
									$tdEditString = '';

									/*
									if(in_array($RecordNumber, $_GET['select2']))
									{
										echo "howdy";
										$tdEditString.="<td><input name='RecordNumber' value='".$RecordNumber1."' readonly></td>";
									}*/



									foreach ($_SESSION['selectedColumns'] as $selectedOption)
									{ 
										if($selectedOption=="RecordNumber" || $selectedOption=="DateAndTime" )
										{
											$tdEditString.="<td>".$$selectedOption."</td>";
										}
										else if($selectedOption=="Status"){
											if($Status=='') $selectedOpen='selected';
											else if($Status=="Open") $selectedOpen='selected';
											else if($Status=="Contacted") $selectedContacted='selected';
											else if($Status=="In-Progress") $selectedInProgress='selected';
											else if($Status=="Priority") $selectedPriority='selected';
											else if($Status=="Closed") $selectedClosed='selected';
									
											$tdEditString.="<td><div style='text-align:Center'>
												<form id='form1' name='form1' method='get' action='search.php'>
												<select class='input-sm' name='Status' id='statusselect'> 
													<option value='Open'".$selectedOpen.">Open</option>
													<option value='Contacted'".$selectedContacted.">Contacted</option>
													<option value='In-Progress'".$selectedInProgress.">In-Progress</option>
													<option value='Priority'".$selectedPriority.">Priority</option>
													<option value='Closed'".$selectedClosed.">Closed</option>
												</select><br>
												</form></div></td>";
										}
										else if ($selectedOption=="Comments1" || $selectedOption=="FeederDescription" || $selectedOption=="InjuryDescription" || $selectedOption=="Comments")
											$tdEditString.="<td><textarea class='form-control' name='".$selectedOption."'  rows='4' value='$selectedOption'>".$$selectedOption."</textarea></td>";
										else
										{
											$tdEditString.="<td><input class='form-control' type='text' name='".$selectedOption."' value='".$$selectedOption."'></td>";
										}
										//echo $selectedOption."\n";
									}


									if(!in_array($RecordNumber, $_SESSION['selectedColumns']))
									{

										$tdEditString.="<input type='hidden' name='RecordNumber' value='".$RecordNumber1."' readonly>";
									}

									print $tdEditString;
									print"<td>	<label><input type='submit' class='form-control' id='recordEdit' name='recordEdit' value='Submit Edit'></label>
										 	  	<label><input type='submit' class='form-control' name='cancel' value='Cancel Edit' id='cancelEdit'></label></td>
										</tr>";
									//print"(editable geteditRow is set Body)";
								}
								else
								{
									if($Status=='') $selectedOpen='selected';
									else if($Status=="Open") $selectedOpen='selected';
									else if($Status=="Contacted") $selectedContacted='selected';
									else if($Status=="In-Progress") $selectedInProgress='selected';
									else if($Status=="Priority") $selectedPriority='selected';
									else if($Status=="Closed") $selectedClosed='selected';
									
									print "
									<td><input class='form-control' type='hidden' name='RecordNumber' value='$RecordNumber'>$RecordNumber</td>
									<td><input class='form-control' type='hidden' name='DateAndTime' value='$DateAndTimes'>$DateAndTime</td>
									<td><input class='form-control' type='text' name='Responder' value='$Responder'></td>
									<td><textarea class='form-control' name='Comments1' rows='4' value='$Comments1'>$Comments1</textarea></td>
									<td>"//<div style='text-align:Center;'>Current Status: ' $Status '
									."<div style='text-align:Center'>" //<div class='dropdown'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Change Report Status<span class='caret'></span></button>
										//<ul class='dropdown-menu dropdown-menu-center'>
											//<li><div style='text-align:Center'>Changes Applied when Submit Edit is clicked</li>
											/*<li><div style='text-align:Center'>*/."<form id='form1' name='form1' method='get' action='search.php' width: 400px>
												<select class='input-sm' name='Status' id='statusselect'> 
													<option value='Open'".$selectedOpen.">Open</option>
													<option value='Contacted'".$selectedContacted.">Contacted</option>
													<option value='In-Progress'".$selectedInProgress.">In-Progress</option>
													<option value='Priority'".$selectedPriority.">Priority</option>
													<option value='Closed'".$selectedClosed.">Closed</option>
												</select><br>
									</form>"./*</li></ul></div></div>*/"</div></td>
									<td><input class='form-control' type='text' name='FullName' value='$FullName'></td>
									<td><input class='form-control' type='text' name='Email' value='$Email'></td>
									<td><input class='form-control' type='text' name='Phone1' value='$Phone1'></td>
									<td><input class='form-control' type='text' name='Phone2' value='$Phone2'></td>
									<td><input class='form-control' type='text' name='ColonyAddress' value='$ColonyAddress'></td>
									<td><input class='form-control' type='text' name='City' value='$City'></td>
									<td><input class='form-control' type='text' name='County' value='$County'></td>
									<td><input class='form-control' type='text' name='ZipCode' value='$ZipCode'></td>
									<td><input class='form-control' type='text' name='AnyoneAttempted' value='$AnyoneAttempted'></td>
									<td><input class='form-control' type='text' name='FeedIfReturned' value='$FeedIfReturned'></td>
									<td><input class='form-control' type='text' name='ApproximateCats' value='$ApproximateCats'></td>
									<td><input class='form-control' type='text' name='Kittens' value='$Kittens'></td>
									<td><input class='form-control' type='text' name='ColonyCareGiver' value='$ColonyCareGiver'></td>
									<td><textarea class='form-control' name='FeederDescription'  rows='4' value='$FeederDescription'>$FeederDescription</textarea></td>
									<td><input class='form-control' type='text' name='Injured' value='$Injured'></td>
									<td><textarea class='form-control' name='InjuryDescription'  rows='4' value='$InjuryDescription'>$InjuryDescription</textarea></td>
									<td><input class='form-control' type='text' name='FriendlyPet' value='$FriendlyPet'></td>
									<td><input class='form-control' type='text' name='ColonySetting' value='$ColonySetting'></td>
									<td><textarea class='form-control' name='Comments'  rows='4' value='$Comments'>$Comments</textarea></td>								
									<td><input class='form-control' type='text' name='Lat' value='$Lat'></td>
									<td><input class='form-control' type='text' name='Lng' value='$Lng'></td>

									<td> <label><input type='submit' class='form-control' id='recordEdit' name='recordEdit' value='Submit Edit'></label>
										 <label><input type='submit' class='form-control' name='cancel' value='Cancel Edit' id='cancelEdit'></label> </td>
								</tr>
								";
								}
							}
							else
							{
								print "
								<tr>
									<td></td>
								";

								if($tdString != '')
								{
									$tdString = "";
									foreach ($_SESSION['selectedColumns'] as $selectedOption)
									{
										$tdString.="<td>".$$selectedOption."</td>";
										//echo $selectedOption."\n";
									}
									print $tdString;
									print"<td></td></tr>";
									//$tdString = " ";
									//print"(un editable getEditRow is set Body )";
								}
								else
								{
									print "
									<td>$RecordNumber</td>
									<td id='dateTimeCol'>$DateAndTime</td>
									<td>$Responder</td>
									<td><textarea class='form-control' value='$Comments1' rows='3' readonly>$Comments1</textarea></td>
									<td id='statusCol'>$Status</td>
									<td>$FullName</td>
									<td>$Email</td>
									<td>$Phone1</td>
									<td>$Phone2</td>
									<td id='addressCol'>$ColonyAddress</td>
									<td id='cityCol'>$City</td>
									<td>$County</td>
									<td id='zipCodeCol'>$ZipCode</td>
									<td>$AnyoneAttempted</td>
									<td>$FeedIfReturned</td>
									<td>$ApproximateCats</td>
									<td>$Kittens</td>
									<td>$ColonyCareGiver</td>
									<td><textarea class='form-control' value='$FeederDescription' rows='3' readonly>$FeederDescription</textarea></td>
									<td>$Injured</td>
									<td><textarea class='form-control' value='$InjuryDescription' rows='3' readonly>$InjuryDescription</textarea></td>
									<td>$FriendlyPet</td>
									<td>$ColonySetting</td>
									<td><textarea class='form-control' value='$Comments' rows='3' readonly>$Comments</textarea></td>		
									<td id='latCol'>$Lat</td>
									<td id='lngCol'>$Lng</td>
								
									<td></td>
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
				$FeedIfReturned = $_POST['FeedIfReturned'];
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
				$Lat = $_POST['Lat'];
				$Lng = $_POST['Lng'];

				//echo $_POST['RecordNumber'];
				//echo $RecordNumber1;

				$reName = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";

				if(true) //preg_match($reName, $FullName) &&
				{
					//print  "count is : ".count($_GET['select2']);
					//print_r($_GET['select2']);

					if(count($_SESSION['selectedColumns']) !=0 )
					{
						/* Build $query*/

						$query = "select * from ReportColonyForm where ";

						foreach($_SESSION['selectedColumns'] as $selectedItem)
						{
							$query.=$selectedItem." ='".$$selectedItem."'";
							$query.=" and ";
						}

						$query=rtrim($query," and ");

						$result = mysqli_query($link, $query);

						if(mysqli_num_rows($result) == 0)
						{
							$queryupdate = " update ReportColonyForm set ";

							if(count($_GET['select2'] == 0))
							{
								//print "hi?";
							}

							foreach($_SESSION['selectedColumns'] as $selectedItem)
							{
								if($selectedItem == "RecordNumber" || $selectedItem == "DateAndTime")
								{
									continue;
								}

								$queryupdate.=$selectedItem."='".mysql_real_escape_string($$selectedItem)."'";					
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
							if(!$queryupdate = $link->prepare("update ReportColonyForm set 
							Comments1=?, 
							Responder=?, 
							Status=?,
							FullName=?, 
							Email=?,
							Phone1=?, 
							Phone2=?, 
							ColonyAddress=?,
							City=?, 
							County=?, 
							ZipCode=?, 
							AnyoneAttempted=?,
							ApproximateCats=?, 
							Kittens=?, 
							ColonyCareGiver=?, 
							FeederDescription=?,
							Injured=?, 
							InjuryDescription=?, 
							FriendlyPet=?, 
							ColonySetting=?, 
							Comments=?,
							VolunteerResponding=?, 
							ResponseDate=?, 
							CustNeedOutcome=?,
							BeatTeamLeader=?, 
							Outcome=?, 
							CompletionDate=?, 
							FeedIfReturned=?,
							Lat=?, 
							Lng=? 
							where RecordNumber=?")) { echo "Update failed: Prepare failed. "; }
							if(!$queryupdate->bind_param("sssssssssssssissssssssssssssddi", $Comments1, $Responder, $Status, $FullName, $Email, $Phone1, $Phone2, $ColonyAddress, $City, $County, $ZipCode, $AnyoneAttempted, 
							$ApproximateCats, $Kittens, $ColonyCareGiver, $FeederDescription, $Injured, $InjuryDescription, $FriendlyPet, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, $CustNeedOutcome, 
							$BeatTeamLeader, $Outcome, $CompletionDate, $FeedIfReturned, $Lat, $Lng, $RecordNumber1)){ echo "Update failed: Binding failed. "; }
							if(!$queryupdate->execute()){ 
								echo "Update failed: Execute failed. "; 
							}else{
								print "<span id='recupdate'><h2>Record was updated</h2></span>";
							}
							$queryupdate->close();	
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

				foreach ($RecordNumber as $rec){
					//Save deleted record(s) in DeletedReports
					$query = "insert into DeletedReports (
						Comments1,
						Responder,
						`Status`,
						RecordNumber,
						DateAndTime,
						FeedIfReturned,
						FullName,
						Email,
						Phone1,
						Phone2,
						ColonyAddress,
						City,
						County,
						ZipCode,
						AnyoneAttempted,
						ApproximateCats,
						Kittens,
						ColonyCareGiver,
						FeederDescription,
						Injured,
						InjuryDescription,
						FriendlyPet,
						ColonySetting,
						Comments,
						VolunteerResponding,
						ResponseDate,
						CustNeedOutcome,
						BeatTeamLeader,
						Outcome,
						CompletionDate,
						Lat,
						Lng) 
						(SELECT * FROM ReportColonyForm where RecordNumber = $rec);";					
					mysqli_query($link, $query);
					
					//Delete record(s)
					$query = "delete from ReportColonyForm where RecordNumber='$rec'";
					mysqli_query($link, $query);													
				}
				print "<span id='recupdate'><h2>Record(s) Deleted</h2></span>";
			}

			$sort = $_GET['sort']; //'sort' is magic sorting variable
			if(!isset($sort))
			{
				$sort = "RecordNumber";
			}

			if(isset($_SESSION['querysearch'])){
				//query search
				$s = mysqli_query($link, $_SESSION['querysearch']." order by $sort desc");
				if (mysqli_num_rows($s)!=0)
					$result = $s;
			}
			else{
				//regular search
				$query = "select * from ReportColonyForm where Status='open' order by $sort desc";
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
				<b>Report A Feral Cat Colony</b>
				<div class='row'>
					<div class='col-xs-6 col-sm-6 col-md-6' style='padding-left:7px; padding-right:7px;'>
						<button class='btn btn-success' id='editrowbtn' style='margin-bottom:2px' onclick='editFunction()' disabled='true'>Edit</button>
						<button class='btn btn-info' id='formviewbtn' style='margin-bottom:2px' onclick='formviewFunction()' disabled='true'>Form View</button>
						<button class='btn' id='copyrowbtn' style='background-color:gold; color:black; margin-bottom:2px' onclick='copyFunction2()' disabled='true'>Copy</button>
						&nbsp;&nbsp;&nbsp;<button class='btn btn-danger' id='deleterowbtn' style='margin-bottom:2px' onclick='deleteFunction()' class='confirmation' disabled='true'>Delete</button>
					</div>
					<div class='col-xs-6 col-sm-6 col-md-6' style='text-align:right; padding-right:5px; padding-left:7px;'>
						<input class='btn btn-default' type='button' value='Reset' name='RefreshTable' onclick=\"location.href='search.php?RefreshTable=Reset'\"/>
						<input class='btn btn-success' type='button' id='exportButton' onclick=\"tableToExcel('reportTable', 'Reports')\" value='Export' />
					</div>
				</div>
				
				<table id='reportTable' class='table table-striped table-bordered table-condensed'>
					<thead>
						<tr>";

							if($thString != '')
								{
									print $thString;
									print"</tr></thead>";
									//print"(editRow not set header)";
								}
								else
								{
									print "
							<th><a href='search.php?sort=RecordNumber'>ID</a></th>
							<th><a href='search.php?sort=DateAndTime'>Date/Time</a></th>
							<th><a href='search.php?sort=Responder'>Responder</a></th>
							<th><a href='search.php?sort=Comments1'>Comments</a></th>
							<th><a href='search.php?sort=Status'>Status</a></th>
							<th><a href='search.php?sort=FullName'>FullName</a></th>
							<th><a href='search.php?sort=Email'>Email</a></th>
							<th><a href='search.php?sort=Phone1'>Phone1</a></th>
							<th><a href='search.php?sort=Phone2'>Phone2</a></th>
							<th><a href='search.php?sort=ColonyAddress'>Address</a></th>
							<th><a href='search.php?sort=City'>City</a></th>
							<th><a href='search.php?sort=County'>County</a></th>
							<th><a href='search.php?sort=ZipCode'>Zip</a></th>
							<th><a href='search.php?sort=AnyoneAttempted'>Trap/ Tip</a></th>
							<th><a href='search.php?sort=FeedIfReturned'>Feed</a></th>
							<th><a href='search.php?sort=ApproximateCats'>#Cats</a></th>
							<th><a href='search.php?sort=Kittens'>Kittens</a></th>
							<th><a href='search.php?sort=ColonyCareGiver'>Caregiver</a></th>
							<th><a href='search.php?sort=FeederDescription'>Description</a></th>
							<th><a href='search.php?sort=Injured'>Sick</a></th>
							<th><a href='search.php?sort=InjuryDescription'>Description</a></th>
							<th><a href='search.php?sort=FriendlyPet'>Friendly</a></th>
							<th><a href='search.php?sort=ColonySetting'>Setting</a></th>																				
							<th><a href='search.php?sort=Comments'>Additional Comments</a></th>		
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
						list($Comments1, $Responder, $Status, $RecordNumber, $DateAndTime, $FeedIfReturned, $FullName, $Email, $Phone1, $Phone2, $ColonyAddress,
						$City, $County, $ZipCode, $AnyoneAttempted, $ApproximateCats, $Kittens, $ColonyCareGiver, $FeederDescription,
						$Injured, $InjuryDescription, $FriendlyPet, $ColonySetting, $Comments, $VolunteerResponding, $ResponseDate, 
						$CustNeedOutcome, $BeatTeamLeader, $Outcome, $CompletionDate, $Lat, $Lng) = $row; // variables are set to current row
																		// then printed in one table row
						$myArray[0]=$RecordNumber;
						$myArray[1]=$DateAndTime;
						$myArray[2]=$Responder;
						$myArray[3]=$Comments1;
						$myArray[4]=$Status;
						$myArray[5]=$FullName;
						$myArray[6]=$Email;
						$myArray[7]=$Phone1;
						$myArray[8]=$Phone2;
						$myArray[9]=$ColonyAddress;
						$myArray[10]=$City;
						$myArray[11]=$County;
						$myArray[12]=$ZipCode;
						$myArray[13]=$AnyoneAttempted;
						$myArray[14]=$FeedIfReturned;
						$myArray[15]=$ApproximateCats;
						$myArray[16]=$Kittens;
						$myArray[17]=$ColonyCareGiver;
						$myArray[18]=$FeederDescription;
						$myArray[19]=$Injured;
						$myArray[20]=$InjuryDescription;
						$myArray[21]=$FriendlyPet;
						$myArray[22]=$ColonySetting;
						$myArray[23]=$Comments;				
						$myArray[24]=$Lat;
						$myArray[25]=$Lng;

						$myArray1[0]="RecordNumber";
						$myArray1[1]="DateAndTime";
						$myArray1[2]="Responder";
						$myArray1[3]="Comments1";
						$myArray1[4]="Status";
						$myArray1[5]="FullName";
						$myArray1[6]="Email";
						$myArray1[7]="Phone1";
						$myArray1[8]="Phone2";
						$myArray1[9]="ColonyAddress";
						$myArray1[10]="City";
						$myArray1[11]="County";
						$myArray1[12]="ZipCode";
						$myArray1[13]="AnyoneAttempted";
						$myArray1[14]="FeedIfReturned";
						$myArray1[15]="ApproximateCats";
						$myArray1[16]="Kittens";
						$myArray1[17]="ColonyCareGiver";
						$myArray1[18]="FeederDescription";
						$myArray1[19]="Injured";
						$myArray1[20]="InjuryDescription";
						$myArray1[21]="FriendlyPet";
						$myArray1[22]="ColonySetting";
						$myArray1[23]="Comments";			
						$myArray1[24]="Lat";
						$myArray1[25]="Lng";
						
						print "
						<tr id='$RecordNumber'>";

							//$_GET['select2'] as RecordNumber
							foreach ($_SESSION['selectedColumns'] as $selectedOption)//only once every time.. record number
							{
								for ($i = 0; $i<26; $i++)
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
									foreach ($_SESSION['selectedColumns'] as $selectedOption)
									{
										switch($selectedOption){
											case 'Status': $tdString.="<td = id='statusCol'>".$$selectedOption."</td>"; break;
											case 'DateAndTime': $tdString.="<td = id='dateTimeCol'>".$$selectedOption."</td>"; break;
											case 'Comments1': $tdString.="<td><textarea class='form-control' value='$Comments1' rows='3' readonly>$Comments1</textarea></td>"; break;
											case 'ColonyAddress': $tdString.="<td = id='addressCol'>".$$selectedOption."</td>"; break;
											case 'City': $tdString.="<td = id='cityCol'>".$$selectedOption."</td>"; break;
											case 'ZipCode': $tdString.="<td = id='zipCodeCol'>".$$selectedOption."</td>"; break;
											case 'FeederDescription': $tdString.="<td><textarea class='form-control' name='FeederDescription' value='$FeederDescription' rows='3' readonly>$FeederDescription</textarea></td>"; break;
											case 'InjuryDescription': $tdString.="<td><textarea class='form-control' name='InjuryDescription' value='$InjuryDescription' rows='3' readonly>$InjuryDescription</textarea></td>"; break;											
											case 'Comments': $tdString.="<td><textarea class='form-control' value='$Comments' rows='3' readonly>$Comments</textarea></td>"; break;
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

							<td>$RecordNumber</td>
							<td id='dateTimeCol'>$DateAndTime</td>
							<td>$Responder</td>
							<td><textarea class='form-control' value='$Comments1' rows='3' readonly>$Comments1</textarea></td>
							<td id='statusCol'>$Status</td>
							<td>$FullName</td>
							<td>$Email</td>
							<td>$Phone1</td>
							<td>$Phone2</td>
							<td id='addressCol'>$ColonyAddress</td>
							<td id='cityCol'>$City</td>
							<td>$County</td>
							<td id='zipCodeCol'>$ZipCode</td>
							<td>$AnyoneAttempted</td>
							<td>$FeedIfReturned</td>
							<td>$ApproximateCats</td>
							<td>$Kittens</td>
							<td>$ColonyCareGiver</td>
							<td><textarea class='form-control' name='FeederDescription'  value='$FeederDescription' rows='3' readonly>$FeederDescription</textarea></td>
							<td>$Injured</td>
							<td><textarea class='form-control' name='InjuryDescription' value='$InjuryDescription' rows='3' readonly>$InjuryDescription</textarea></td>
							<td>$FriendlyPet</td>
							<td>$ColonySetting</td>
							<td><textarea class='form-control' value='$Comments' rows='3' readonly>$Comments</textarea></td>		
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
?>

   		<form id="resettable" method='get' action='search.php'>
			<input class='btn btn-default' type='submit' value='Reset' name='RefreshTable'/>
			<input class='btn btn-success' type='button' id='exportButton' onclick="tableToExcel('reportTable', 'Reports')" value='Export' />
			<span id="ttlrecs"><b>Total Records: <?php echo $_SESSION['totalrecords']; ?></b></span>
		</form>
		<div class="pull-right">
			<button class='btn btn-success' id='editrowbtn2' style='margin-bottom:2px' onclick='editFunction()' disabled='true'>Edit</button>
			<button class='btn btn-info' id='formviewbtn2' style='margin-bottom:2px' onclick='formviewFunction()' disabled='true'>Form View</button>
			<button class='btn' id='copyrowbtn2' style='background-color:gold; color:black; margin-bottom:2px' onclick='copyFunction2()' disabled='true'>Copy</button>
			&nbsp;&nbsp;&nbsp;<button class='btn btn-danger' id='deleterowbtn2' style='margin-bottom:2px' onclick='deleteFunction()' class='confirmation' disabled='true'>Delete</button>
		</div>
		</div> <!-- end div class='col-sm'12' -->
		</div> <!-- end div class='row' -->
		<hr>
   		<div class="row">
			<div class="col-sm-12">
				<b>Clustered Hot Spot</b><br><br>
				<button class="btn btn-primary" id='clusterAddrBtn' type='button' onclick='setTimeout(errorCheck, 500);'>Map Query</button>
				<button class="btn btn-default" id='clusterAddrClearBtn' type='button' onclick='clearMap()'>Clear Map</button>
				<br><br>
				<div class="alert" id='alert' style='display:none'>
					<span class="closebtn" onclick="this.parentElement.style.display='none'">&times;</span>
					<label id='errorMsg'></label>
				</div>
				<div onload="initMap()" id="map"><div id="map-canvas"></div></div>
			</div>
		</div>
		
		<script src="js/plotMapScript.js?version=6.0"></script>
		<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDz2ZSC6IJEf38QeSbLwIxTEohm4ATem9M&callback=initMap"></script>
		
		<div class="copysuccessmsg" role="alert" hidden>Copied to clipboard</div>
<?php
		}
		else {
			print "you aren't supposed to be here.. STOP SNEAKING AROUND";
			header("Location: userprofile.php");
		}
	}
?>

</div> <!-- end maindiv -->

<script type="text/javascript">
$(document).ready(function(){
	if(!(window.location.href.toString().includes("search.php?editrow=yes"))){
		$('table tbody tr').click(function(){
			if($(this).attr('selected')=='selected'){
				$(this).attr('selected',false);
			}
			else $(this).attr('selected',true);
			
			if($('[selected="selected"]')[0]!=null){
				$('#editrowbtn').attr("disabled",false);
				$('#deleterowbtn').attr("disabled",false);
				$('#formviewbtn').attr("disabled",false);
				$('#copyrowbtn').attr("disabled",false);
				$('#editrowbtn2').attr("disabled",false);
				$('#deleterowbtn2').attr("disabled",false);
				$('#formviewbtn2').attr("disabled",false);
				$('#copyrowbtn2').attr("disabled",false);
			}
			else {
				$('#editrowbtn').attr("disabled",true);
				$('#deleterowbtn').attr("disabled",true);
				$('#formviewbtn').attr("disabled",true);
				$('#copyrowbtn').attr("disabled",true);
				$('#editrowbtn2').attr("disabled",true);
				$('#deleterowbtn2').attr("disabled",true);
				$('#formviewbtn2').attr("disabled",true);
				$('#copyrowbtn2').attr("disabled",true);
			}
		});
	}
});
</script>

</body>
</html>
