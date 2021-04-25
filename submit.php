<?php
$f = $_POST["firstname"];
$l = $_POST["lastname"];
$a = $_POST["age"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db1";

//make connection
$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
echo"connection succesfull<br>";

$sql = "INSERT INTO user (prenom, nom, age) VALUES ('$f', '$l', '$a')";
if($conn->query($sql) === TRUE)
	echo "New user added!";
else
	echo"ERROR: " . $sql . "<br>" . $conn->error;

$sql = "SELECT id, prenom, nom, age FROM user";
$result = $conn->query($sql);
if($result->num_rows > 0)
{
	echo"<table>";
	echo "<tr><td>ID</td><td>Prenom</td><td>Nom</td><td>Age</td></tr>";
$row = $result -> fetch_assoc();
	while($row = $result -> fetch_assoc())
{
		echo"<tr><td>" . $row["id"] . "</td><td>" . $row["prenom"] . "</td><td>" . $row["nom"] . "</td><td>" . $row["age"] . "</td></tr>";
}
	echo"</table>";
}
else
	echo"no rows no table<br>";
$conn->close();
?>
