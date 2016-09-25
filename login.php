<?php

//Define error variables and set to zero
$usernameErr = $passwordErr = ""; 

//Connects to your Database
include ('info.php');

//if the login form is submitted 
if (isset($_POST['submit'])) {

	// makes sure they filled it in
 	if(empty($_POST['username'])){
 		$usernameErr = "* Nombre de usuario requerido";
 	}
 	if(empty($_POST['pass'])){
 		$passwordErr= "* Contraseña requerida";
 	}
 	// var_dump($usernameErr);
 	// var_dump($passwordErr);

 	// // checks it against the database
 	// if (!get_magic_quotes_gpc()){
 	// 	@$_POST['email'] = addslashes($_POST['email']);
 	// }

 	$check = mysql_query("SELECT * FROM users WHERE username = '".$_POST['username']."'")or die("Error...\n". mysql_error());

	//Gives error if user doesn't exist
	// $check2 = mysqli_num_rows($check);
	// if ($check2 == 0){
	// 	die('That user does not exist in our database.<br /><br />If you think this is wrong <a href="login.php">try again</a>.');
	// }

	while($info = mysql_fetch_array( $check )){
		$_POST['pass'] = stripslashes($_POST['pass']);
	 	$info['password'] = stripslashes($info['password']);
	 	$_POST['pass'] = md5($_POST['pass']);

		//gives error if the password is wrong
	 	if ($_POST['pass'] != $info['password']){
	 		die('Contraseña incorrecta,<a href="login.php">intente de nuevo</a>.'); 
	 	}
		
		else{ // if login is ok we start session and redirect to members area
			session_start();
			$_SESSION['username'] = $info['username'];
			$_SESSION['logged'] = TRUE;
			header("Location: index.php"); 
		}
	}
}
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="css/view2.css">
	<title>Servitalleres - Inicio</title>
</head>
<body id="main-body">
	<div class="container">
		<div id="loginform">
		 	<form action="" method="post"> 
				<div class="company-logo">
					<img src="img/logo1.jpg">
				</div>
				<div>
					<p>Nombre de usuario:</p>
				</div>
				<div class="input-group">
					<input type="text" class="form-control" name="username" maxlength="40"> 
					<span><?php echo $usernameErr;?></span>
				</div>
				<div>
					<p>Contraseña:</p>
				</div> 
				<div class="input-group">
					<input type="password" class="form-control" name="pass" maxlength="50" autocomplete="new-password">
					<span><?php echo $passwordErr;?></span>
				</div>
				<br>
				<tr><td colspan="2" align="right"><input type="submit" name="submit" value="Iniciar Sesión"></td></tr>
	 		</form>
		</div>
 	</div>
 </body>
 </html> 

