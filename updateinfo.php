<?php

require 'auth.php';
require 'dbinfo.php';
if(isset($_GET['username'])){
	$username=$_GET['username'];
} else {
	header('location: listusers.php');
}

$password = '';
$email = '';
$firstname = '';
$lastname = '';

if (isset ( $_POST ['submit'] )) {
	
	$ok = true; // form validation variable
	
	if (! isset ( $_POST ['username'] ) || $_POST ['username'] === '') {
		$ok = false;
	} else {
		$username = $_POST ['username'];
	}
	if (! isset ( $_POST ['password'] ) || $_POST ['password'] === '') {
		$ok = false;
	} else {
		$password = $_POST ['password'];
	}
	if (! isset ( $_POST ['email'] ) || $_POST ['email'] === '') {
		$ok = false;
	} else {
		$email = $_POST ['email'];
	}
	if (! isset ( $_POST ['firstname'] ) || $_POST ['firstname'] === '') {
		$ok = false;
	} else {
		$firstname = $_POST ['firstname'];
	}
	if (! isset ( $_POST ['lastname'] ) || $_POST ['lastname'] === '') {
		$ok = false;
	} else {
		$lastname = $_POST ['lastname'];
	}
	
	if ($ok) {
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$db = mysqli_connect($hn, $un, $pw, $dn);
		//check connection
		if (mysqli_connect_errno())
		{
			echo "<font color='red'>Failed to connect to MySQL: " . mysqli_connect_error()."</font><br/><br/>";
		}
		$sql = sprintf("UPDATE users SET username = '%s', first_name = '%s', last_name = '%s',
				email = '%s', pswd = '%s' WHERE username = '%s'",
				mysqli_real_escape_string($db, $username),
				mysqli_real_escape_string($db, $firstname),
				mysqli_real_escape_string($db, $lastname),
				mysqli_real_escape_string($db, $email),
				mysqli_real_escape_string($db, $hash),
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
	} else {
		echo "<font color='red'>Please fill out all entries before submitting</font><br/><br/>";
	}
	
} elseif (isset($_POST['cancel'])) {
	header('location: listusers.php');
	
} else {
		$db = mysqli_connect($hn, $un, $pw, $dn);
		//check connection
		if (mysqli_connect_errno())
		{
			echo "<font color='red'>Failed to connect to MySQL: " . mysqli_connect_error()."</font><br/><br/>";
		}
		$sql = sprintf("SELECT * FROM users WHERE username = '%s'", $username);
		if(!$result = mysqli_query($db, $sql))
		{
			echo "<font color='red'>Error number: ".mysqli_errno($db)."<br/>
					Error description: ".mysqli_error($db)."</font><br/><br/>";
		} else
		{
			foreach ($result as $row){
				$email = $row['email'];
				$firstname = $row['first_name'];
				$lastname = $row['last_name'];
			}
		}
		mysqli_close($db);
}
?>

<!doctype html>
<html>
	<head>
		<title>PHP Update Information</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
	<?php include 'navigation.html';?>
	<h1>Update Your Information</h1><br/><br/>
		<form method="post" action="">
			UserName: <input type="text" name=username value="<?php 
				echo htmlspecialchars($username, ENT_QUOTES);
			?>"><br><br>
			Password: <input type="password" name=password><br><br>
			E-Mail: <input type="email" name=email value="<?php 
				echo htmlspecialchars($email, ENT_QUOTES);
			?>"><br><br>
			FirstName: <input type="text" name=firstname value="<?php 
				echo htmlspecialchars($firstname, ENT_QUOTES);
			?>"><br><br>
			Last Name: <input type="text" name=lastname value="<?php 
				echo htmlspecialchars($lastname, ENT_QUOTES);
			?>"><br><br><br>
			<input id="green" type="submit" name="submit" value="Submit">&nbsp;&nbsp;&nbsp;&nbsp;
			<input id="red" type="submit" name="cancel" value="Cancel">
		</form>
	</body>
</html>
