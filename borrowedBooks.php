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
	<head>
		<title>	Livres emprumptés</title>
		<link rel='stylesheet' type='text/css' href='css/style.css'>
		<meta charset='utf-8'>
	</head>
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
		<div id='center'>
";
//restitut______________________
if($r != null)
{
	$sql = "UPDATE books SET currentOwner=null, borrowDate=null WHERE titre='$r'";
	if($conn->query($sql) === FALSE)
		echo "update failed mail: " . $m . "<br>";
}

//borrowed_books_________________
$sql = "SELECT * FROM `db1`.`books` WHERE currentOwner='$m'";
$result = $conn->query($sql);
if($result->num_rows > 0)
{
	echo"
		<h2 id='contacttitle'>Books</h2>
		<table>
		<thead><tr><td>titre</td><td>description</td><td>temps d'emprunt restant</td><td>rendre</td></tr></thead>
	";
	$doitRendre = FAlSE;
	while($row = $result->fetch_assoc())
	{
		$borrowedTime = floor((time() - strtotime($row["borrowDate"])) / (60 * 60 * 24));
		$timeLeft = $row["maxUseTime"] - $borrowedTime;
		$iddd = "";
		if($timeLeft <= 0){
			$timeLeft = 0;
			$iddd = "id='ROW1'";
			$doitRendre = TRUE;}
		echo"
			<tr ".$iddd."><td>".$row["titre"]."</td>
			<td>".$row["description"]."</td>
			<td>".$timeLeft."</td>
			<td><form method='post'><input type='hidden' name='mail' value='".$m."'>
			<input type='hidden' name='return' value='".$row["titre"]."'>
			<input type='submit' value='rendre'></form></td></tr>
		";
	}
	echo"</table>";
	if($doitRendre == TRUE)
		echo"<script>alert('Votre temps d emprunt de certains livres(en rouge) a éxcedé celui permit par la biblihotèque, veuillez les rendre le plus tôt possible.')</script>";
}
else
	echo"<h3>Vous ne possédez actuellement aucun livre.</h3>";
echo"</div></body>";
?>
