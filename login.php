<?php
	require 'config/config.php';

	session_start();
	if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] ) {
		if ( isset($_POST['username']) && isset($_POST['password']) ) {
			if ( empty($_POST['username']) || empty($_POST['password']) ) {
				$error = "Please enter username and password.";
			} else {
				$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

				$sql_user = "SELECT * FROM users 
					WHERE username = '" . $_POST['username'] . "';";
				
				$results = $mysqli -> query($sql_user);
				$user = $results->fetch_assoc();

				if(!$results) { 
					echo $mysqli -> error;
					exit();
				}

				if(password_verify($_POST['password'], $user['password'])) {
					console.log("SAME HERE");
					$_SESSION['logged_in'] = true;
					$_SESSION['username'] = $_POST['username'];
					header('Location: entry.php');
				}
				else {
					$error = "Username and password do not match";
				}
				$mysqli -> close();
			}
		}
	} else {
		header('Location: entry.php');
	}	

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | Gratitude</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">    	
</head>
<body>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Login</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<form action="login.php" method="POST">

			<div class="form-group row">
				<label for="username-id" class="col-sm-3 col-form-label text-sm-right">Username:</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="username-id" name="username">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password:</label>
				<div class="col-sm-6">
					<input type="password" class="form-control" id="password-id" name="password">
				</div>
			</div> <!-- .form-group -->

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">
					<?php 
						if(isset($error) && !empty($error)) {
							echo $error;
						}
					?>
				</div>
			</div> <!-- .row -->

			<div class="form-group text-center">
				<button type="submit" class="btn btn-primary">Login</button>				
				<a href="index.php" role="button" class="btn btn-light">Cancel</a>
			</div> <!-- .form-group -->
		</form>

	</div> <!-- .container -->
</body>
</html>