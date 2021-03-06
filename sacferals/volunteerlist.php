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

		if($level == 1 || $level==2)
		{
?>

<!DOCTYPE html>
<html lang="en">
   	<head>
		<title>Volunteer</title>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="css/search.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
        
       	<script src="js/exportExcelScript.js"></script>
		<script src="js/customquery.js"></script> 
  	</head>
	<body>
	<div class="header"> <!-- navbar -->
		<nav class="navbar navbar-inverse navbar-default navbar-static-top" role="navbar">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand">Logged in as <?php echo $Ausername ?></a>
				</div>
				<ul class="nav navbar-nav">
					<li><a href="search.php">View Records</a></li>
					<li class="active"><a href="#">View Volunteers</a></li>
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
		<div class="col-md-4">
			<form id='form1' name='form1' method='get' action='volunteerlist.php'>
				<div>
					<p id="columnselect"><small>Note: Hold down ctrl or shift to select multiple columns to display in table.<br> Click 'Reset' to get full table.</small></p>
					<label><b>Column Selector</b></label>
				</div>
				<select class="input-sm" id="colsel" name='select2[]' size='8' multiple='multiple' tabindex='1'>
					<option value='RecordNumber'>ID</option>
					<option value='Comments'>Triage Comments</option>
					<option value='VolunteerStatus'>Volunteer Status</option>
					<option value='DateAndTime'>Date Submitted</option>
					<option value='WorkshopAttended'>Workshop</option>
					<option value='WorkshopDate'>Workshop Date</option>
					<option value='DateActivated'>Date Activated</option>
					<option value='FullName'>Full Name</option>
					<option value='Address'>Complete Address</option>
					<option value='Email'>Email</option>
					<option value='Phone1'>Phone1</option>
					<option value='Phone2'>Phone2</option>
					<option value='PreferedContact'>Prefered Contact</option>
					<option value='contactemail'>Prefered Email</option>
					<option value='contactphone1'>Prefered Phone1</option>
					<option value='contactphone2'>Prefered Phone2</option>
					<option value='TypeOfWork'>Type Of Work</option>
					<option value='transporting'>Transporter</option>
					<option value='helptrap'>Trapper</option>
					<option value='helpeducate'>Educator</option>
					<option value='usingphone'>Triage</option>
					<option value='other'>Other</option>
					<option value='OtherTasks'>Other Tasks Details</option>
					<option value='PastWorkExp'>Past Experience</option>
					<option value='UnknownNameColumn'>Unknown</option>
					<option value='ResponseDate'>Response Date</option>
					<option value='EmailResponse'>Email Response</option>
					<option value='BEATId'>BEAT ID</option>					
					<option value='BEATName'>BEAT Name</option>
					<option value='BEATGeneralArea'>BEAT Gen. Area</option>
					<option value='BEATZipCodes'>BEAT Zip Code</option>
					<option value='BEATTrainDate'>BEAT Train Date</option>
					<option value='BEATMembers'>BEAT Member</option>
					<option value='BEATMembersPhone'>BEAT Member Phone</option>
					<option value='BEATMemberEmails'>BEAT Member Email</option>
					<option value='BEATType'>BEAT Type</option>
					<option value='BEATNotes'>BEAT Notes</option>
					<option value='BEATStatus'>BEAT Status</option>					
					<option value='TriageBEATNotes'>BEAT Triage Notes</option>
				</select>
				<br>
				<input class="btn btn-primary" type='submit' name='Submit' value='Submit' tabindex='2' />
				<input class="btn btn-default" type='submit' name='SelectAll' value='Reset'/>
			</form>
		</div>
		<div class="col-md-8"> <!-- Manual Query -->
			<form id='writtenqueryform' name='writtenquery' method='get' action='volunteerlist.php'>
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
			<form id="cannedqueryform" method='get' action='volunteerlist.php'>
				<label><b>Canned Queries</b></label>
				<div class="row" id="cannedqrow">
					<select class="input-sm col-md-6 col-sm-4 col-xs-8" id="cannedquery" name="cannedquery[]" tabindex='3'>
<?php
						$cannedq = "select * from CannedQueriesVolunteers";
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
			<form id="queryform" method='get' action='volunteerlist.php'>
				<label><b>Custom Query</b>
					<div id="tooltip"><img src="images/info.png" alt="i"/>
						<span class="tooltiptext">
							<b>Run</b> - run a new query<br>
							<b>Append</b> - add onto current query<br>
							<b>Reset</b> - clear query
						</span>
					</div>
				</label>
				&nbsp;&nbsp;&nbsp;
				<span style="color: darkgray;"><small>(Enter null for empty value. Exclude quotes for integers.)</small></span>
				<div class="row" id="cqrow">
					<div id="blueprint">
						<select class="input-sm" id="query" name="query[]" tabindex='3'>
							<option value='RecordNumber'>ID</option>
							<option value='Comments'>Triage Comments</option>
							<option value='VolunteerStatus'>Volunteer Status</option>
							<option value='DateAndTime'>Date Submitted</option>
							<option value='WorkshopAttended'>Workshop</option>
							<option value='WorkshopDate'>Workshop Date</option>
							<option value='DateActivated'>Date Activated</option>
							<option value='FullName'>Full Name</option>
							<option value='Address'>Complete Address</option>
							<option value='Email'>Email</option>
							<option value='Phone1'>Phone1</option>
							<option value='Phone2'>Phone2</option>
							<option value='PreferedContact'>Prefered Contact</option>
							<option value='contactemail'>Prefered Email</option>
							<option value='contactphone1'>Prefered Phone1</option>
							<option value='contactphone2'>Prefered Phone2</option>
							<option value='TypeOfWork'>Type Of Work</option>
							<option value='transporting'>Transporter</option>
							<option value='helptrap'>Trapper</option>
							<option value='helpeducate'>Educator</option>
							<option value='usingphone'>Triage</option>
							<option value='other'>Other</option>
							<option value='OtherTasks'>Other Tasks Details</option>
							<option value='PastWorkExp'>Past Experience</option>
							<option value='UnknownNameColumn'>Unknown</option>
							<option value='ResponseDate'>Response Date</option>
							<option value='EmailResponse'>Email Response</option>
							<option value='BEATId'>BEAT ID</option>					
							<option value='BEATName'>BEAT Name</option>
							<option value='BEATGeneralArea'>BEAT Gen. Area</option>
							<option value='BEATZipCodes'>BEAT Zip Code</option>
							<option value='BEATTrainDate'>BEAT Train Date</option>
							<option value='BEATMembers'>BEAT Member</option>
							<option value='BEATMembersPhone'>BEAT Member Phone</option>
							<option value='BEATMemberEmails'>BEAT Member Email</option>
							<option value='BEATType'>BEAT Type</option>
							<option value='BEATNotes'>BEAT Notes</option>
							<option value='BEATStatus'>BEAT Status</option>					
							<option value='TriageBEATNotes'>BEAT Triage Notes</option>
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
				</div>
			</form>
		</div>
	</div>
	
	<!-- modal for saving canned query name -->
	<div class="modal fade" id="getcndqnameModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="addcurrqry" method='get' action='volunteerlist.php'>
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
				<form id="addcurrqry2" method='get' action='volunteerlist.php'>
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
			if(isset($_GET['SelectAll'])){
				unset($_SESSION['volunteerselectedColumns']);
			}

			$thString="";
			$tdString="";
			$thEditString="";
			$tdEditString="";
			
			//change selected columns only if unset
			//if(!isset($_SESSION['volunteerselectedColumns'])){ 

			/*if(count($_SESSION['volunteerselectedColumns']) > 0 && ( count($_GET['editrow']) != 0 || count($_POST['recordEdit']) != 0 ))
			{
				$_GET['select2'] = $_SESSION['volunteerselectedColumns'];
			}*/

			if(isset($_GET['Submit']))//count($_GET['select2']) >= 0)
			{
				$_SESSION['volunteerselectedColumns'] = $_GET['select2'];
			}

			if(isset($_SESSION['volunteerselectedColumns'])){
				foreach ($_SESSION['volunteerselectedColumns'] as $selectedOption)
				{
					$thEditString.="<th><a>".$selectedOption."</a></th>";
					$tdString.="<td>$".$selectedOption."</td>";
					
					if($selectedOption=="RecordNumber") $printvalue = "ID";
					else if($selectedOption=="Comments") $printvalue = "Triage Comments";
					else if($selectedOption=="VolunteerStatus") $printvalue = "Volunteer Status";
					else if($selectedOption=="DateAndTime") $printvalue = "Date Submitted";
					else if($selectedOption=="WorkshopAttended") $printvalue = "Workshop Attended";
					else if($selectedOption=="WorkshopDate") $printvalue = "Workshop Date";
					else if($selectedOption=="DateActivated") $printvalue = "Date Activated";
					else if($selectedOption=="FullName") $printvalue = "Full Name";
					else if($selectedOption=="PreferedContact") $printvalue = "Prefered Contact";
					else if($selectedOption=="contactemail") $printvalue = "Prefered Email";
					else if($selectedOption=="contactphone1") $printvalue = "Prefered Phone1";
					else if($selectedOption=="contactphone2") $printvalue = "Prefered Phone2";
					else if($selectedOption=="TypeOfWork") $printvalue = "Type Of Work";
					else if($selectedOption=="transporting") $printvalue = "Transporter";
					else if($selectedOption=="helptrap") $printvalue = "Trapper";
					else if($selectedOption=="helpeducate") $printvalue = "Educator";
					else if($selectedOption=="usingphone") $printvalue = "Triage";
					else if($selectedOption=="other") $printvalue = "Other";
					else if($selectedOption=="OtherTasks") $printvalue = "Other Tasks Details";
					else if($selectedOption=="PastWorkExp") $printvalue = "Past Experience";
					else if($selectedOption=="ResponseDate") $printvalue = "Response Date";
					else if($selectedOption=="EmailResponse") $printvalue = "Email Response";
					else if($selectedOption=="BEATId") $printvalue = "BEAT ID";
					else if($selectedOption=="BEATName") $printvalue = "BEAT Name";
					else if($selectedOption=="BEATGeneralArea") $printvalue = "BEAT Gen. Area";
					else if($selectedOption=="BEATZipCodes") $printvalue = "BEAT Zip Code";
					else if($selectedOption=="BEATTrainDate") $printvalue = "BEAT Train Date";
					else if($selectedOption=="BEATMembers") $printvalue = "BEAT Member";
					else if($selectedOption=="BEATMembersPhone") $printvalue = "BEAT Member Phone";
					else if($selectedOption=="BEATMemberEmails") $printvalue = "BEAT Member Email";
					else if($selectedOption=="BEATType") $printvalue = "BEAT Type";
					else if($selectedOption=="BEATNotes") $printvalue = "BEAT Notes";
					else if($selectedOption=="BEATStatus") $printvalue = "BEAT Status";
					else if($selectedOption=="TriageBEATNotes") $printvalue = "BEAT Triage Notes";
					else $printvalue = $selectedOption;
					$thString.="<th><a href='volunteerlist.php?sort=".$selectedOption."'>".$printvalue."</a></th>";
					
					if($selectedOption=="RecordNumber" || $selectedOption=="DateAndTime" )
						$tdEditString.="<td><input type='hidden' name='".$selectedOption."' value='$".$selectedOption."'>$".$selectedOption."</td>";
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
			<input type='checkbox' name='searchtables[]' value='VolunteerForm' class='checkdisplay' > VolunteerForm
			<input type='checkbox' name='searchtables[]' value='FeralInterventionForm' class='checkdisplay1' > FeralInterventionForm
			<input type='checkbox' name='searchtables[]' value='VolunteerForm' class='checkdisplay2' > VolunteerForm
			<input type='checkbox' name='searchtables[]' value='SundaySSPCA' class='checkdisplay3' > SundaySSPCA
			<input type='checkbox' name='searchtables[]' value='EmergencyC4CCVouchers' class='checkdisplay4' > EmergencyC4CCVouchers
			<div class='todisplay'>"; */

			//custom query builder search - overwrite current
			if(isset($_GET['runquery'])){
				$value = $_GET['queryvalue'][0];
				if($value!=NULL) {
					$search = "select * from VolunteerForm where (";
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
					else $_SESSION['volunteerquerysearch'] = $search;
				}
			}
			//custom query builder search - append
			if(isset($_GET['submitquery'])){
				//unset($_SESSION['volunteerquerysearch']); //refresh variable
				//mysql: contains == like -> column like '%value%'
				$value = $_GET['queryvalue'][0];
				if($value!=NULL) {
					if(!(isset($_SESSION['volunteerquerysearch']))) $search = "select * from VolunteerForm where (";
					else $search = $_SESSION['volunteerquerysearch']." AND (";
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
					else $_SESSION['volunteerquerysearch'] = $search;
				}
			}
			//canned query search
			if(isset($_GET['submitcannedquery'])){
				//unset($_SESSION['volunteerquerysearch']); //refresh variable
				$cannedqueryname = $_GET['cannedquery'][0];
				
				$sea = "select * from CannedQueriesVolunteers where QueryName='".$cannedqueryname."'";
				$res = mysqli_query($link, $sea);
				if(mysqli_num_rows($res)==0)
					echo "<div id='emptyquerymsg'><h3> Error </h3> Query: ".$sea."</div>";
				else {
					$rw = mysqli_fetch_row($res);
					$haha = mysqli_query($link, $rw[2]); //check if legal query
					if(mysqli_num_rows($haha)!=0)
						$_SESSION['volunteerquerysearch'] = $rw[2];
					else echo "<div id='emptyquerymsg'><h3> Error </h3> Query: ".$rw[2]."</div>";
				}
			}
			//canned query check for existance & then display modal
			if(isset($_GET['savecurrentquery'])){
				if(isset($_SESSION['volunteerquerysearch'])){
					$sea = 'select * from CannedQueriesVolunteers where QueryString="'.$_SESSION['volunteerquerysearch'].'"';
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
					echo "<div id='emptyquerymsg'><h3> Error </h3> Query: ".$sea."</div>";
				}
			}
			//canned query save
			if(isset($_GET['addcurrentquery'])){
				$qryname = $_GET['queryname'];

				//still check if exists so doesn't keep adding to db
				$sea = 'select * from CannedQueriesVolunteers where QueryString="'.$_SESSION['volunteerquerysearch'].'"';
				$res = mysqli_query($link, $sea);
				if(mysqli_num_rows($res)==0){
					$savecannedqry = "insert into CannedQueriesVolunteers values(NULL, '".$qryname."', ".'"'.$_SESSION['volunteerquerysearch'].'"'.")";
					mysqli_query($link, $savecannedqry);
				}
			}
			//canned query delete
			if(isset($_GET['deletecannedquery'])){
				$cannedqueryname = $_GET['cannedquery'][0];
				
				$sea = "delete from CannedQueriesVolunteers where QueryName='".$cannedqueryname."'";
				$res = mysqli_query($link, $sea);
				if(mysqli_num_rows($res)==0){
					print "<span id='recupdate'><h2>Query \"".$cannedqueryname."\" was removed</h2></span>";
				} else print "error";
			}
			//manual query run
			if(isset($_GET['runwrittenqry'])){
				//unset($_SESSION['volunteerquerysearch']); //refresh variable
				$wrttnqry = $_GET['manquery'];
				$cols = explode(" ",$wrttnqry);
				$wrttnqryres = mysqli_query($link, $wrttnqry);
				if(mysqli_num_rows($wrttnqryres)==0 || ((strcasecmp($cols[0],'select'))!=0 && $cols[3]!='VolunteerForm'))
					echo "<div id='emptyquerymsg'><h3> Error </h3> Query: ".$wrttnqry."</div>";
				else $_SESSION['volunteerquerysearch'] = $wrttnqry;
			}
			//manual query check for existance & then display modal to get name
			if(isset($_GET['savewrittenqry'])){
				$qryname = str_replace("'", "\'", $_GET['queryname2']);
				$newq = str_replace("'", "\'", $_GET['manquery']);
				
				//dont do anything if empty
				if($newq != ''){
					$wrttnqry = "select * from CannedQueriesVolunteers where QueryString='".$newq."'";
					$wrttnqryres = mysqli_query($link, $wrttnqry);
					if(mysqli_num_rows($wrttnqryres)==0){
						$_SESSION['volunteerquerytosave'] = $newq;
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
				
				$wrttnqry = "select * from CannedQueriesVolunteers where QueryString='".$_SESSION['volunteerquerytosave']."'";
				$wrttnqryres = mysqli_query($link, $wrttnqry);
				if(mysqli_num_rows($wrttnqryres)==0){
					$savewrttnqry = "insert into CannedQueriesVolunteers values(NULL, '".$qryname."', '".$_SESSION['volunteerquerytosave']."')";
					mysqli_query($link, $savewrttnqry);
				}
			}
			
			if(isset($_GET['RefreshTable'])){ //nullify the query
				unset($_SESSION['volunteerquerysearch']);
			}
			
			///////////////////////////////////////////////////////////////////////////////////////////
			//edit detector
			if(isset($_GET['editrow']))
			{
				$RecordNumber1 = $_GET['RecordNumber'];
								
				$query = "select * from VolunteerForm  where RecordNumber = ".$RecordNumber1." order by RecordNumber desc";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($RecordNumber, $Comments, $VolunteerStatus, $DateAndTime, $FullName, $Address, $Email, $Phone1, $Phone2, $PreferedContact, $contactemail, $contactphone1, $contactphone2, $TypeOfWork, $transporting, $helptrap, $helpeducate, $usingphone, $helpingclinic, $other, $OtherTasks, $PastWorkExp, $UnknownNameColumn, $ResponseDate, $EmailResponse, $BEATId, $BEATName, $BEATGeneralArea, $BEATZipCodes, $BEATTrainDate, $BEATMembers, $BEATMembersPhone,$BEATMemberEmails, $BEATType, $BEATNotes, $BEATStatus, $TriageBEATNotes, $DateActivated, $WorkshopAttended, $WorkshopDate) = $row;
				
				/*
				list($RecordNumber, $DateAndTime, $FullName, $CompleteAddress, $Email, $Phone1, $Phone2, $PreferedContact, 
					$contactEmail, $contactphone1, $contactphone2, $TypeOfWork, $transporting, $helptrap, $helpeducate, 
					$usingphone, $helpingclinic, $Other, $OtherTasks, $PastWorkExp, $UnknownNameColumn, $ResponseDate, 
					$EmailResponse) = $row; // variables are set to current row*/

					$sort = $_GET['sort']; //'sort' is magic sorting variable
					if(!isset($sort))
					{
						$sort = "RecordNumber";
					}
				if(isset($_SESSION['volunteerquerysearch'])){
					//query search
					$s = mysqli_query($link, $_SESSION['volunteerquerysearch']." order by $sort desc");
					if (mysqli_num_rows($s)!=0) $result = $s;
				}
				else{
					//regular search
					$query = "select * from VolunteerForm order by $sort desc";
					$result = mysqli_query($link, $query);
				}
				
				//////////////////////////////////////////////////////////////////////////////////////
				// print table (happens first before input)
					if(isset($_SESSION['volunteerquerysearch'])) $q="QUERY: ";
					// first print row of links/headers that sort
					print "
					<span id='querymsg'><h5>".$q.$_SESSION['volunteerquerysearch']."</h5></span>
					<div class='row'>
					<div class='col-sm-12'>
					<form method='post' action='volunteerlist.php'>

					<b>Volunteer Table</b>
					<div class='row' style='float: right'>
						<div class='col-xs-12 col-sm-12 col-md-12' style='text-align:right; padding-right:5px;'>
							<input class='btn btn-default' type='button' value='Reset' name='RefreshTable' onclick=\"location.href='volunteerlist.php?RefreshTable=Reset'\"/>
							<input class='btn btn-success' type='button' id='exportButton' onclick=\"tableToExcel('volunteerTable', 'Volunteers')\" value='Export' />
						</div>
					</div>
					
					<table id='volunteerTable' class='table table-striped table-bordered table-condensed'>
						<thead>
							<tr>";
							if($thString != '')
							{
								print $thString;
								print"</tr></thead>";
								//print"(getEditRow is set header)";
							}
							else
							{
								print "
								<th><a href='volunteerlist.php?sort=RecordNumber'>ID</a></th>
								<th><a href='volunteerlist.php?sort=Comments'>Triage Comments</a></th>
								<th><a href='volunteerlist.php?sort=VolunteerStatus'>Volunteer Status</a></th>
								<th><a href='volunteerlist.php?sort=DateAndTime'>Date Submitted</a></th>
								<th><a href='volunteerlist.php?sort=WorkshopAttended'>Workshop</a></th>
								<th><a href='volunteerlist.php?sort=WorkshopDate'>Workshop Date</a></th>
								<th><a href='volunteerlist.php?sort=DateActivated'>Date Activated</a></th>
								<th><a href='volunteerlist.php?sort=FullName'>Full Name</a></th>
								<th><a href='volunteerlist.php?sort=Address'>Complete Address</a></th>
								<th><a href='volunteerlist.php?sort=Email'>Email</a></th>
								<th><a href='volunteerlist.php?sort=Phone1'>Phone1</a></th>
								<th><a href='volunteerlist.php?sort=Phone2'>Phone2</a></th>
								<th><a href='volunteerlist.php?sort=PreferedContact'>Prefered Contact</a></th>
								<th><a href='volunteerlist.php?sort=contactemail'>Prefered Email</a></th>
								<th><a href='volunteerlist.php?sort=contactphone1'>Prefered Phone1</a></th>
								<th><a href='volunteerlist.php?sort=contactphone2'>Prefered Phone2</a></th>
								<th><a href='volunteerlist.php?sort=TypeOfWork'>Type Of Work</a></th>
								<th><a href='volunteerlist.php?sort=transporting'>Transporter</a></th>
								<th><a href='volunteerlist.php?sort=helptrap'>Trapper</a></th>
								<th><a href='volunteerlist.php?sort=helpeducate'>Educator</a></th>
								<th><a href='volunteerlist.php?sort=usingphone'>Triage</a></th>
								<th><a href='volunteerlist.php?sort=other'>Other</a></th>
								<th><a href='volunteerlist.php?sort=OtherTasks'>Other Tasks Details</a></th>
								<th><a href='volunteerlist.php?sort=PastWorkExp'>Past Experience</a></th>
								<th><a href='volunteerlist.php?sort=UnknownNameColumn'>Unknown</a></th>
								<th><a href='volunteerlist.php?sort=ResponseDate'>Response Date</a></th>
								<th><a href='volunteerlist.php?sort=EmailResponse'>Email Response</a></th>
								<th><a href='volunteerlist.php?sort=BEATId'>BEAT ID</a></th>					
								<th><a href='volunteerlist.php?sort=BEATName'>BEAT Name</a></th>
								<th><a href='volunteerlist.php?sort=BEATGeneralArea'>BEAT Gen. Area</a></th>
								<th><a href='volunteerlist.php?sort=BEATZipCodes'>BEAT Zip Code</a></th>
								<th><a href='volunteerlist.php?sort=BEATTrainDate'>BEAT Train Date</a></th>
								<th><a href='volunteerlist.php?sort=BEATMembers'>BEAT Member</a></th>
								<th><a href='volunteerlist.php?sort=BEATMembersPhone'>BEAT Member Phone</a></th>
								<th><a href='volunteerlist.php?sort=BEATMemberEmails'>BEAT Member Email</a></th>
								<th><a href='volunteerlist.php?sort=BEATType'>BEAT Type</a></th>
								<th><a href='volunteerlist.php?sort=BEATNotes'>BEAT Notes</a></th>
								<th><a href='volunteerlist.php?sort=BEATStatus'>BEAT Status</a></th>					
								<th><a href='volunteerlist.php?sort=TriageBEATNotes'>BEAT Triage Notes</a></th>
							</tr>";
							}
						print"	
						</thead>
						
						<tbody>";

						//while the next row (set by query) exists?
						while($row = mysqli_fetch_row($result))
						{
							list($RecordNumber, $Comments, $VolunteerStatus, $DateAndTime, $FullName, $Address, $Email, $Phone1, $Phone2, $PreferedContact, $contactemail, $contactphone1, $contactphone2, $TypeOfWork, $transporting, $helptrap, $helpeducate, $usingphone, $helpingclinic, $other, $OtherTasks, $PastWorkExp, $UnknownNameColumn, $ResponseDate, $EmailResponse, $BEATId, $BEATName, $BEATGeneralArea, $BEATZipCodes, $BEATTrainDate, $BEATMembers, $BEATMembersPhone, $BEATMemberEmails, $BEATType, $BEATNotes, $BEATStatus, $TriageBEATNotes, $DateActivated, $WorkshopAttended, $WorkshopDate) = $row; // then printed in one table row
						
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



									foreach ($_SESSION['volunteerselectedColumns'] as $selectedOption)
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


									if(!in_array($RecordNumber, $_SESSION['volunteerselectedColumns']))
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
									<td><input type='hidden' name='RecordNumber' value='$RecordNumber'>$RecordNumber</td>									
									<td><input type='text' name='Comments' value='$Comments'></td>
									<td><input type='text' name='VolunteerStatus' value='$VolunteerStatus'></td>
									<td><input type='text' name='DateAndTime' value='$DateAndTime'></td>
									<td><input type='text' name='WorkshopAttended' value='$WorkshopAttended'></td>
									<td><input type='text' name='WorkshopDate' value='$WorkshopDate'></td>
									<td><input type='text' name='DateActivated' value='$DateActivated'></td>
									<td><input type='text' name='FullName' value='$FullName'></td>
									<td><input type='text' name='Address' value='$Address'></td>
									<td><input type='text' name='Email' value='$Email'></td>
									<td><input type='text' name='Phone1' value='$Phone1'></td>
									<td><input type='text' name='Phone2' value='$Phone2'></td>
									<td><input type='text' name='PreferedContact' value='$PreferedContact'></td>
									<td><input type='text' name='contactemail' value='$contactemail'></td>
									<td><input type='text' name='contactphone1' value='$contactphone1'></td>
									<td><input type='text' name='contactphone2' value='$contactphone2'></td>
									<td><input type='text' name='TypeOfWork' value='$TypeOfWork'></td>
									<td><input type='text' name='transporting' value='$transporting'></td>
									<td><input type='text' name='helptrap' value='$helptrap'></td>
									<td><input type='text' name='helpeducate' value='$helpeducate'></td>
									<td><input type='text' name='usingphone' value='$usingphone'></td>
									<td><input type='text' name='other' value='$other'></td>
									<td><input type='text' name='OtherTasks' value='$OtherTasks'></td>
									<td><input type='text' name='PastWorkExp' value='$PastWorkExp'></td>
									<td><input type='text' name='UnknownNameColumn' value='$UnknownNameColumn'></td>
									<td><input type='text' name='ResponseDate' value='$ResponseDate'></td>
									<td><input type='text' name='EmailResponse' value='$EmailResponse'></td>
									<td><input type='text' name='BEATId' value='$BEATId'></td>					
									<td><input type='text' name='BEATName' value='$BEATName'></td>
									<td><input type='text' name='BEATGeneralArea' value='$BEATGeneralArea'></td>
									<td><input type='text' name='BEATZipCodes' value='$BEATZipCodes'></td>
									<td><input type='text' name='BEATTrainDate' value='$BEATTrainDate'></td>
									<td><input type='text' name='BEATMembers' value='$BEATMembers'></td>
									<td><input type='text' name='BEATMembersPhone' value='$BEATMembersPhone'></td>
									<td><input type='text' name='BEATMemberEmails' value='$BEATMemberEmails'></td>
									<td><input type='text' name='BEATType' value='$BEATType'></td>
									<td><input type='text' name='BEATNotes' value='$BEATNotes'></td>
									<td><input type='text' name='BEATStatus' value='$BEATStatus'></td>					
									<td><input type='text' name='TriageBEATNotes' value='$TriageBEATNotes'></td>					
								</tr>
								";
								}
							}
							else
							{
								if($tdString != '')
								{
									$tdString = "";
									foreach ($_SESSION['volunteerselectedColumns'] as $selectedOption)
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
									<td><textarea value='$Comments' readonly>$Comments</textarea></td>
									<td>$VolunteerStatus</td>
									<td>$DateAndTime</td>
									<td>$WorkshopAttended</td>
									<td>$WorkshopDate</td>
									<td>$DateActivated</td>
									<td>$FullName</td>
									<td><textarea value='$Address' readonly>$Address</textarea></td>
									<td>$Email</td>
									<td>$Phone1</td>
									<td>$Phone2</td>
									<td>$PreferedContact</td>
									<td>$contactemail</td>
									<td>$contactphone1</td>
									<td>$contactphone2</td>
									<td>$TypeOfWork</td>
									<td>$transporting</td>
									<td>$helptrap</td>
									<td>$helpeducate</td>
									<td>$usingphone</td>
									<td>$other</td>
									<td><textarea value='$OtherTasks' readonly>$OtherTasks</textarea></td>
									<td><textarea value='$PastWorkExp' readonly>$PastWorkExp</textarea></td>
									<td>$UnknownNameColumn</td>
									<td>$ResponseDate</td>
									<td>$EmailResponse</td>
									<td>$BEATId</td>					
									<td>$BEATName</td>
									<td><textarea value='$BEATGeneralArea' readonly>$BEATGeneralArea</textarea></td>
									<td><textarea value='$BEATZipCodes' readonly>$BEATZipCodes</textarea></td>
									<td>$BEATTrainDate</td>
									<td>$BEATMembers</td>
									<td>$BEATMembersPhone</td>
									<td>$BEATMemberEmails</td>
									<td>$BEATType</td>
									<td><textarea value='$BEATNotes' readonly>$BEATNotes</textarea></td>
									<td>$BEATStatus</td>					
									<td><textarea value='$TriageBEATNotes' readonly>$TriageBEATNotes</textarea></td>								
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
				$RecordNumber1 = $_POST['RecordNumber'];
				$Comments = $_POST['Comments'];
				$VolunteerStatus = $_POST['VolunteerStatus'];
				$DateAndTime = $_POST['DateAndTime'];
				$WorkshopAttended = $_POST['WorkshopAttended'];
				$WorkshopDate = $_POST['WorkshopDate'];
				$DateActivated = $_POST['DateActivated'];
				$FullName = $_POST['FullName'];
				$Address = $_POST['Address'];
				$Email = $_POST['Email'];
				$Phone1 = $_POST['Phone1'];
				$Phone2 = $_POST['Phone2'];
				$PreferedContact = $_POST['PreferedContact'];
				$contactemail = $_POST['contactemail'];
				$contactphone1 = $_POST['contactphone1'];
				$contactphone2 = $_POST['contactphone2'];
				$TypeOfWork = $_POST['TypeOfWork'];
				$transporting = $_POST['transporting'];
				$helptrap = $_POST['helptrap'];
				$helpeducate = $_POST['helpeducate'];
				$usingphone = $_POST['usingphone'];
				$helpclinic = $_POST['helpclinic'];
				$other = $_POST['other'];					
				$OtherTasks = $_POST['OtherTasks'];
				$PastWorkExp = $_POST['PastWorkExp'];						
				$UnknownNameColumn = $_POST['UnknownNameColumn'];
				$ResponseDate = $_POST['ResponseDate'];
				$EmailResponse = $_POST['EmailResponse'];
				$BEATId = $_POST['BEATId'];
				$BEATName = $_POST['BEATName'];
				$BEATGeneralArea = $_POST['BEATGeneralArea'];
				$BEATZipCodes = $_POST['BEATZipCodes'];
				$BEATTrainDate = $_POST['BEATTrainDate'];
				$BEATMembers = $_POST['BEATMembers'];
				$BEATMembersPhone = $_POST['BEATMembersPhone'];
				$BEATMemberEmails = $_POST['BEATMemberEmails'];
				$BEATType = $_POST['BEATType'];
				$BEATNotes = $_POST['BEATNotes'];
				$BEATStatus = $_POST['BEATStatus'];
				$TriageBEATNotes = $_POST['TriageBEATNotes'];
				$WorkshopAttended = $_POST['WorkshopAttended'];
				$WorkshopDate = $_POST['WorkshopDate'];

				$reName = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
				if(true) //preg_match($reName, $FullName) &&
				{
					//print  "count is : ".count($_GET['select2']);
					//print_r($_GET['select2']);
					if(count($_SESSION['volunteerselectedColumns']) !=0 )
					{
						/* Build $query*/						
						$query = "select * from VolunteerForm where ";

						foreach($_SESSION['volunteerselectedColumns'] as $selectedItem)
						{
							$query.=$selectedItem." ='".$$selectedItem."'";
							$query.=" and ";
						}
						$query=rtrim($query," and ");

						//print $query;
						$result = mysqli_query($link, $query);

						if(mysqli_num_rows($result) == 0)
						{
							$queryupdate = " update VolunteerForm set ";

							if(count($_SESSION['volunteerselectedColumns'] == 0))
							{
								//print "hi?";
							}

							foreach($_SESSION['volunteerselectedColumns'] as $selectedItem)
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
						$query = "select * from VolunteerForm where RecordNumber='$RecordNumber1' order by RecordNumber desc";
						$result = mysqli_query($link, $query);	
						if(mysqli_num_rows($result) == 1)//if query does nothing, then update
						{						
							//$queryupdate = "update VolunteerForm set Comments='$Comments', VolunteerStatus='$VolunteerStatus'where RecordNumber='$RecordNumber1'";
							$queryupdate = "update VolunteerForm set 
								 Comments='$Comments', 
								 VolunteerStatus='$VolunteerStatus', 
								 DateAndTime='$DateAndTime', 								 
								 FullName='$FullName', 
								 Address='$Address', 
								 Email='$Email', 
								 Phone1='$Phone1', 
								 Phone2='$Phone2', 
								 PreferedContact='$PreferedContact', 
								 contactemail='$contactemail', 
								 contactphone1='$contactphone1', 
								 contactphone2='$contactphone2', 
								 TypeOfWork='$TypeOfWork', 
								 transporting='$transporting', 
								 helptrap='$helptrap', 
								 helpeducate='$helpeducate', 
								 usingphone='$usingphone', 
								 helpingclinic='$helpingclinic', 
								 other='$other', 
								 OtherTasks='$OtherTasks', 
								 PastWorkExp='$PastWorkExp', 
								 UnknownNameColumn='$UnknownNameColumn', 
								 ResponseDate='$ResponseDate', 
								 EmailResponse='$EmailResponse', 
								 BEATId='$BEATId', 
								 BEATName='$BEATName', 
								 BEATGeneralArea='$BEATGeneralArea', 
								 BEATZipCodes='$BEATZipCodes', 
								 BEATTrainDate='$BEATTrainDate', 
								 BEATMembers='$BEATMembers', 
								 BEATMembersPhone='$BEATMembersPhone', 
								 BEATMemberEmails='$BEATMemberEmails', 
								 BEATType='$BEATType', 
								 BEATNotes='$BEATNotes', 
								 BEATStatus='$BEATStatus', 
								 TriageBEATNotes='$TriageBEATNotes',
								 DateActivated='$DateActivated',
								 WorkshopAttended='$WorkshopAttended',
								 WorkshopDate='$WorkshopDate'
								 where RecordNumber='$RecordNumber1'";
								 
							mysqli_query($link, $queryupdate);
							print "<span id='recupdate'><h2>Record was updated</h2></span>";
						}else{
							print "<h2>Not updated</h2>";
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
				$query = "delete from VolunteerForm where RecordNumber='$RecordNumber'";
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

			if(isset($_SESSION['volunteerquerysearch'])){
				//query search
				$s = mysqli_query($link, $_SESSION['volunteerquerysearch']." order by $sort desc");
				if (mysqli_num_rows($s)!=0)
					$result = $s;
			}
			else{
				//regular search
				$query = "select * from VolunteerForm order by $sort desc";
				$result = mysqli_query($link, $query);
			}
			$_SESSION['volunteertotalrecords']=mysqli_num_rows($result);
			
			if(!isset($_GET['editrow']))
			{
			//if edit is not set

			// print table (happens first before input)

				if(isset($_SESSION['volunteerquerysearch'])) $q="QUERY: "; else $q="";
				// first print row of links/headers that sort
				print "
				<span id='querymsg'><h5>".$q.$_SESSION['volunteerquerysearch']."</h5></span>
				<div class='row'>
				<div class='col-sm-12'>
				<b>Volunteers</b>
				<div class='row' style='float: right'>
					<div class='col-xs-12 col-sm-12 col-md-12' style='text-align:right; padding-right:5px;'>
						<input class='btn btn-default' type='button' value='Reset' name='RefreshTable' onclick=\"location.href='volunteerlist.php?RefreshTable=Reset'\"/>
						<input class='btn btn-success' type='button' id='exportButton' onclick=\"tableToExcel('volunteerTable', 'Volunteers')\" value='Export' />
					</div>
				</div>
			
				<table id='volunteerTable' class='table table-striped table-bordered table-condensed'>
					<thead>
						<tr>";
							if($thString != '')
								{
									print $thString;
									print"</tr>";
									//print"(editRow not set header)";
								}
								else
								{
									print "
								<th><a href='volunteerlist.php?sort=RecordNumber'>ID</a></th>
								<th><a href='volunteerlist.php?sort=Comments'>Triage Comments</a></th>
								<th><a href='volunteerlist.php?sort=VolunteerStatus'>Volunteer Status</a></th>
								<th><a href='volunteerlist.php?sort=DateAndTime'>Date Submitted</a></th>
								<th><a href='volunteerlist.php?sort=WorkshopAttended'>Workshop</a></th>
								<th><a href='volunteerlist.php?sort=WorkshopDate'>Workshop Date</a></th>
								<th><a href='volunteerlist.php?sort=DateActivated'>Date Actived</a></th>
								<th><a href='volunteerlist.php?sort=FullName'>Full Name</a></th>
								<th><a href='volunteerlist.php?sort=Address'>Complete Address</a></th>
								<th><a href='volunteerlist.php?sort=Email'>Email</a></th>
								<th><a href='volunteerlist.php?sort=Phone1'>Phone1</a></th>
								<th><a href='volunteerlist.php?sort=Phone2'>Phone2</a></th>
								<th><a href='volunteerlist.php?sort=PreferedContact'>Prefered Contact</a></th>
								<th><a href='volunteerlist.php?sort=contactemail'>Prefered Email</a></th>
								<th><a href='volunteerlist.php?sort=contactphone1'>Prefered Phone1</a></th>
								<th><a href='volunteerlist.php?sort=contactphone2'>Prefered Phone2</a></th>
								<th><a href='volunteerlist.php?sort=TypeOfWork'>Type Of Work</a></th>
								<th><a href='volunteerlist.php?sort=transporting'>Transporter</a></th>
								<th><a href='volunteerlist.php?sort=helptrap'>Trapper</a></th>
								<th><a href='volunteerlist.php?sort=helpeducate'>Educator</a></th>
								<th><a href='volunteerlist.php?sort=usingphone'>Triage</a></th>
								<th><a href='volunteerlist.php?sort=other'>Other</a></th>
								<th><a href='volunteerlist.php?sort=OtherTasks'>Other Tasks Details</a></th>
								<th><a href='volunteerlist.php?sort=PastWorkExp'>Past Experience</a></th>
								<th><a href='volunteerlist.php?sort=UnknownNameColumn'>Unknown</a></th>
								<th><a href='volunteerlist.php?sort=ResponseDate'>Response Date</a></th>
								<th><a href='volunteerlist.php?sort=EmailResponse'>Email Response</a></th>
								<th><a href='volunteerlist.php?sort=BEATId'>BEAT ID</a></th>					
								<th><a href='volunteerlist.php?sort=BEATName'>BEAT Name</a></th>
								<th><a href='volunteerlist.php?sort=BEATGeneralArea'>BEAT Gen. Area</a></th>
								<th><a href='volunteerlist.php?sort=BEATZipCodes'>BEAT Zip Code</a></th>
								<th><a href='volunteerlist.php?sort=BEATTrainDate'>BEAT Train Date</a></th>
								<th><a href='volunteerlist.php?sort=BEATMembers'>BEAT Member</a></th>
								<th><a href='volunteerlist.php?sort=BEATMembersPhone'>BEAT Member Phone</a></th>
								<th><a href='volunteerlist.php?sort=BEATMemberEmails'>BEAT Member Email</a></th>
								<th><a href='volunteerlist.php?sort=BEATType'>BEAT Type</a></th>
								<th><a href='volunteerlist.php?sort=BEATNotes'>BEAT Notes</a></th>
								<th><a href='volunteerlist.php?sort=BEATStatus'>BEAT Status</a></th>					
								<th><a href='volunteerlist.php?sort=TriageBEATNotes'>BEAT Triage Notes</a></th>								
						</tr>";
								}
					print"
					</thead>
					<tbody>";

					//while the next row (set by query) exists?
					while($row = mysqli_fetch_row($result))
					{
						list($RecordNumber, $Comments, $VolunteerStatus, $DateAndTime, $FullName, $Address, $Email, $Phone1, $Phone2, $PreferedContact, $contactemail, $contactphone1, $contactphone2, $TypeOfWork, $transporting, $helptrap, $helpeducate, $usingphone, $helpingclinic, $other, $OtherTasks, $PastWorkExp, $UnknownNameColumn, $ResponseDate, $EmailResponse, $BEATId, $BEATName, $BEATGeneralArea, $BEATZipCodes, $BEATTrainDate, $BEATMembers, $BEATMembersPhone, $BEATMemberEmails, $BEATType, $BEATNotes, $BEATStatus, $TriageBEATNotes, $DateActivated, $WorkshopAttended, $WorkshopDate) = $row; // then printed in one table row // variables are set to current row 

						$myArray[0]=$RecordNumber;
						$myArray[1]=$Comments;
						$myArray[2]=$VolunteerStatus;
						$myArray[3]=$DateAndTime;
						$myArray[4]=$FullName;
						$myArray[5]=$Email;
						$myArray[6]=$Phone1;
						$myArray[7]=$Phone2;
						$myArray[8]=$PreferedContact;
						$myArray[9]=$contactemail;
						$myArray[10]=$contactphone1;
						$myArray[11]=$contactphone2;
						$myArray[12]=$TypeOfWork;
						$myArray[13]=$transporting;
						$myArray[14]=$helptrap;
						$myArray[15]=$helpeducate;
						$myArray[16]=$usingphone;
						$myArray[17]=$helpingclinic;
						$myArray[18]=$other;
						$myArray[19]=$OtherTasks;
						$myArray[20]=$PastWorkExp;
						$myArray[21]=$UnknownNameColumn;
						$myArray[22]=$ResponseDate;
						$myArray[23]=$EmailResponse;
						$myArray[24]=$BEATId;
						$myArray[25]=$BEATName;
						$myArray[26]=$BEATGeneralArea;
						$myArray[27]=$BEATZipCodes;
						$myArray[28]=$BEATTrainDate;
						$myArray[29]=$BEATMembers;
						$myArray[30]=$BEATMembersPhone;
						$myArray[31]=$BEATMemberEmails;
						$myArray[32]=$BEATType;
						$myArray[33]=$BEATNotes;
						$myArray[34]=$BEATStatus;
						$myArray[35]=$TriageBEATNotes;
						$myArray[36]=$DateActivated;
						$myArray[37]=$WorkshopAttended;
						$myArray[38]=$WorkshopDate;

						$myArray[0]="RecordNumber";
						$myArray[1]="Comments";
						$myArray[2]="VolunteerStatus";
						$myArray[3]="DateAndTime";
						$myArray[4]="FullName";
						$myArray[5]="Email";
						$myArray[6]="Phone1";
						$myArray[7]="Phone2";
						$myArray[8]="PreferedContact";
						$myArray[9]="contactemail";
						$myArray[10]="contactphone1";
						$myArray[11]="contactphone2";
						$myArray[12]="TypeOfWork";
						$myArray[13]="transporting";
						$myArray[14]="helptrap";
						$myArray[15]="helpeducate";
						$myArray[16]="usingphone";
						$myArray[17]="helpingclinic";
						$myArray[18]="other";
						$myArray[19]="OtherTasks";
						$myArray[20]="PastWorkExp";
						$myArray[21]="UnknownNameColumn";
						$myArray[22]="ResponseDate";
						$myArray[23]="EmailResponse";
						$myArray[24]="BEATId";
						$myArray[25]="BEATName";
						$myArray[26]="BEATGeneralArea";
						$myArray[27]="BEATZipCodes";
						$myArray[28]="BEATTrainDate";
						$myArray[29]="BEATMembers";
						$myArray[30]="BEATMembersPhone";
						$myArray[31]="BEATMemberEmails";
						$myArray[32]="BEATType";
						$myArray[33]="BEATNotes";
						$myArray[34]="BEATStatus";
						$myArray[35]="TriageBEATNotes";
						$myArray[36]="DateActivated";
						$myArray[37]="WorkshopAttended";
						$myArray[38]="WorkshopDate";

							//$_GET['select2'] as RecordNumber
							foreach ($_SESSION['volunteerselectedColumns'] as $selectedOption)//only once every time.. record number
							{
								for ($i = 0; $i<39; $i++)
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
									foreach ($_SESSION['volunteerselectedColumns'] as $selectedOption)
									{
										switch($selectedOption){
											case 'DateAndTime': $tdString.="<td id='dateTimeCol'>".$$selectedOption."</td>"; break;
											case 'CompleteAddress': $tdString.="<td id='addressCol'>".$$selectedOption."</td>"; break;
											case 'Comments': $tdString.="<td><textarea class='form-control' name='Comments' value='$Comments' rows='3' readonly>$Comments</textarea></td>"; break;
											case 'Address': $tdString.="<td><textarea class='form-control' name='Address' value='$Address' rows='3' readonly>$Address</textarea></td>"; break;
											case 'OtherTasks': $tdString.="<td><textarea class='form-control' name='OtherTasks' value='$OtherTasks' rows='3' readonly>$OtherTasks</textarea></td>"; break;
											case 'PastWorkExp': $tdString.="<td><textarea class='form-control' name='PastWorkExp' value='$PastWorkExp' rows='3' readonly>$PastWorkExp</textarea></td>"; break;
											case 'BEATGeneralArea': $tdString.="<td><textarea class='form-control' name='BEATGeneralArea' value='$BEATGeneralArea' rows='3' readonly>$BEATGeneralArea</textarea></td>"; break;
											case 'BEATZipCodes':$tdString.="<td><textarea class='form-control' name='BEATZipCodes' value='$BEATZipCodes' rows='3' readonly>$BEATZipCodes</textarea></td>"; break;
											case 'BEATNotes': $tdString.="<td><textarea class='form-control' name='BEATZipCodes' value='$BEATNotes' rows='3' readonly>$BEATNotes</textarea></td>"; break;
											case 'TriageBEATNotes': $tdString.="<td><textarea class='form-control' name='TriageBEATNotes' value='$TriageBEATNotes' rows='3' readonly>$TriageBEATNotes</textarea></td>"; break;									
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
									<td><textarea class='form-control' name='Comments' value='$Comments' rows='3' readonly>$Comments</textarea></td>
									<td>$VolunteerStatus</td>
									<td>$DateAndTime</td>
									<td>$WorkshopAttended</td>
									<td>$WorkshopDate</td>
									<td>$DateActivated</td>
									<td>$FullName</td>
									<td><textarea class='form-control' name='Address' value='$Address' rows='3' readonly>$Address</textarea></td>
									<td>$Email</td>
									<td>$Phone1</td>
									<td>$Phone2</td>
									<td>$PreferedContact</td>
									<td>$contactemail</td>
									<td>$contactphone1</td>
									<td>$contactphone2</td>
									<td>$TypeOfWork</td>
									<td>$transporting</td>
									<td>$helptrap</td>
									<td>$helpeducate</td>
									<td>$usingphone</td>
									<td>$other</td>
									<td><textarea class='form-control' name='OtherTasks' value='$OtherTasks' rows='3' readonly>$OtherTasks</textarea></td>
									<td><textarea class='form-control' name='PastWorkExp' value='$PastWorkExp' rows='3' readonly>$PastWorkExp</textarea></td>
									<td>$UnknownNameColumn</td>
									<td>$ResponseDate</td>
									<td>$EmailResponse</td>
									<td>$BEATId</td>					
									<td>$BEATName</td>
									<td><textarea class='form-control' name='BEATGeneralArea' value='$BEATGeneralArea' rows='3' readonly>$BEATGeneralArea</textarea></td>
									<td><textarea class='form-control' name='BEATZipCodes' value='$BEATZipCodes' rows='3' readonly>$BEATZipCodes</textarea></td>
									<td>$BEATTrainDate</td>
									<td>$BEATMembers</td>
									<td>$BEATMembersPhone</td>
									<td>$BEATMemberEmails</td>
									<td>$BEATType</td>
									<td><textarea class='form-control' name='BEATZipCodes' value='$BEATNotes' rows='3' readonly>$BEATNotes</textarea></td>
									<td>$BEATStatus</td>					
									<td><textarea class='form-control' name='TriageBEATNotes' value='$TriageBEATNotes' rows='3' readonly>$TriageBEATNotes</textarea></td>
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
		else if($level == 0)
		{
			print "you aren't supposed to be here.. STOP SNEAKING AROUND";
		}
	}
?>

   		<form id="resettable" method='get' action='volunteerlist.php'>
			<input class='btn btn-default' type='submit' value='Reset' name='RefreshTable'/>
			<input class='btn btn-success' type='button' id='exportButton' onclick="tableToExcel('volunteerTable', 'Volunteers')" value='Export' />
			<span id="ttlrecs"><b>Total Records: <?php echo $_SESSION['volunteertotalrecords']; ?></b></span>
		</form>
		</div> <!-- end div class='col-sm'12' -->
		</div> <!-- end div class='row' -->
		</div> <!-- end maindiv -->
	</body>
</html>

