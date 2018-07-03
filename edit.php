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
		require_once "pdo.php";
		$sql="SELECT * from autos where auto_id=:auto_id";
		$stmt=$pdo->prepare($sql);
		$stmt->execute(array(':auto_id'=>$_GET["auto_id"]));
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		if($row === false){
			die('Wrong value for auto_id');
		}
	}
	if(isset($_POST["Edit"])){
		if( (isset($_POST["make"])&&empty($_POST["make"])) || (isset($_POST["model"])&&empty($_POST["model"])) || (isset($_POST["year"])&&empty($_POST["year"])) || (isset($_POST["mileage"])&&empty($_POST["mileage"])) ){
			$_SESSION["message"] = "All fields are required";
			header("Location: edit.php?auto_id=".$_POST["auto_id"]);
			return;
		}
		else if(!is_numeric($_POST["year"]) ){
			 $_SESSION["message"] = "Year must be an integer";
			 header("Location: edit.php?auto_id=".$_POST["auto_id"]);
			 return;
		}
		else if( !is_numeric($_POST["mileage"])){
			 $_SESSION["message"] = "Mileage must be an integer";
			 header("Location: edit.php?auto_id=".$_POST["auto_id"]);
			 return;				
		}
		else if( is_numeric($_POST["year"]) &&  is_numeric($_POST["mileage"]) && !empty($_POST["make"]) && !empty($_POST["make"])){
			require_once "pdo.php";
			$query='update autos set make=:make,model=:model,year=:year,mileage=:mileage where auto_id=:auto_id';
			$stmt=$pdo->prepare($query);
			$stmt->execute(array(
				':make'=>htmlentities($_POST["make"]),
				':model'=>htmlentities($_POST["model"]),
				':year'=>htmlentities($_POST["year"]),
				':mileage'=>htmlentities($_POST["mileage"]),
				':auto_id'=>htmlentities($_POST["auto_id"])));
			$_SESSION["message"] = "Record updated";
			header("Location: index.php");
			return;
		}
	}
	if(isset($_POST["Cancel"])){
		header("Location: index.php");
		return;
	}

	
?>
<?php isset($row["make"])?htmlentities($row["make"]):"";?>
<form method="post">
	<label for="MAKE" ><b>MAKE</label>
	<input type="text" name="make" value=<?php $var=isset($row["make"])?htmlentities($row["make"]):"";echo $var;?> id="MAKE">
	<br>
	<label for="MODEL" ><b>MODEL</label>
	<input type="text" name="model" value=<?php $var=isset($row["model"])?htmlentities($row["model"]):"";echo $var;?> id="MODEL">
	<br
	<label for="YEAR" ><b>YEAR</label>
	<input type="text" name="year" value=<?php $var=isset($row["year"])?htmlentities($row["year"]):"";echo $var;?> id="YEAR">
	<br>
	<label for="MILEAGE" ><b>MILEAGE</label>
	<input type="text" name="mileage" value=<?php $var=isset($row["mileage"])?htmlentities($row["mileage"]):"";echo $var;?> id="MILEAGE">
	<br>
	<input type="hidden" name="auto_id" value=<?php $var=isset($row["auto_id"])?htmlentities($row["auto_id"]):"";echo $var;?>>
	<input type="submit" name="Edit" value="Save">
	<input type="submit" name="Cancel" value="Cancel">
</form>
