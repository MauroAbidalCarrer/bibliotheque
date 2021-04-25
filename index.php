<!DOCTYPE html>
<html>
<html lang="fr">
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<form action="index.php" method="post">
		mail:<br>
		<input type="text" name="mail" required>
		<br>
		password:<br>
		<input type="password" name="password" required>
		<br><br>
		<input type="submit" name="submit">
	</form>
</body>

</html>

<?php
$m = $_POST["mail"];
$p = $_POST["password"];
if($m == NULL or $p == NULL)
	exit;
$servername = "localhost";
$username = "root";
$dbname = "db1";
//make connection
$conn = new mysqli($servername, $username, "", $dbname);
if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
//echo"connection succesfull<br>mail: " . $m . "<br>password: ".$p."<br>";
$sql = "SELECT `mail` FROM `db1`.`user` WHERE mail = '$m' AND password = '$p'";
$result = $conn->query($sql);
if($result->num_rows > 0)
{
	session_start();
	$_SESSION = $_POST;
	session_write_close();
	header('Location: manageBooks.php');
	exit();
	//echo"connection to account successfull";
}
else
	echo"mail and/or password are incrorrect";
$conn->close();
?>
