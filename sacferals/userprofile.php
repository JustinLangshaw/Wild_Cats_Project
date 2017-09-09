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
	<title>User Profile</title> 
	
	<link rel="stylesheet" type="text/css" href="userprofile.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="userprofile.js"></script>
	<!--<style type="text/css">
    .fieldset-auto-width 
	{
         display: inline-block;
    }
	</style>-->

</head>

<body>
<?php

	//if no ones logged in, print login screen
	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{ 
		print "<a href='createaccount.php'>Create Account</a>";

		print "<form method='post' action='userprofile.php'>
		<div><fieldset class='fieldset-auto-width'>
		<legend>Login</legend>
		<label><input type='text' name='username'>User Name</label><br>
		<label><input type='password' name='pass'>Password</label><br>
		<label><input type='submit' name='login' value='Login'></label>
		</fieldset></div>
		</form>
		
		<h3>Level 1 access (admin): Guest1, 123</h3>
		<h3>Level 2 access (pleb): VeryLeetName2, 123</h3>";
	}
	//once you're logged in, show menu/options
	else 
	{
		$Ausername = $_SESSION['Ausername'];
		$level = $_SESSION['level'];
		
		if($level == 1)
		{
			print "<a href='logout.php' align='right'>Log out</a><br><br>";
			print "<b>Welcome Master Administrator ".$Ausername."!</b> <br><br>";
			print "<div><fieldset class='fieldset-auto-width'>";
			print "- <a href='search.php' align='right'>View/Edit Database</a><br>";
			print "- <a href='changeaccounttype.php' align='right'>Change User Account Types</a><br>";
			print "- <a href='volunteerlist.php' align='right'>View Volunteers</a><br>";
			
			
			print "<br><a href='volunteerform.php' align='right'>volunteer form</a> for testing purposes<br>";
			print "<a href='reportform.php' align='right'>report form</a> for testing purposes<br>";
			print "</fieldset></div>";
		}
		else if($level == 2)
		{
			print "<h3 align='right'>Logged in as $Ausername </h3>";
			
			print "<a href='logout.php' style='float: right;'>Log out</a><br><br>";
			
			print "<b><u>Jobs volunteered for:</u></b>";
			
			$query = "select email from SacFeralsUsers where username = '".$Ausername."'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($email) = $row;
		
			$query = "select transporting, helptrap, helpeducate, usingphone, helpingclinic, OtherTasks from VolunteerForm where email = '".$email."'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_row($result);
			list($transporting, $helptrap, $helpeducate, $usingphone, $helpingclinic, $OtherTasks) = $row;
			//print $transporting." ".$helptrap." ".$helpeducate." ".$usingphone." ".$helpingclinic." ".$OtherTasks;
			
			
			print "<ul>";
				if($transporting==1)
						print " <li>Transporting </li>";
				if($helptrap==1)
						print " <li>Help Trapping </li>";
				if($helpeducate==1)
					print " <li>Help Educate </li>";
				if($usingphone==1)
					print " <li>Using Phone </li>";
				if($helpingclinic==1)
					print " <li>Helping Clinic </li>";
				if($OtherTasks!="")
					print " <li>".$OtherTasks." </li>";
			print "</ul>";
			
			print "<b>Availability</b> (toggle a cell you are available on to turn it green)<br><br>";
			?>
			  <table id="sales-list">
				  <tr>
					<td class="white"></td>
					<td class="white">Sunday</td>
					<td class="white">Monday</td>
					<td class="white">Tuesday</td>
					<td class="white">Wednesday</td>
					<td class="white">Thursday</td>
					<td class="white">Friday</td>
					<td class="white">Saturday</td>
				  </tr>
				  <tr>
					 <td class="white">7:00am</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">8:00am</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">9:00am</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">10:00am</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">11:00am</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">12:00pm</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">1:00pm</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">2:00pm</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">3:00pm</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">4:00pm</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">5:00pm</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">6:00pm</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">7:00pm</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">8:00pm</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				  <tr>
					 <td class="white">9:00pm</td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
					 <td class="white"> </td>
				  </tr>
				</table>
			<?php
			
			print "<br><br>(availability table will appear in upcoming build)<br><br>";
			
			print "(job tables will appear in upcoming build)<br><br>";
		}

		
	}
?>

</body>
</html>