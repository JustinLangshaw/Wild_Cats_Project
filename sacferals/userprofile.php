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
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="userprofile.js"></script>

</head>

<body class="main_body">
<?php

	//if no ones logged in, print login screen
	if($_SESSION['authenticate234252432341'] != 'validuser09821')
	{ 
		//print "<a href='createaccount.php'>Create Account</a>";

		print "<div class='main_login' style='margin-top:20px'>
				<div class='page-wrap'>
					<div class='main'>
         				<div class='main_container'>
            				<h1 class='main_heading'>Log in</h1>
							<form class='form' role='form' method='post' action='userprofile.php'>
								<fieldset class='form_field'>
    								<label class='form_label required'>Username</label>
									<input type='username' class='form_input' placeholder='Enter your username or email' 
														required='required' name='username' value=''>
								</fieldset>

  								<fieldset class='form_field'>
  									<label class='form_label required'>Password</label>
  										<input type='password' class='form_input' name='pass' id='password_field' 
  														required='required' placeholder='Enter your password'>
  								</fieldset>

  								<button type='submit' class='button' name='login' style='background-color: #BE1D2C'>
    				 				<div class='button_label'>Log in</div>
  								</button>

  								<div class='main_heading-2'>
    								<a href='createaccount.php'>Create Account</a>
  								</div>
							</form>
          				</div>
        			</div>
    			</div>
			</div>";
	}
	//once you're logged in, show menu/options
	else 
	{
		$Ausername = $_SESSION['Ausername'];
		$level = $_SESSION['level'];
		
		if($level == 1)
		{
			print "<div align='right'><div class='dropdown'><button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'><img src='menu_icon.png' width='20' height='20'><span class='caret'></span></button><ul class='dropdown-menu dropdown-menu-right'><li><a href='https://www.catstats.org/' target='_blank'>CatStats Website</a></li><li><a href='#'>Update Profile</a></li><li><a href='./logout.php'>Sign Out</a></li></ul></div></div>";




			print "<a href='logout.php' align='right'>Log out</a><br><br>";
			print "<b>Welcome Master Administrator ".$Ausername."!</b> <br><br>";
			print "<div><fieldset class='fieldset-auto-width'>";
			print "- <a href='search.php' align='right'>View/Edit Database</a><br>";
			print "- <a href='changeaccounttype.php' align='right'>Change User Account Types</a><br>";
			print "- <a href='volunteerlist.php' align='right'>View Volunteers</a><br>";
			
			
			print "<br><a href='volunteerform.php' align='right' target='blank' >volunteer form</a> for testing purposes<br>";
			print "<a href='reportform.php' align='right' target='blank1' >report form</a> for testing purposes<br>";
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
			
			
			
			print "(job tables will appear in upcoming build)<br><br>";
		}

		
	}
?>

</body>
</html>