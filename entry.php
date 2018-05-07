<?php
    session_start();
    require 'config/config.php';
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->errno) {
        echo $mysqli->error;
        exit();
    }

    $sql_user = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "';";
    $results = $mysqli -> query($sql_user);
    $user = $results->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(empty($_POST['entry']) || !isset($_POST['entry']) ) {
            header('Location: entry.php');
        }
        else {
            $entry = htmlspecialchars($_POST['entry']);

            $today = date("Y-m-d");
            echo $today;

            $user_id = $user['user_id'];

            $sql_entry = "INSERT INTO entries(entry, date, user)
					VALUES ('" 
					. $entry . "', '"
					. $today . "', "
                    . $user_id . ");";

            $results_entry = $mysqli -> query($sql_entry);

			if(!$results_entry) { 
				echo $mysqli -> error;
				exit();
            }

            header('Location: journal.php');

            $mysqli -> close();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Grateful | Gratitude</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">  
	<link rel="stylesheet" href="style.css">    	    	
</head>
<body>

    <?php include 'nav.php'; ?>
    <div id="main">
        <div class="container">
            <div class="row">
                <h1 class="col-12">I'm Grateful For...</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->

        <div class="container">
            <form action="entry.php" method="POST">
                <div class="row mb-3">
                    <div class="font-italic text-danger col-sm-9 ml-sm-auto">
                        <?php 
                            if(isset($error) && !empty($error)) {
                                echo $error;
                            }
                        ?>
                    </div>
                </div> <!-- .row -->
                
                <div class="form-group">
                    <textarea placeholder="What are you grateful for today?" autofocus class="form-control" rows="4" id="entry" name="entry"></textarea>
                </div> <!-- .form-group -->

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Enter</button>				
                </div> <!-- .form-group -->
            </form>

        </div> <!-- .container -->
    </div>
</body>
</html>