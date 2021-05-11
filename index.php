<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Connéxion</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>

	<body>
		<div id="content">
			<div id="center">
				<h2>Connexion</h2>
				<form method='post'>
					<label>adresse email</label>
						<input type="text" name="mail" placeholder="votre email.." required>
					<label>mot de passe</label>
						<input type="password" name="password" required>
					<input type="submit" value="Submit">
				</form>
				Vous n'avez pas de compte?
				<a href="signUp.php"> <strong>Inscrivez vous</strong> </a>
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
	if($row["mail"] == "admin")
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
