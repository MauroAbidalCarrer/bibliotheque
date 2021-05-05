<?php
//startup_______________________
$m = $_POST["mail"];
$conn = new mysqli("localhost", "root", "", "db1");
if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
//header_________________________
echo"
	<head>
		<title>livres disponibles</title>
		<link rel='stylesheet' type='text/css' href='css/style.css'>
		<meta charset='utf-8'>
	</head>
	<header>
			<h2 id='title1'> <strong>Livres disponibles</strong></h2>
			<nav id='menu-nav'>
			    <ul>
				 <li class='bouton'>
					<form action='index.php'><input type='submit'value='déconnexion' color='red'></form>
				 </li>
				 <li class='bouton'>
					<form action='borrowedBooks.php' method='post'>
						<input type='hidden' name='mail' value='" . $m . "'>
						<input type='submit'  value='livres empruntés'>
					</form>
				 </li>
			    </ul>
			</nav>
	</header>
		<body>
			<div id='content'>
				<div id='center'>
";
//take_book_____________________
$book = $_POST["take"];
if($book != null)
{
echo"called<br>";
	$da = date("d-m-Y");
	$sql = "UPDATE books SET currentOwner='$m', borrowDate='$da' WHERE id='$book'";
	if($conn->query($sql) === FALSE)
		echo "update failed mail: " . $m . ", take: " . $book . "<br>";
}
//research_books_________________
$sql = "SELECT * FROM `db1`.`books`i WHERE currentOwner IS NULL";
$result = $conn->query($sql);
$i = 0;
if($_POST["index"] != null)
	$i = $_POST["index"];
$i = $i - ($i % 10);
$off = -1;
if($result->num_rows > 0)
{
	echo"<h2>Books</h2>
	<table>
	<tr><td>titre</td><td>description</td><td>temps d'emprunt(en jours)</td><td>take</td></tr>";
	for($a = 0; $a <= $i; $a++)
		$row = $result->fetch_assoc();
	while($row = $result->fetch_assoc() and ++$off < 10)
	{
		echo"<tr><td>".$row["titre"]."</td>
			<td>".$row["description"]."</td>
			<td>".$row["maxUseTime"]."</td>
			<td><form method='post'><input type='hidden' name='mail' value='" . $m . "'>
			<input type='hidden' name='take' value='".$row["ID"]."'>
			<input type='submit' value='take'></form></td></tr>";
	}
	echo"</table><br>";
}
else
	echo"<h3>Aucun livre n'est actuellement disponible</h3>";
echo"<footer>";
	$n = $i - 10;
	if($i >= 10)
		echo"<form method='post'><input type='hidden' name='index' value='".$n."'><input type='submit' value='precedent'></form>"; 
	echo"<h1>   autres pages   </h1>";
	$n = $i + $off;
	if($off >= 10)
		echo"<form method='post'><input type='hidden' name='index' value='".$n."'><input type='submit' value='suivant'></form>"; 
echo"</footer>";
?>
