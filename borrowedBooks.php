<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>
			Froyotech
		</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<meta charset="utf-8">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js%22%3E"></script>
	</head>
</html>
<?php
//startup_______________________
$r = $_POST["return"];
session_start();
$_POST = $_SESSION;
$m = $_POST["mail"];
$conn = new mysqli("localhost", "root", "", "db1");
if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
//header_________________________
echo"
		<header id='header1' >
			<h2 id='title1'> <strong>Livres empruntés</strong></h2>
			<nav id='menu-nav'>
			    <ul>
				 <li class='bouton'>
					<form action='index.php'><input type='submit'value='déconnexion' color='red'></form>
				 </li>
				 <li class='bouton'>
					<form action='researchBooks.php' method='post'>
						<input type='hidden' name='mail' value='" . $m . "'>
						<input type='submit'  value='livres disponibles'>
					</form>
				 </li>
			    </ul>
			</nav>
		</header>
";
//restitut______________________
if($r != null)
{
	$sql = "UPDATE books SET currentOwner=null WHERE titre='$r'";
	if($conn->query($sql) === TRUE)
		echo "update successfull<br>";
	else
		echo "update failed mail: " . $m . "<br>";
}

//borrowed_books_________________
$sql = "SELECT * FROM `db1`.`books` WHERE currentOwner='$m'";
$result = $conn->query($sql);
if($result->num_rows > 0)
{
	echo"<div id='content'>	<div id='center'><h2 id='contacttitle'>Books</h2>";
	echo"<table>";
	echo"<tr><td>titre</td><td>description</td><td>rendre</td></tr>";
	while($row = $result->fetch_assoc())
	{
		echo"<tr><td>".$row["titre"]."</td>";
		echo"<td>".$row["description"]."</td>";
		echo"<td><form method='post'><input type='hidden' name='mail' value='" . $m . "'>";
		echo"<input type='hidden' name='return' value='".$row["titre"]."'>";
		echo"<input type='submit' value='rendre'></form></td></tr>";
	}
	echo"</table></div></div>";
}
else
	echo"<h3>vous ne possedez actuellement aucun livre</h3>";
?>
