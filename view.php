<?php
	session_start();
	if(! isset($_SESSION["name"])){
		die('Not logged in.');
	}
	if(isset($_SESSION["message"])){
		echo('<p style="color: green;">'.htmlentities($_SESSION["message"])."</p>\n");
		unset($_SESSION["message"]);
	}
	
	require_once "pdo.php";	
	$query=$pdo->query("SELECT * from autos;");
	echo("<table border=2>"."\n");
	while($row=$query->fetch(PDO::FETCH_ASSOC)){
		echo("<tr><td>");
		echo($row["make"]);
		echo("</td><td>");
		echo($row["year"]);
		echo("</td><td>");
		echo($row["mileage"]);
		echo("</td></tr>\n");
	}
	echo "</table>\n";
?>

<a href="add.php">Add New</a>
<a href="logout.php">Logout</a>