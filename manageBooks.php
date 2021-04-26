<?php
session_start();
$_POST = $_SESSION;
$m = $_POST["mail"];

$conn = new mysqli("localhost", "root", "", "db1");
if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
//echo"connection succesfull<br>mail: " . $m . "<br>password: ".$p."<br>";
$sql = "SELECT `titre` FROM `db1`.`books`";
$result = $conn->query($sql);
if($result->num_rows > 0)
{
	echo"<h3>Books</h3>";
	echo"<table>";
	echo"<tr><td>titre</td></tr>";
	while($row = $result->fetch_assoc())
	{
		echo"<tr><td>".$row["titre"]."</td></tr>";
	}
	echo"</table><br>";
}
else
	echo"<h3>vous ne possedez actuellement aucun livre</h3>";
?>
