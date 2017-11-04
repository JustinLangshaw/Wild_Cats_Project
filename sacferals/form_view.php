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
	<title>Form View</title>
	<style>
	body 
	{
		background-color: #5ab1c5;
	}
	label {display: block;}
	</style>
</head>
<body background: #5ab1c5>
<h1>Form View</h1>

<br>
<b>
Full Name: 
</b>
</br>

<br>
<b>
Email Address: 
</b>
</br>

<br>
<b>
Primary Phone: 
</b>
</br>

<br>
<b>
Secondary Phone: 
</b>
</br>

<br>
<b>
Colony Address: 
</b>
</br>

<br>
<b>
City: 
</b>
</br>

<br>
<b>
County: 
</b>
</br>

<br>
<b>
Zip Code: 
</b>
</br>

<br>
<b>
Anyone Attempted: 
</b>
</br>

<br>
<b>
Kittens: 
</b>
</br>

<br>
<b>
Colony Caregiver: 
</b>
</br>

<br>
<b>
Feeder Description: 
</b>
</br>

<br>
<b>
Injured/Pregnant: 
</b>
</br>

<br>
<b>
Injury Description: 
</b>
</br>

<br>
<b>
Friendly/Pet: 
</b>
</br>

<br>
<b>
Colony Setting: 
</b>
</br>

//intended buttons; not ready yet
//<br>
//<a href="userprofile.php">BACK</a>
//<a href="userprofile.php">NEXT</a>
//</br>

</body>
</html>
