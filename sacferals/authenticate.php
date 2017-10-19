<?php
$host = "athena";
$user = "";
$pass = "";
$db = "";

function connectdb($host, $user, $pass, $db)
{
$link = mysqli_connect("$host", "$user", "$pass", "$db") or die("Error ".mysqli_error($link));
return $link;
}


function authenticateUser()
{
	global $link;
	$username = $_POST['username'];
	//$email = $_POST['email'];
	$pass = $_POST['pass'];
	
	$query = "select * from SacFeralsUsers where (BINARY username = BINARY '$username' or email='$username') and BINARY password = BINARY '$pass'";
	$result = mysqli_query($link, $query);

	if(mysqli_num_rows($result) == 0)
	{
		$_SESSION['authenticate234252432341'] = "Not Valid!!!";
	}
	else
	{ 
		$row = mysqli_fetch_row($result);
		list($userid, $username, $email, $password, $level) = $row;
		$_SESSION['authenticate234252432341'] = "validuser09821";
		$_SESSION['Ausername'] = $username;
		//$_SESSION['Aemail'] = $email;
		$_SESSION['level'] = $level;
	}
}

?>