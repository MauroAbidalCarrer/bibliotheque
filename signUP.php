<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>sign Up</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>

	<body>
		<div id="content">
			<div id="center">
				<h2 id="contacttitle"> sign Up</h2>
				<form method='post'>
					<label>Email address</label>
						<input type="text" name="mail" placeholder="Your Email.." required>
					<label>Password</label>
						<input type="password" name="password" required>
					<input type="submit" value="Submit">
				</form>
				<a href='index.php'>Log In</a>
				</div>
			</div>
		</div>
	</body>
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
$sql = "SELECT * FROM `db1`.`users` WHERE mail='$m'";
$result2 = $conn->query($sql);
$sql = "SELECT * FROM `db1`.`waitingList` WHERE mail='$m'";
$result = $conn->query($sql);
if($result->num_rows == 0 && $result2->num_rows == 0)
{
	$sql = "INSERT INTO waitingList(mail, password) VALUES('$m', '$p')";
	$result = $conn->query($sql);
	if($result === FALSE)
		echo"error: could not add to waiting list<br>";
}
else
	echo"<script>alert('this eamil is already used')</script>";
$conn->close();
exit();
?>
