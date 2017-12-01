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
	$pass = $_POST['pass'];
	
	$query = $link->prepare("select * from SacFeralsUsers where (BINARY username = BINARY ? or email=?) and BINARY password = BINARY ?");
	$query->bind_param("sss", $username, $username, $pass);
	$query->execute();
	$query->bind_result($userid, $usern, $email, $password, $level);
	$query->store_result();

	if(!$query->fetch()){
		$result = 0;
	}else{		
		$result = $query->num_rows;
	}
	$query->close();
	
	if($result == 0 || ($level!=1 && $level!=2)) //not valid if not activated
	{
		$_SESSION['authenticate234252432341'] = "Not Valid!!!";	
		if(($username != "") || ($pass != "")){
			return "Invalid credentials ";
		}		
	}
	else
	{ 
		$_SESSION['authenticate234252432341'] = "validuser09821";
		$_SESSION['Ausername'] = $username;
		$_SESSION['Aemail'] = $email;
		$_SESSION['level'] = $level;
	}
}

?>