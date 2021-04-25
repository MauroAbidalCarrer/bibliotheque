<?php
session_start();
$_POST = $_SESSION;
$m = $_POST["mail"];
$p = $_POST["password"];

$conn = new mysqli($servername, $username, "", $dbname);
if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
echo"connection succesfull<br>mail: " . $m . "<br>password: ".$p."<br>";
?>
