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
		<title>Volunteer</title>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="https://unpkg.com/ng-table@2.0.2/bundles/ng-table.min.css">
		<link rel="stylesheet" href="css/search.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.2/angular.js"></script>
		<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="https://unpkg.com/ng-table@2.0.2/bundles/ng-table.min.js"></script>
       	
       	<script src="js/exportExcel.js?version=1.5"></script>
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
			<form id='form1' name='form1' method='get' action='volunteerlist.php'>
				<select class="input-sm" name='select2[]' size='7' multiple='multiple' tabindex='1'>
					<option value='RecordNumber'>ID</option>
					<option value='DateAndTime'>Date And Time</option>
					<option value='FullName'>Full Name</option>
					<option value='CompleteAddress'>Complete Address</option>
					<option value='Email'>Email</option>
					<option value='Phone1'>Phone1</option>
					<option value='Phone2'>Phone2</option>
					<option value='PreferedContact'>Prefered Contact</option>
					<option value='TypeOfWork'>Type Of Work</option>
					<option value='OtherTasks'>Other Tasks</option>
					<option value='PastWorkExp'>Past Work Exp</option>
					<option value='JobStatus'>Job Status</option>
					<option value='Jobs'>Jobs</option>
				</select>
				<br>
				<input class="btn btn-primary" type='submit' name='Submit' value='Submit' tabindex='2' />
				<input class="btn" type='submit' name='Select All' value='Reset'/>
			</form>
		</div>
		<div class="col-md-8">
			<form id="queryform" method='get' action='volunteerlist.php'>
			<!-- Custom Query -->
			<div class="row">
				<b>Custom Query</b>
			</div>
			<div class="row" id="cqrow">
				<div id="blueprint">
					<select class="input-sm" id="query" name="query[]" tabindex='3'>
						<option value='RecordNumber'>ID</option>
						<option value='DateAndTime'>Date And Time</option>
						<option value='FullName'>Full Name</option>
						<option value='CompleteAddress'>Complete Address</option>
						<option value='Email'>Email</option>
						<option value='Phone1'>Phone1</option>
						<option value='Phone2'>Phone2</option>
						<option value='PreferedContact'>Prefered Contact</option>
						<option value='TypeOfWork'>Type Of Work</option>
						<option value='OtherTasks'>Other Tasks</option>
						<option value='PastWorkExp'>Past Work Exp</option>
						<option value='JobStatus'>Job Status</option>
						<option value='Jobs'>Jobs</option>
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
				$thString.="<th><a href='volunteerlist.php?sort=".$selectedOption."'>".$printvalue."</a></th>";
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
				$value = $_GET['queryvalue'][0];
				if($value!=NULL) {
					$search = "select * from VolunteerForm where ";
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
				$query = "select * from VolunteerForm  where RecordNumber = ".$RecordNumber1."";
				$result = mysqli_query($link, $query);
				$row = mysqli_fetch_row($result);
				list($RecordNumber, $DateAndTime, $FullName, $CompleteAddress, $Email, $Phone1, $Phone2, $PreferedContact, 
					$contactEmail, $contactphone1, $contactphone2, $TypeOfWork, $transporting, $helptrap, $helpeducate, 
					$usingphone, $helpingclinic, $Other, $OtherTasks, $PastWorkExp, $UnknownNameColumn, $ResponseDate, 
					$EmailResponses) = $row; // variables are set to current row

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
					$query = "select * from VolunteerForm order by $sort";
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
					<form method='post' action='volunteerlist.php'>

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
								<th><a href='volunteerlist.php?sort=RecordNumber'>ID</a></th>
								<th><a href='volunteerlist.php?sort=DateAndTime'>Time_Stamp</a></th>
								<th><a href='volunteerlist.php?sort=FullName'>Full_Name</a></th>
								<th><a href='volunteerlist.php?sort=CompleteAddress'>Complete_Address</a></th>
								<th><a href='volunteerlist.php?sort=Email'>Email</a></th>
								<th><a href='volunteerlist.php?sort=Phone1'>Phone1</a></th>
								<th><a href='volunteerlist.php?sort=Phone2'>Phone2</a></th>
								<th><a href='volunteerlist.php?sort=PreferedContact'>Prefered_Contact</a></th>
								<th><a href='volunteerlist.php?sort=TypeOfWork'>Type_Of_Work</a></th>
								<th><a href='volunteerlist.php?sort=OtherTasks'>Other_Tasks</a></th>
								<th><a href='volunteerlist.php?sort=PastWorkExp'>Past_Work_Exp</a></th>
								<th>Job_Status</th>
								<th>Jobs</th>
							</tr>
						</thead>
						";
							}

						print "<tbody>";

						//while the next row (set by query) exists?



						while($row = mysqli_fetch_row($result))
						{
							list($RecordNumber, $DateAndTime, $FullName, $CompleteAddress, $Email, $Phone1, $Phone2, 
							$PreferedContact, $contactEmail, $contactphone1, $contactphone2, $TypeOfWork, $transporting, 
							$helptrap, $helpeducate, $usingphone, $helpingclinic, $Other, $OtherTasks, $PastWorkExp, 
							$UnknownNameColumn, $ResponseDate, $EmailResponses) = $row; // variables are set to current row
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
									<td><input type='hidden' name='RecordNumber' value='$RecordNumber'>$RecordNumber</td>
									<td><input type='hidden' name='DateAndTime' value='$DateAndTimes'>$DateAndTime</td>
									<td><input type='text' name='FullName' value='$FullName'></td>
									<td><input type='text' name='CompleteAddress' value='$CompleteAddress'></td>
									<td><input type='text' name='Email' value='$Email'></td>
									<td><input type='text' name='Phone1' value='$Phone1'></td>
									<td><input type='text' name='Phone2' value='$Phone2'></td>
									<td><input type='text' name='PreferedContact' value='$PreferedContact'></td>
									<td><textarea name='TypeOfWork' value='$TypeOfWork'>$TypeOfWork</textarea></td>
									<td><textarea name='OtherTasks' value='$OtherTasks'>$OtherTasks</textarea></td>
									<td><textarea name='PastWorkExp' value='$PastWorkExp'>$PastWorkExp</textarea></td>
									<td><input type='text' name='' value=''></td>
									<td><input type='text' name='' value=''></td>
								</tr>
								";
								}
							}
							else
							{
								print "
								<td><a style='background-color:lightgreen;' href='volunteerlist.php?editrow=yes&RecordNumber=$RecordNumber'>Edit</a> 
									<a style='background-color:#ff8080;' href='volunteerlist.php?del=yes&RecordNumber=$RecordNumber'  class='confirmation'>Delete</a> 
									<a style = 'background-color:#00ffff;' href='form_view.php' target = '_blank'>Form_View </a> 
								</td>
								
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
									<td>$DateAndTime</td>
									<td>$FullName</td>
									<td>$CompleteAddress</td>
									<td>$Email</td>
									<td>$Phone1</td>
									<td>$Phone2</td>
									<td>$PreferedContact</td>
									<td>$TypeOfWork</td>
									<td>$OtherTasks</td>
									<td>$PastWorkExp</td>
									<td></td>
									<td><ul style='list-style-type:disc'>
										  <li>job 1</li>
										  <li>job 2</li>
										</ul>
									</td>
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
				$DateAndTime = $_POST['DateAndTime'];
				$FullName = $_POST['FullName'];
				$CompleteAddress = $_POST['CompleteAddress'];
				$contactEmail = $_POST['Email'];
				$contactphone1 = $_POST['Phone1'];
				$contactphone2 = $_POST['Phone2'];
				$PreferedContact = $_POST['PreferedContact'];
				$TypeOfWork = $_POST['TypeOfWork'];
				$OtherTasks = $_POST['OtherTasks'];
				$PastWorkExp = $_POST['PastWorkExp'];

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

						$query = "select * from VolunteerForm where ";

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
							$queryupdate = " update VolunteerForm set ";

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


						$query = "select * from VolunteerForm where RecordNumber='$RecordNumber1'";
						$result = mysqli_query($link, $query);

						if(mysqli_num_rows($result) == 1)//if query does nothing, then update
						{
							$queryupdate = "update VolunteerForm set FullName='$FullName', Email='$Email',
								 Phone1='$Phone1', Phone2='$Phone2', ColonyAddress='$ColonyAddress',
								 City='$City', County='$County', ZipCode='$ZipCode', AnyoneAttempted='$AnyoneAttempted',
								 ApproximateCats='$ApproximateCats', Kittens='$Kittens', ColonyCareGiver='$ColonyCareGiver', FeederDescription='$FeederDescription',
								 Injured='$Injured', InjuryDescription='$InjuryDescription', FriendlyPet='$FriendlyPet', ColonySetting='$ColonySetting', Comments='$Comments',
								 VolunteerResponding='$VolunteerResponding', ResponseDate='$ResponseDate', CustNeedOutcome='$CustNeedOutcome',
								 BeatTeamLeader='$BeatTeamLeader', Outcome='$Outcome', CompletionDate='$CompletionDate', FeedIfReturned='$FeedIfReturned', ReqAssitance='$ReqAssitance' where RecordNumber='$RecordNumber1'";

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

			if(isset($_SESSION['querysearch'])){
				//query search
				$s = mysqli_query($link, $_SESSION['querysearch']);
				if (mysqli_num_rows($s)!=0)
					$result = $s;
			}
			else{
				//regular search
				$query = "select * from VolunteerForm order by $sort";
				$result = mysqli_query($link, $query);
			}
			$_SESSION['totalrecords']=mysqli_num_rows($result);
			
			if(!isset($_GET['editrow']))
			{
			//if edit is not set

			// print table (happens first before input)

				if(isset($_SESSION['querysearch'])) $q="QUERY: "; else $q="";
				// first print row of links/headers that sort
				print "
				<span id='querymsg'><h5>".$q.$_SESSION['querysearch']."</h5></span>
				<div class='row'>
				<div class='col-sm-12'>
				<b>Volunteers</b><br><br>
				
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

								<th><a href='volunteerlist.php?sort=RecordNumber'>ID</a></th>
								<th><a href='volunteerlist.php?sort=DateAndTime'>Time_Stamp</a></th>
								<th><a href='volunteerlist.php?sort=FullName'>Full_Name</a></th>
								<th><a href='volunteerlist.php?sort=CompleteAddress'>Complete_Address</a></th>
								<th><a href='volunteerlist.php?sort=Email'>Email</a></th>
								<th><a href='volunteerlist.php?sort=Phone1'>Phone1</a></th>
								<th><a href='volunteerlist.php?sort=Phone2'>Phone2</a></th>
								<th><a href='volunteerlist.php?sort=PreferedContact'>Prefered_Contact</a></th>
								<th><a href='volunteerlist.php?sort=TypeOfWork'>Type_Of_Work</a></th>
								<th><a href='volunteerlist.php?sort=OtherTasks'>Other_Tasks</a></th>
								<th><a href='volunteerlist.php?sort=PastWorkExp'>Past_Work_Exp</a></th>
								<th>Job_Status</th>
								<th>Jobs</th>
						</tr>";
								}
					print"
					</thead>
					<tbody>";

					//while the next row (set by query) exists?

					while($row = mysqli_fetch_row($result))
					{
						list($RecordNumber, $DateAndTime, $FullName, $CompleteAddress, $Email, $Phone1, $Phone2, 
							$PreferedContact, $contactEmail, $contactphone1, $contactphone2, $TypeOfWork, $transporting, 
							$helptrap, $helpeducate, $usingphone, $helpingclinic, $other, $OtherTasks, $PastWorkExp, 
							$UnknownNameColumn, $ResponseDate, $EmailResponses) = $row; // variables are set to current row // variables are set to current row
																		// then printed in one table row

						$myArray[0]=$RecordNumber;
						$myArray[1]=$DateAndTime;
						$myArray[2]=$FullName;
						$myArray[3]=$CompleteAddress;
						$myArray[4]=$Email;
						$myArray[5]=$Phone1;
						$myArray[6]=$Phone2;

						$myArray1[0]="RecordNumber";
						$myArray1[1]="DateAndTime";
						$myArray1[2]="FullName";
						$myArray1[3]="CompleteAddress";
						$myArray1[4]="Email";
						$myArray1[5]="Phone1";
						$myArray1[6]="Phone2";

						print "
						<tr>
							<td><a style='background-color:lightgreen;' href='volunteerlist.php?editrow=yes&RecordNumber=$RecordNumber'>Edit</a> 
								<a style='background-color:#ff8080;' href='volunteerlist.php?del=yes&RecordNumber=$RecordNumber'  class='confirmation'>Delete</a> 
								<a style = 'background-color:#00ffff;' href='form_view.php' target = '_blank'>Form_View </a> 
							</td>";

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
											case 'DateAndTime': $tdString.="<td = id='dateTimeCol'>".$$selectedOption."</td>"; break;
											case 'CompleteAddress': $tdString.="<td = id='addressCol'>".$$selectedOption."</td>"; break;
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
									<td>$DateAndTime</td>
									<td>$FullName</td>
									<td>$CompleteAddress</td>
									<td>$Email</td>
									<td>$Phone1</td>
									<td>$Phone2</td>
									<td>$PreferedContact</td>
									<td>$TypeOfWork</td>
									<td>$OtherTasks</td>
									<td>$PastWorkExp</td>
									<td></td>
									<td><ul style='list-style-type:disc'>
										  <li>job 1</li>
										  <li>job 2</li>
										</ul>
									</td>
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

   		<form id="resettable" method='get' action='volunteerlist.php'>
			<input class="btn" type="submit" value="Refresh" name="RefreshTable"/>
   			<input class="btn btn-success" type="button" id="exportButton" onclick="tableToExcel('reportTable', 'Reports')" value="Export" />
			<span id="ttlrecs">Total Records: <?php echo $_SESSION['totalrecords']; ?></span>
		</form>
		</div> <!-- end div class='col-sm'12' -->
		</div> <!-- end div class='row' -->
	</body>
</html>

