<?php
//startup_______________________
$m = $_POST["mail"];
$conn = new mysqli("localhost", "root", "", "db1");
if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
//header_________________________
echo"
	<header>
		<h2> <strong> Home page </strong></h2>
		<form action='manageBooks.php' method='post'>
			<input type='hidden' name='mail' value='" . $m . "'>
			<input type='submit'  value='livres empruntes'>
		</form>
	</header>
";
//take______________________
$t = $_POST["take"];
if($t != null)
{
	$sql = "UPDATE books SET currentOwner='$m' WHERE titre='$t'";
	if($conn->query($sql) === TRUE)
		echo "update successfull<br>";
	else
		echo "update failed mail: " . $m . ", take: " . $t . "<br>";
}
else
	echo"take = null";
//borrowed_books_________________
$sql = "SELECT `titre` FROM `db1`.`books`i WHERE currentOwner IS NULL";
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
		echo"<input type='hidden' name='take' value='".$row["titre"]."'>";
		echo"<input type='submit' value='take'></form></td></tr>";
	}
	echo"</table><br>";
}
else
	echo"<h3>Aucun livre n'est actuellement disponible</h3>";
?>
