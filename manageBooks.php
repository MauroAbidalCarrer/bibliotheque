<?php
//startup_______________________
$conn = new mysqli("localhost", "root", "", "db1");
if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
//header_________________________
echo"
	<head>
		<title>manage Books</title>
		<link rel='stylesheet' type='text/css' href='css/style.css'>
		<meta charset='utf-8'>
	</head>
	<body>
		<header>
			<h2 > <strong>Manage books</strong></h2>
			<nav id='menu-nav'>
			    <ul>
				 <li class='bouton'>
					<form action='index.php'><input type='submit' value='déconnexion'></form>
				 </li>
				 <li class='bouton'>
					<form action='manageUsers.php'><input type='submit' value='manageUsers'></form>
				 </li>
			    </ul>
			</nav>
		</header>
		<div id='center'>
";
//remove_____________________
$r = $_POST["remove"];
if($r != null)
{
	$sql = "DELETE FROM books WHERE titre='$r'";
	$result = $conn->query($sql);
	if($result === FALSE)
		echo"error could not delete book remove: ".$_POST["remove"]."<br>";
}
//add_book___________________
if($_POST["titreToAdd"] != null)
{
	$t = $_POST["titreToAdd"];
	$sql = "SELECT * FROM `db1`.`books` WHERE titre='$t'";
	$result = $conn->query($sql);
	if($result->num_rows == 0)
	{
		$b = $_POST["borrowTime"];
		$d = $_POST["description"];
		$sql = "INSERT INTO books (titre, description, maxUseTime) VALUES('$t', '$d', '$b')";
		$result = $conn->query($sql);
		if($result === FALSE)
			echo"could not add book: ".$t."<br>";
	}
	else
		echo"<script>alert('error:Un livre avec le même titre éxiste déjà')</script>";
}
echo"
	<h2>add book</h2>
	<form method='post'>
		titre:<input type='text' name='titreToAdd' required><br>
		description:<input type='text' name='description' placeholder='courte déscription...' required><br>
		temps emprunt maximum:<input type='number' name='borrowTime' required><br>
		<input type='submit' value='ajouter'>
	</form>
";

//book_table__________________
$sql = "SELECT * FROM `db1`.`books`";
$result = $conn->query($sql);
if($result->num_rows > 0)
{
	echo"
		<h2>Books</h2>
		<table>
		<thead><tr><td>titre</td><td>description</td><td>current owner</td><td>temps d'emprunt max</td><td>remove</td></tr></thead>
	";
	while($row = $result->fetch_assoc())
	{
		echo"
			<tr><td>".$row["titre"]."</td>
			<td>".$row["description"]."</td>
			<td>".$row["currentOwner"]."</td>
			<td>".$row["maxUseTime"]."</td>
			<td><form method='post'>
			<input type='hidden' name='remove' value='".$row["titre"]."'>
			<input type='submit' value='retirer'></form></td></tr>
		";
	}
	echo"</table><br>";
}
else
	echo"<h3>il n'y a aucun livre</h3>";
echo"</div></body>";
?>
