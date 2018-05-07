<?php
    session_start();
    if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] ) {
        header('Location: login.php');
    }
    
    require 'config/config.php';
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->errno) {
        echo $mysqli->error;
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $sql = "UPDATE users SET";

        if ( isset($_POST['name']) && !empty($_POST['name']) ) {
            // User selected album value.
            $sql = $sql . " name = '" . $_POST['name'] . "'"; 
        }
    
        if ( isset($_POST['username']) && !empty($_POST['username']) ) {
            // User selected album value.
            $sql = $sql . ", username = '" . $_POST['username'] . "'"; 
            $_SESSION['username'] = $_POST['username'];
        }

        if ( isset($_POST['email']) && !empty($_POST['email']) ) {
            // User selected album value.
            $sql = $sql . ", email = '" . $_POST['email'] . "'"; 
        }

        if ( isset($_POST['password']) && !empty($_POST['password']) ) {
            // User selected album value.
            $password = password_hash($_POST['password'] , PASSWORD_BCRYPT);
            $sql = $sql . ", password = '" . $password . "'"; 
        }

        $sql = $sql . " WHERE username = '" . $_SESSION['username'] . "';";

        $results = $mysqli->query($sql);
        if ( !$results ) {
            echo $mysqli->error;
            exit();
        }
    }

    $sql_user = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "';";
    $results = $mysqli -> query($sql_user);
    $user = $results->fetch_assoc();

    if ($results == false ) {
        echo $mysqli->error;
        exit();
    }
    $mysqli -> close();
    
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
    <?php include 'nav.php'; ?>
    <div id="main">        
        <div class="container">
            <div class="row">
                <h1 class="col-12 mt-4">Account</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->

        <div class="container">

            <form action="edit.php" method="POST">

                <div class="row mb-3">
                    <div class="font-italic text-danger col-sm-9 ml-sm-auto">
                        <?php 
                            if(isset($error) && !empty($error)) {
                                echo $error;
                            }
                        ?>
                    </div>
                </div> <!-- .row -->
                
                <div class="form-inline row">
                    <h2 class="col-sm-3">Name:</h2>
                    <h4 class="col-sm-6">
                        <?php 
                            echo $user['name'];
                        ?>
                    </h4>
                </div> <!-- .form-group -->

                <div class="form-inline row">
                    <h2 class="col-sm-3">Username:</h2>
                    <!-- <label class="col-sm-6 col-form-label text-sm-left"> -->
                    <h4 class="col-sm-6">
                        <?php 
                            echo $user['username'];
                        ?>
                    </h4>
                    <!-- </label> -->
                    
                </div> <!-- .form-group -->

                <div class="form-inline row">
                    <h2 class="col-sm-3">Password:</h2>
                    <h4 class="col-sm-6">********</h4>

                </div> <!-- .form-group -->
                
                <div class="form-inline row">
                    <h2 class="col-sm-3">Email:</h2>
                    <h4 class="col-sm-6">
                        <?php 
                            echo $user['email'];
                        ?>
                    </h4>
                </div> <!-- .form-group -->

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Edit</button>				
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