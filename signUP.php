<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>sign Up</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js%22%3E"></script>
	</head>

	<body>
		<div id="content">
			<div id="center">
				<h2 id="contacttitle"> sign Up</h2>
				<form method='post'>
					<label>Pseudo</label>
						<input type="text"  name="pseudo" placeholder="Your Name/firstName.." required>
					<label>Email address</label>
						<input type="text" name="mail" placeholder="Your Email.." required>
					<label>Password</label>
						<input type="password" name="password" required>
					<input type="submit" value="Submit">
				</form>
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
$sql = "SELECT `mail` FROM `db1`.`user` WHERE mail = '$m'";
$result = $conn->query($sql);
if($result->num_rows == 0)
{
	$sql = "INSERT INTO waitingList(pseudo, mail, password) VALUES('$ps', '$m', '$p')";
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
