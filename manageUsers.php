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
		<h2> <strong> <a href='manageBooks.php'>manage books</strong></a></h2>
	</header>
";
//remove_user__________________
$m = $_POST["mailToRemove"];
if($m != null)
{
	$sql = "DELETE FROM users WHERE mail='$m'";
	$result = $conn->query($sql);
	if($result === TRUE)
		echo"user has been removed<br>";
	else
		echo"error could not remove user mail: ".$_POST["mailToRemove"]."<br>";
}
else
	echo"remove is null<br>";
//refuse_request__________________
$m = $_POST["refuseRequest"];
if($m != null)
{
	$sql = "DELETE FROM waitingList WHERE mail='$m'";
	$result = $conn->query($sql);
	if($result === TRUE)
		echo"request has been refused<br>";
	else
		echo"error, request could not be refused mail: ".$_POST["mailToRemove"]."<br>";
}
else
	echo"remove is null<br>";
//accept_request_______________
$m = $_POST["acceptRequest"];
if($m != null)
{
	$sql = "DELETE FROM waitingList WHERE mail='$m'";
	$result = $conn->query($sql);
	if($result === TRUE)
		echo"user has been removed<br>";
	else
		echo"error could not remove user mail: ".$_POST["mailToRemove"]."<br>";
	$p = $_POST["pseudo"];
	$ps = $_POST["password"];
	echo"pseudo: ".$pseudo." <br>password: " .$ps."<br>mail: ".$m."<br>";
	$sql = "INSERT INTO users (pseudo, mail, password) VALUES('$p', '$m', '$ps')";
	$result = $conn->query($sql);
	if($result === TRUE)
		echo"added user from waiting list<br>";
	else
		echo"could not add user form waintg list mail: ".$t."<br>";
}
else
	echo"accept request is null<br>";
//user_table___________________
$sql = "SELECT * FROM `db1`.`users`";
$result = $conn->query($sql);
if($result->num_rows > 0)
{
	echo"<h3>Users</h3>";
	echo"<table>";
	echo"<tr><td>pseudo</td><td>mail</td><td>password</td><td>remove</td></tr>";
	while($row = $result->fetch_assoc())
	{
		echo"<tr><td>".$row["pseudo"]."</td>";
		echo"<td>".$row["mail"]."</td>";
		echo"<td>".$row["password"]."</td>";
		echo"<td><form method='post'>";
		echo"<input type='hidden' name='mailToRemove' value='".$row["mail"]."'>";
		echo"<input type='submit' value='retirer'></form></td><tr>";
	}
	echo"</table><br>";
}
else
	echo"<h3>il n'y a aucun utilisateur</h3>";
//waiting_list___________________
$sql = "SELECT * FROM `db1`.`waitingList`";
$result = $conn->query($sql);
if($result->num_rows > 0)
{
	echo"<h3>requestes</h3>";
	echo"<table>";
	echo"<tr><td>pseudo</td><td>mail</td><td>password</td><td>accepter</td><td>refuser</td></tr>";
	while($row = $result->fetch_assoc())
	{
		echo"<tr><td>".$row["pseudo"]."</td>";
		echo"<td>".$row["mail"]."</td>";
		echo"<td>".$row["password"]."</td>";
		echo"<td><form method='post'>";
		echo"<input type='hidden' name='acceptRequest' value='".$row["mail"]."'>";
		echo"<input type='hidden' name='pseudo' value='".$row["pseudo"]."'>";
		echo"<input type='hidden' name='password' value='".$row["password"]."'>";
		echo"<input type='submit' value='accepter'></form></td>";
		echo"<td><form method='post'> <input type='hidden' name='refuseRequest' value='".$row["mail"]."'>";
		echo"<input type='submit' value='refuser'></form></td><tr>";
	}
	echo"</table><br>";
}
else
	echo"<h3>il n'y a aucune demande </>";
?>
