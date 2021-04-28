<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Log In</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js%22%3E"></script>
	</head>

	<body>
		<div id="content">
			<div id="center">
				<h2 id="contacttitle">Log In</h2>
				<form method='post'>
					<label>Email address</label>
						<input type="text" name="mail" placeholder="Your Email.." required>
					<label>Password</label>
						<input type="password" name="password" required>
					<input type="submit" value="Submit">
				</form>
				<a href="signUp.php"> <strong>sign Up</strong> </a>
				</div>
			</div>
		</div>
	</body>
</html>
</body>

</html>

<?php
//startup______________
$m = $_POST["mail"];
$p = $_POST["password"];
if($m == NULL or $p == NULL)
	exit;
//make connection______
$conn = new mysqli("localhost", "root", "", "db1");
if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
//log__In_____________
//echo"called <br>mail: ".$m."  <br>password: ".$p."<br>";
$sql = "SELECT * FROM `db1`.`users` WHERE mail = '$m' AND password = '$p'";
$result = $conn->query($sql);
if($result->num_rows == 1)
{
	$row = $result->fetch_assoc();
	if($row["pseudo"] == "admin")
		header('Location: manageBooks.php');
	else
	{
		session_start();
		$_SESSION = $_POST;
		session_write_close();
		header('Location: borrowedBooks.php');
		echo"called<br>";
	}
}
elseif ($result->num_rows > 1)
	echo "strange num_rows=".$result->num_rows."<<br>";
else
	echo"mail and/or password are incrorrect";
$conn->close();
exit();
?>
