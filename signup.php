<?php
$username = '';
$password = '';
$email = '';
$firstname = '';
$lastname = '';
require 'dbinfo.php';

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
		$sql = sprintf("INSERT INTO users (username, first_name, last_name, email, pswd) VALUES
				('%s', '%s','%s', '%s', '%s')", 
				mysqli_real_escape_string($db, $username),
				mysqli_real_escape_string($db, $firstname),
				mysqli_real_escape_string($db, $lastname),
				mysqli_real_escape_string($db, $email),
				mysqli_real_escape_string($db, $hash)
				);
		if(!mysqli_query($db, $sql))
		{
			echo "<font color='red'>Error number: ".mysqli_errno($db)."<br/>
					Error description: ".mysqli_error($db)."</font><br/><br/>";
		} else
		{
			echo "<font color='green'>User Registered</font> <br/>";
			$username = '';
			$password = '';
			$email = '';
			$firstname = '';
			$lastname = '';
			mysqli_close($db);
			header('location: login.php');
		}
		mysqli_close($db);
	} else
		echo "<font color='red'>Please fill out all entries before submitting</font><br/><br/>";
} elseif (isset($_POST['login'])) {
	header('location: login.php');
}
?>
<!doctype html>
<html>
	<head>
		<title>PHPdbacess</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
	<?php include 'navigation.html';?>
	<h1>Sign Up For Services</h1><br/><br/>
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
			<input id="green" type="submit" name="submit" value="Submit"><br>
			<h3>If you already have an account click below:</h3><br>
			<input id="red" type="submit" name="login" value="Go To Login">
		</form>
	</body>
</html>
