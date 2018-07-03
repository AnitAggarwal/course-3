<?php
	session_start();
	if(!isset($_SESSION["username"])){
		die("Access Denied");
	}
	if(isset($_SESSION["message"])){
		echo ($_SESSION["message"]);
		unset ($_SESSION["message"]);
	}
	if(isset($_GET["auto_id"])){
			echo("Are you sure you want to delete this record?");
	}
	if(isset($_POST["delete"])){
		require_once "pdo.php";
		$query='delete from autos  where auto_id=:auto_id';
		$stmt=$pdo->prepare($query);
		$stmt->execute(array(':auto_id'=>htmlentities($_POST["auto_id"])));
		$_SESSION["message"] = "Record deleted<br>";
		header("Location: index.php");
		return;
	}
	
	if(isset($_POST["Cancel"])){
		header("Location: index.php");
		return;	
	}
	
?>

<form method="post">
	<input type="hidden" name="auto_id" value=<?=$_GET["auto_id"]?>>
	<input type="submit" name="delete" value="Delete">
	<input type="submit" name="Cancel" value="Cancel">
</form>
	