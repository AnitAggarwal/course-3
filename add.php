<?php
	session_start();
	if(!isset($_SESSION["name"])){
		die("Name parameter missing");
	}
	else{
		if(isset($_SESSION["message"])){
			echo ($_SESSION["message"]);
			unset ($_SESSION["message"]);
		}
		if(isset($_POST["Cancel"])){
			header("Location: index.php");
		}
		if(isset($_POST["Add"])){
			if(empty($_POST["make"])){
				$_SESSION["message"] = "Make is required.";
				header("Location: add.php");
				return;
			}
			else if(!is_numeric($_POST["year"]) || !is_numeric($_POST["mileage"])){
				 $_SESSION["message"] = "Mileage and year must be numeric";
				 header("Location: add.php");
				 return;
			}
			else if( is_numeric($_POST["year"]) &&  is_numeric($_POST["mileage"]) && !empty($_POST["make"]) ){
				require_once "pdo.php";
				$query='insert into autos (make,year,mileage) values (:make,:year,:mileage);';
				$stmt=$pdo->prepare($query);
				$stmt->execute(array(
					':make'=>htmlentities($_POST["make"]),
					':year'=>htmlentities($_POST["year"]),
					':mileage'=>htmlentities($_POST["mileage"])));
				$_SESSION["message"] = "Record Inserted";
				header("Location: view.php");
				return;
			}
		}
	}
?>
<form method="post">
	<label for="MAKE" ><b>MAKE</label>
	<input type="text" name="make" id="MAKE">
	<br>
	<label for="YEAR" ><b>YEAR</label>
	<input type="text" name="year" id="YEAR">
	<br>
	<label for="MILEAGE" ><b>MILEAGE</label>
	<input type="text" name="mileage" id="mileage">
	<br>
	<input type="submit" name="Add" value="Add">
	<input type="submit" name="Cancel" value="Cancel">
</form>
