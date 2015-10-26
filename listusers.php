<?php
require 'auth.php';
require 'dbinfo.php';
//check connection
if(!$db = mysqli_connect($hn, $un, $pw, $dn))
{
	die("<font color='red'>Failed to connect to MySQL: " . mysqli_connect_error()."</font><br/><br/>");
}

if($_SESSION['isAdmin']) {
	$sql = 'SELECT username, first_name, last_name, email FROM users';
} elseif (isset($_SESSION['username'])) {
	$sql = sprintf("SELECT username, first_name, last_name, email FROM users WHERE username = '%s'",
			$_SESSION['username']);
}
if(!$result = mysqli_query($db, $sql))
{
	die("<font color='red'>Error number: ".mysqli_errno($db)."<br/>
					Error description: ".mysqli_error($db)."</font><br/><br/>");
}
mysqli_close($db);

?>

<!DOCTYPE html>
<html>
<head>
	<title>ListUsers</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
<?php include 'navigation.html';?>
<br>
	<table>
		<tr>
			<th scope="col">Username</th>
			<th scope="col">First Name</th>
			<th scope="col">Last Name</th>
			<th scope="col">E-mail</th>
		</tr>
			<?php
			foreach ($result as $row){
				printf('<tr>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td><a href="updateinfo.php?username=%s">Edit</a></td>
						<td><a href="deleteuser.php?username=%s">Delete</a></td>
						</tr>',
						htmlspecialchars($row['username'], ENT_QUOTES),
						htmlspecialchars($row['first_name'], ENT_QUOTES),
						htmlspecialchars($row['last_name'], ENT_QUOTES),
						htmlspecialchars($row['email'], ENT_QUOTES),
						htmlspecialchars($row['username'], ENT_QUOTES),
						htmlspecialchars($row['username']), ENT_QUOTES);
			}
			?>
	</table>
</body>
</html>