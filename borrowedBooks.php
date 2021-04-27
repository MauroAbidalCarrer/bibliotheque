<?php
//startup_______________________
$r = $_POST["return"];
session_start();
$_POST = $_SESSION;
$m = $_POST["mail"];
echo"mail: " .$m."<br>";
$conn = new mysqli("localhost", "root", "", "db1");
if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
//header_________________________
echo"
	<header>
		<h2 style.color='green'> <strong> <a href='index.php'>sign Out</strong></a></h2>
		<h2 style.color='green'> <strong> Home page </strong></h2>
		<form action='researchBooks.php' method='post'>
			<input type='hidden' name='mail' value='" . $m . "'>
			<input type='submit'  value='livres disponibles'>
		</form>
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
else
	echo"restitut = null";
//borrowed_books_________________
$sql = "SELECT `titre` FROM `db1`.`books` WHERE currentOwner='$m'";
$result = $conn->query($sql);
if($result->num_rows > 0)
{
	echo"<h3>Books</h3>";
	echo"<table>";
	echo"<tr><td>titre</td><td>restitut</td></tr>";
	while($row = $result->fetch_assoc())
	{
		echo"<tr><td>".$row["titre"]."</td>";
		echo"<td><form method='post'><input type='hidden' name='mail' value='" . $m . "'>";
		echo"<input type='hidden' name='return' value='".$row["titre"]."'>";
		echo"<input type='submit' value='rendre'></form></td></tr>";
	}
	echo"</table><br>";
}
else
	echo"<h3>vous ne possedez actuellement aucun livre</h3>";
?>
