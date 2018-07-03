<?php
	session_start();
	if(!isset($_SESSION["username"])){
		die("Access Denied");
	}
	else{
		if(isset($_SESSION["message"])){
			echo ($_SESSION["message"]);
			unset ($_SESSION["message"]);
		}
		if(isset($_POST["Cancel"])){
			header("Location: index.php");
			return;
		}
		if(isset($_POST["Add"])){
			if( (isset($_POST["make"])&&empty($_POST["make"])) || (isset($_POST["model"])&&empty($_POST["model"])) || (isset($_POST["year"])&&empty($_POST["year"])) || (isset($_POST["mileage"])&&empty($_POST["mileage"])) ){
				$_SESSION["message"] = "All fields are required";
				header("Location: add.php");
				return;
			}
			else if(!is_numeric($_POST["year"]) ){
				 $_SESSION["message"] = "Year must be an integer";
				 header("Location: add.php");
				 return;
			}
			else if( !is_numeric($_POST["mileage"])){
				 $_SESSION["message"] = "Mileage must be an integer";
				 header("Location: add.php");
				 return;				
			}
			else if( is_numeric($_POST["year"]) &&  is_numeric($_POST["mileage"]) && !empty($_POST["make"]) && !empty($_POST["make"])){
				require_once "pdo.php";
				$query='insert into autos (make,model,year,mileage) values (:make,:model,:year,:mileage);';
				$stmt=$pdo->prepare($query);
				$stmt->execute(array(
					':make'=>htmlentities($_POST["make"]),
					':model'=>htmlentities($_POST["model"]),
					':year'=>htmlentities($_POST["year"]),
					':mileage'=>htmlentities($_POST["mileage"])));
				$_SESSION["message"] = "Record added";
				header("Location: index.php");
				return;
			}
		}
	}
?>
<form method="post">
	<label for="MAKE" ><b>MAKE</label>
	<input type="text" name="make" id="MAKE">
	<br>
	<label for="MODEL" ><b>MODEL</label>
	<input type="text" name="model" id="MODEL">
	<br
	<label for="YEAR" ><b>YEAR</label>
	<input type="text" name="year" id="YEAR">
	<br>
	<label for="MILEAGE" ><b>MILEAGE</label>
	<input type="text" name="mileage" id="mileage">
	<br>
	<input type="submit" name="Add" value="Add">
	<input type="submit" name="Cancel" value="Cancel">
</form>
