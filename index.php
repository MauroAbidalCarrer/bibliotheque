<!DOCTYPE html>
<html>
<html lang="fr">
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
	<header>
		<h2> <strong>Login</strong></h2>
		<a href="signUp.php">signUp</a>
	</header>
	<form method="post">
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
//startup______________
$m = $_POST["mail"];
$p = $_POST["password"];
if($m == NULL or $p == NULL)
	exit;
//make connection_____
$conn = new mysqli("localhost", "root", "", "db1");
if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
$sql = "SELECT `mail` FROM `db1`.`user` WHERE mail = '$m' AND password = '$p'";
$result = $conn->query($sql);
if($result->num_rows == 1)
{
	session_start();
	$_SESSION = $_POST;
	session_write_close();
	header('Location: manageBooks.php');
}
elseif ($result->num_rows > 1)
	echo "strange num_rows=".$result->num_rows."<<br>";
else
	echo"mail and/or password are incrorrect";
$conn->close();
exit();
?>
