<head>
	<title>Anit Aggarwal</title>
</head>
<h1>Welcome to Autos Database</h1>
<?php
	session_start();
	if(isset($_SESSION["message"])){
		echo ($_SESSION["message"]);
		unset ($_SESSION["message"]);
	}
	if(!isset($_SESSION["username"])){
?>
		<a href="login.php">Please log in</a>
<?php
	}
	else{
		require_once "pdo.php";
		$sql="SELECT * from autos";
		$query=$pdo->query($sql);
		$count=0;
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			$count++;
			if($count==1){
				echo("<table border=>"."\n");
				echo("<tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr>");
			}
			echo("<tr><td>");
			echo($row["make"]);
			echo("</td><td>");
			echo($row["model"]);
			echo("</td><td>");
			echo($row["year"]);
			echo("</td><td>");
			echo($row["mileage"]);
			echo("</td><td>");
			echo("<a href=\"edit.php?auto_id=".$row["auto_id"]."\">Edit</a>"."/"."<a href=\"delete.php?auto_id=".$row["auto_id"]."\">Delete</a>");			
			echo("</td></tr>\n");
			
		}
		if($count==0){
			echo("No rows found"."<br>");
		}
			echo "</table>\n";
?>			

		<a href="add.php">Add New Entry</a>
		<br><a href="logout.php">Log Out</a>
<?php
	}
?>