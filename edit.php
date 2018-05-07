<?php
    session_start();
    if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] ) {
        header('Location: login.php');
    }
    
    require 'config/config.php';

    // DB Connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ( $mysqli->connect_errno ) {
        echo $mysqli->connect_error;
        exit();
    }

    $mysqli->set_charset('utf8');

    // Genres:
    $sql_user = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "';";
    $results = $mysqli -> query($sql_user);
    if ($results == false ) {
        echo $mysqli->error;
        exit();
    }
    $user = $results->fetch_assoc();

    // Close DB Connection
    $mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Account | Gratitude</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
	<style>
	.form-check-label {
		padding-top: calc(.5rem - 1px * 2);
		padding-bottom: calc(.5rem - 1px * 2);
		margin-bottom: 0;
	}
</style>
</head>
<body>
	<?php include 'nav.php'; ?>
    <div id="main">
        <div class="container">
            <div class="row">
                <h1 class="col-12 mt-4 mb-4">Edit Account</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->
        <div class="container">
            <form action="account.php" method="POST">
                <div class="form-group row">
                    <label for="name-id" class="col-sm-3 col-form-label text-sm-right">
                        Name:
                    </label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="name-id" name="name" value="<?php echo $user['name']; ?>">
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label for="username-id" class="col-sm-3 col-form-label text-sm-right">
                        Username:
                    </label>
                    <div class="col-sm-7">
                        <input type="text" name="username" id="username-id" class="form-control" value="<?php echo $user['username']; ?>">
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label for="email-id" class="col-sm-3 col-form-label text-sm-right">
                        Email:
                    </label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="email-id" name="email" value="<?php echo $user['email']; ?>">
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label for="password-id" class="col-sm-3 col-form-label text-sm-right">
                        Password: 
                    </label>
                    <div class="col-sm-7">
                        <input type="password" name="password" min="0" id="password-id" class="form-control">
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label for="password-confirm-id" class="col-sm-3 col-form-label text-sm-right">
                        Confirm Password:
                    </label>
                    <div class="col-sm-7">
                        <input type="password" name="password-confirm" min="0" id="password-confirm-id" class="form-control" onkeyup="doesMatch();">
                        <div class="col-sm-6 col-form-label" id="pass-match" ></div>
                        
                    </div>
                </div> <!-- .form-group -->
                

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-light">Reset</button>
                </div> <!-- .form-group -->
            </form>
        </div> <!-- .container -->
    </div>
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