<?php

session_start();
require 'dbinfo.php';

if (isset ( $_POST ['login'] )) {

	$ok = true; // form validation variable

	if (! isset ( $_POST ['username'] ) || $_POST ['username'] === '') {
		$ok = false;
	}
	if (! isset ( $_POST ['password'] ) || $_POST ['password'] === '') {
		$ok = false;
	}

	if ($ok) {
		$db = mysqli_connect($hn, $un, $pw, $dn);
		//check connection
		if (mysqli_connect_errno())
		{
			echo "<font color='red'>Failed to connect to MySQL: " . mysqli_connect_error()."</font><br/><br/>";
		}
		$sql = sprintf("SELECT * FROM users WHERE username = '%s'",
				mysqli_real_escape_string($db, $_POST['username'])
				);
		if(!$result = mysqli_query($db, $sql)){
			echo "<font color='red'>Error number: ".mysqli_errno($db)."<br/>
					Error description: ".mysqli_error($db)."</font><br/><br/>";
		} else {
			$row = mysqli_fetch_assoc($result);
			$hash = $row['pswd'];
			$isAdmin = $row['admin'];
			if(password_verify($_POST['password'], $hash)){
				echo 'Login Successful';
				$_SESSION['username'] = $row['username'];
				$_SESSION['isAdmin'] = $row['admin'];
			} else {
				echo 'Login Failed';
			}
		}
	} else {
		echo "<font color='red'>Please fill out all entries before submitting</font><br/><br/>";
	}

} elseif (isset($_POST['create'])) {
	header('location: signup.php');
}
?>

<!Doctype html>
<html>
<head>
	<title>User Login</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<?php include 'navigation.html';?>
	<h1>Sanjay Kumar Technology Services</h1><br><br>
	<p>This is a demo of a PHP website using MySQL<br>
			to manage user registration and information.<br>
			TRY IT OUT with dummy accounts if you like<br><br>
	</p>
	<form action="" method="post">
	<h3>Please Login or click button to go to Create Account</h3>
		Username: <input type="text" name="username"><br><br>
		Password: <input type="password" name="password"><br><br>
		<input id="green" type="submit" name="login" value="Login"><br>
		<p>If you have not already signed up then:</p><br>
		<input id="red" type="submit" name="create" value="Create Account">
	</form>
</body>
</html>