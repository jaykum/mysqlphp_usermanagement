<?php

require 'auth.php';
if(isset($_GET['username'])){
	$username=$_GET['username'];
} else {
	header('location: listusers.php');
}

require 'dbinfo.php';

$db = mysqli_connect($hn, $un, $pw, $dn);
//check connection
if (mysqli_connect_errno())
{
	echo "<font color='red'>Failed to connect to MySQL: " . mysqli_connect_error()."</font><br/><br/>";
}
$sql = sprintf("DELETE FROM users WHERE username = '%s'",
		mysqli_real_escape_string($db, $username)
		);
if(!mysqli_query($db, $sql))
{
	echo "<font color='red'>Error number: ".mysqli_errno($db)."<br/>
					Error description: ".mysqli_error($db)."</font><br/><br/>";
} else if (mysqli_affected_rows($db) <= 0){
	echo "<font color='red'>No changes made</font><br/><br/>";
} else
{
	mysqli_close($db);
	header('location: listusers.php');
}