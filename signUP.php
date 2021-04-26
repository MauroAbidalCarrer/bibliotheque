<html>
	<header>
		<h2> <strong>Login</strong></h2>
		<a href="signUp.php">signUp</a>
	</header>
	<form method="post">
		pseudo:<br>
		<input type="text" name="pseudo" required>
		<br>
		mail:<br>
		<input type="text" name="mail" required>
		<br>
		password:<br>
		<input type="password" name="password" required>
		<br><br>
		<input type="submit" name="submit">
	</form>
</html>
<?php
//startup______________
$m = $_POST["mail"];
$ps = $_POST["pseudo"];
$p = $_POST["password"];
if($m == NULL)
	exit;
//make connection_____
$conn = new mysqli("localhost", "root", "", "db1");
if($conn->connect_error)
	die("connection failed!!  " . $conn -> connect_error);
//add_account________
$sql = "SELECT `mail` FROM `db1`.`user` WHERE mail = '$m'";
$result = $conn->query($sql);
if($result->num_rows == 0)
{
	$sql = "INSERT INTO waitingList(pseudo, mail, password) VALUES('$p', '$m', '$ps')";
	$result = $conn->query($sql);
	if($result === TRUE)
		echo"added to waiting list<br>";
	else
		echo"error: could not add to waiting list<br>";
}
else
	echo"active account with same mail already exitsts<br>";
$conn->close();
exit();
?>
