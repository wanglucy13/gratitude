<?php
	require 'config/config.php';
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {

		if (!isset($_POST['email']) || empty($_POST['email'])
			|| !isset($_POST['username']) || empty($_POST['username'])
			|| !isset($_POST['password']) || empty($_POST['password'])) {
			$error = "Please fill out all required fields.";
		}
		else {
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if ( $mysqli->connect_errno ) {
				echo $mysqli->connect_error;
				exit();
			}

			$sql_registered = "SELECT * FROM users 
				WHERE username = '" . $_POST['username'] . "' 
				OR email = '" . $_POST['email'] . "';";

			$results_registered = $mysqli -> query($sql_registered);

			if(!$results_registered) { 
				echo $mysqli -> error;
				exit();
			}

			if($results_registered -> num_rows > 0) {
				$error = "Username or email is already taken";
			}
			else {
				// $password = hash('sha256', $_POST['password']);
				$password = password_hash($_POST['password'] , PASSWORD_BCRYPT);

				$sql_user = "INSERT INTO users(username, password, email, name) 
					VALUES('" 
						. $_POST['username'] . "', '" 
						. $password . "', '"
						. $_POST['email'] . "', '"
						. $_POST['fname'] . " " . $_POST['lname'] .
					"');";

				$results = $mysqli -> query($sql_user);

				if(!$results) { 
					echo $mysqli -> error;
					exit();
				}

				$to = $_POST['email'];
				$subject = "Welcome!";
				$message = "Hello from Gratitude! Thanks so much for signing up. We hope that this journal will bring happiness to your life. <br>Best,<br>The Gratitude Team";
				$headers = "Content-Type: text/html"
							. "\r\n"
							. "From: gratitude@gratitude.com"
							. "\r\n"
							. "Reply-To: gratitude@gratitude.com";

				header('Location: index.php');
			}
			$mysqli -> close();
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register | Gratitude</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">    	
</head>
<body>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Register</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<form action="register.php" method="POST">

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">
					<?php 
						if(isset($error) && !empty($error)) {
							echo $error;
						}
					?>
				</div>
			</div> <!-- .row -->
			
			<div class="form-group row">
				<label for="fname-id" class="col-sm-3 col-form-label text-sm-right">First Name:</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="fname-id" name="fname">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="lname-id" class="col-sm-3 col-form-label text-sm-right">Last Name:</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="lname-id" name="lname">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="username-id" class="col-sm-3 col-form-label text-sm-right">Username:</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="username-id" name="username">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password:</label>
				<div class="col-sm-6">
					<input type="password" class="form-control" id="password-id" name="password" onkeyup='doesMatch();'>
				</div>
            </div> <!-- .form-group -->

            <div class="form-group row">
				<label for="password-confirm-id" class="col-sm-3 col-form-label text-sm-right">Confirm Password:</label>
				<div class="col-sm-6">
					<input type="password" class="form-control" id="password-confirm-id" name="password-confirm" onkeyup='doesMatch();'>
				</div>
				<div class="col-sm-3 col-form-label" id="pass-match" ></div>
				
			</div> <!-- .form-group -->
            
            <div class="form-group row">
				<label for="email-id" class="col-sm-3 col-form-label text-sm-right">Email:</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="email-id" name="email">
				</div>
            </div> <!-- .form-group -->

			<div class="form-group text-center">
				<button type="submit" class="btn btn-primary">Register</button>				
				<a href="index.php" role="button" class="btn btn-light">Cancel</a>
			</div> <!-- .form-group -->
		</form>

	</div> <!-- .container -->
</body>
<script>
	var doesMatch = function() {
		if (document.getElementById('password-id').value == document.getElementById('password-confirm-id').value && document.getElementById('password-id').value != '' && document.getElementById('password-confirm-id').value != '') {
			document.getElementById('pass-match').classList.remove('text-danger');			
			document.getElementById('pass-match').classList.add('text-success');
			document.getElementById('pass-match').innerHTML = 'Passwords Match';
		} else {
			document.getElementById('pass-match').classList.add('text-danger');			
			document.getElementById('pass-match').classList.remove('text-success');
			document.getElementById('pass-match').innerHTML = 'Passwords Do Not Match';
		}
	}
</script>
</html>