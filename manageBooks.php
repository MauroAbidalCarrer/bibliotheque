<?php
//startup_______________________
$conn = new mysqli("localhost", "root", "", "db1");
if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
//header_________________________
echo"
	<header>
		<h2> <strong> Home page </strong></h2>
		<h2> <strong> <a href='index.php'>sign Out</strong></a></h2>
		<h2> <strong> <a href='manageUsers.php'>manage users</strong></a></h2>
	</header>
";
//remove_____________________
$r = $_POST["remove"];
if($r != null)
{
	$sql = "DELETE FROM books WHERE titre='$r'";
	$result = $conn->query($sql);
	if($result === TRUE)
		echo"book has been deleted<br>";
	else
		echo"error could not delete book remove: ".$_POST["remove"]."<br>";
}
else
	echo"remove is null<br>";
//add_book___________________
if($_POST["titreToAdd"] != null)
{
	$t = $_POST["titreToAdd"];
	$b = $_POST["borrowTime"];
	$d = $_POST["description"];
	$sql = "INSERT INTO books (titre, description, maxUseTime) VALUES('$t', '$d', '$b')";
	$result = $conn->query($sql);
	if($result === TRUE)
		echo"added book<br>";
	else
		echo"could not add book: ".$t."<br>";
}
else
	echo"titreToAdd is null";
echo"<h2>add book</h2>
	<form method='post'>
		titre:<input type='text' name='titreToAdd' required>
		description:<input type='textarea' name='description' required>
		temps emprunt maximum:<input type='number' name='borrowTime' required>
		<input type='submit' value='ajouter'>
	</form>
";

//book_table__________________
$sql = "SELECT * FROM `db1`.`books`";
$result = $conn->query($sql);
if($result->num_rows > 0)
{
	echo"<h3>Books</h3>";
	echo"<table>";
	echo"<tr><td>titre</td><td>description</td><td>current owner</td><td>remove</td></tr>";
	while($row = $result->fetch_assoc())
	{
		echo"<tr><td>".$row["titre"]."</td>";
		echo"<td>".$row["description"]."</td>";
		echo"<td>".$row["currentOwner"]."</td>";
		echo"<td><form method='post'>";
		echo"<input type='hidden' name='remove' value='".$row["titre"]."'>";
		echo"<input type='submit' value='retirer'></form></td><tr>";
	}
	echo"</table><br>";
}
else
	echo"<h3>il n'y a aucun livre</h3>";
?>
