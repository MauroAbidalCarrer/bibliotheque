<?php
//startup_______________________
$conn = new mysqli("localhost", "root", "", "db1");
if($conn->connect_error)
	die("connection failed!!" . $conn -> connect_error);
//header_________________________
echo"
	<head>
		<title>manage Users</title>
		<link rel='stylesheet' type='text/css' href='css/style.css'>
		<meta charset='utf-8'>
	</head>
	<body>
		<header>
			<h2 > <strong>Manage users</strong></h2>
			<nav id='menu-nav'>
			    <ul>
				 <li class='bouton'>
					<form action='index.php'><input type='submit' value='déconnexion'></form>
				 </li>
				 <li class='bouton'>
					<form action='manageBooks.php'><input type='submit' value='manageBooks'></form>
				 </li>
			    </ul>
			</nav>
		</header>
		<div id='center'>
";
//remove_user__________________
$m = $_POST["mailToRemove"];
if($m != null)
{
	if($m == "admin")
		echo"<script>alert('error: vous essayez de suprimmer votre propre compte')</script>";
	else
	{
		$result = $conn->query("UPDATE books SET currentOwner=null, borrowDate=null WHERE currentOwner='$m'");
if($result === FALSE)
	echo"error could not restitut books of ".$m."<br>";
		$sql = "DELETE FROM users WHERE mail='$m'";
		$result = $conn->query($sql);
		if($result === FALSE)
			echo"error could not remove user mail: ".$_POST["mailToRemove"]."<br>";
	}
}
//refuse_request__________________
$m = $_POST["refuseRequest"];
if($m != null)
{
	$sql = "DELETE FROM waitingList WHERE mail='$m'";
	$result = $conn->query($sql);
	if($result === FALSE)
		echo"error, request could not be refused mail: ".$_POST["mailToRemove"]."<br>";
}
$m = $_POST["acceptRequest"];
if($m != null)
{
	$sql = "DELETE FROM waitingList WHERE mail='$m'";
	$result = $conn->query($sql);
	if($result === FALSE)
		echo"error could not remove user mail: ".$_POST["mailToRemove"]."<br>";
	$ps = $_POST["password"];
	$sql = "INSERT INTO users (mail, password) VALUES('$m', '$ps')";
	$result = $conn->query($sql);
	if($result === FALSE)
		echo"could not add user form waintg list mail: ".$t."<br>";
}
//user_table___________________
echo"<div class='row'><div class='column'>";
$sql = "SELECT * FROM `db1`.`users`";
$result = $conn->query($sql);
if($result->num_rows > 0)
{
	echo"<h3>Users</h3>
	<table>
	<thead><tr><td>mail</td><td>mot de passe</td><td>retirer</td></tr></thead>
	";
	while($row = $result->fetch_assoc())
	{
		echo"
			<td>".$row["mail"]."</td>
			<td>".$row["password"]."</td>
			<td><form method='post'>
			<input type='hidden' name='mailToRemove' value='".$row["mail"]."'>
			<input type='submit' value='retirer'></form></td></tr>
		";
	}
	echo"</table>";
}
//waiting_list___________________
echo"</div><div class='column'>";
$sql = "SELECT * FROM `db1`.`waitingList`";
$result = $conn->query($sql);
if($result->num_rows > 0)
{
	echo"
		<h3>requestes</h3>
		<table>
		<thead><tr><td>mail</td><td>password</td><td>accepter</td><td>refuser</td></tr></thead>
	";
	while($row = $result->fetch_assoc())
	{
		echo"
			<td>".$row["mail"]."</td>
			<td>".$row["password"]."</td>
			<td><form method='post'>
			<input type='hidden' name='acceptRequest' value='".$row["mail"]."'>
			<input type='hidden' name='password' value='".$row["password"]."'>
			<input type='submit' value='accepter'></form></td>
			<td><form method='post'> <input type='hidden' name='refuseRequest' value='".$row["mail"]."'>
			<input type='submit' value='refuser'></form></td></tr>
		";
	}
	echo"</table>";
}
else
	echo"<h3>il n'y a aucune demande </>";
echo"</div></div></div></body>";
?>
