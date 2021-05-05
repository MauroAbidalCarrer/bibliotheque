<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>	Livres emprumptés</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<meta charset="utf-8">
	</head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td{
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
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
		<body>
			<div id='content'>
				<div id='center'>
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
	echo"<h2 id='contacttitle'>Books</h2>";
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
	echo"</table>";
}
else
	echo"<h3>vous ne possedez actuellement aucun livre</h3>";
echo"</div></div></body>";
?>
