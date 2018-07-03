<?php
	session_start(); 
	if(isset($_POST["email"])&&isset($_POST["pass"])&& !empty($_POST["pass"]&& !empty($_POST["email"]))){
		$len=strlen($_POST["email"]);
		$dummy=$_POST["email"];
		$at=false;
		for($i=0;$i<$len;$i++){
			if($dummy[$i] === '@'){
				$at=true;
				break;
			}
		}
		if($at === false){
			$_SESSION["message"]='<p style="color:red">Email must have an at-sign (@)';
			header("Location: login.php");
			return;
		}
		$salt='XyZzy12*_';
		$hash=$salt.$_POST["pass"];
		$pwd=hash('md5','XyZzy12*_php123');
		$md5=hash('md5',$hash);
		if($md5 === $pwd){
			error_log("Login success ".$_POST['email']);
			$_SESSION["username"]=$_POST['email'];
			header("Location: index.php");
			return ;
		}
		else{
			error_log("Login fail ".$_POST['email']."$md5");
			$_SESSION["message"]="<p style=\"color:red\">Incorrect password";
			header("Location: login.php");
			return ;
		}
	}
	else if((isset($_POST["email"])&&empty($_POST["email"]) ) || (isset($_POST["pass"])&&empty($_POST["pass"]) )){
			$_SESSION["message"]="<p style=\"color:red\">User name and password are required";
			header("Location: login.php");
			return;
	}
	else if(isset($_SESSION["message"])){
		echo($_SESSION["message"]);
		unset($_SESSION["message"]);
	}
?>
<head>
	<title>Anit Aggarwal</title>
</head>
<h1>Please Log In
<form method="post">
	<input type="text" name="email">
	<input type="text" name="pass">
	<input type="submit" value="Log In">	
</form>