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
	<title>View Volunteers</title> 
	<link rel="stylesheet" type="text/css" href="search.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    	<script src="searchScript.js"></script> 
	
</head>

<body>
<?php

	//if no ones logged in, print login screen
	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{ 
		
		print "<form method='post' action='volunteerlist.php'>
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
					
			$sort = $_GET['sort']; //'sort' is magic sorting variable
			if(!isset($sort))
			{
				$sort = "RecordNumber";
			}

			$query = "select * from VolunteerForm order by $sort";
			$result = mysqli_query($link, $query);

			// print table (happens first before input)

				// first print row of links/headers that sort
				print "
				<br><b>Volunteers</b><br><br>
				
				<table>
					<thead>
						<tr>
							<th><a href='volunteerlist.php?sort=RecordNumber'>Record_Number</a></th>
							<th><a href='volunteerlist.php?sort=DateAndTime'>Date_And_Time</a></th>
							<th><a href='volunteerlist.php?sort=FullName'>Full_Name</a></th>
							<th><a href='volunteerlist.php?sort=CompleteAddress'>Complete_Address</a></th>
							<th><a href='volunteerlist.php?sort=Email'>Email</a></th>
							<th><a href='volunteerlist.php?sort=Phone1'>Phone_1</a></th>
							<th><a href='volunteerlist.php?sort=Phone2'>Phone_2</a></th>
							<th><a href='volunteerlist.php?sort=PreferedContact'>Prefered_Contact</a></th>
							<th><a href='volunteerlist.php?sort=TypeOfWork'>Type_Of_Work</a></th>
							<th><a href='volunteerlist.php?sort=OtherTasks'>Other_Tasks</a></th>
							<th><a href='volunteerlist.php?sort=PastWorkExp'>Past_Work_Experience</a></th>
							<th>Volunteer Job Status</th> 
							<th> </th>
						</tr>
					</thead>
					
					<tbody>";
					
					//figure out how to make colspan="2" work on the last column with the current css table settings
					
					
					//while the next row (set by query) exists?
					while($row = mysqli_fetch_row($result))
					{
						list($RecordNumber, $DateAndTime, $FullName, $CompleteAddress, $Email, $Phone1, $Phone2, $PreferedContact, $contactEmail, $contactphone1, $contactphone2, $TypeOfWork, $transporting, $helptrap, $helpeducate, $usingphone, $helpingclinic, $Other, $OtherTasks, $PastWorkExp, $UnknownNameColumn, $ResponseDate, $EmailResponses) = $row; // variables are set to current row
																		// then printed in one table row
						print "
						<tr>
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
							<td> <ul style='list-style-type:disc'>
								  <li>job 1</li>
								  <li>job 2</li>
								</ul>
							<td><a href='volunteerlist.php'>Add_Job</a><br><a href='volunteerlist.php'>Delete_Job</a><br>(links do nothing now)</td>
						</tr>
						";
					}
					print "
					</tbody>
				</table>";	
				
				
		}
		else if($level == 2)
		{
			print "you aren't supposed to be here.. STOP SNEAKING AROUND";
		}

		
	}
?>

</body>
</html>
