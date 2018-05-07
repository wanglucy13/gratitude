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
 

    $sql_user = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "';";
    $results = $mysqli -> query($sql_user);
    if ($results == false ) {
        echo $mysqli->error;
        exit();
    }
    $user = $results->fetch_assoc();

    $sql_entries = "SELECT * FROM entries WHERE entry IS NOT NULL AND user = " . $user['user_id'] . " ORDER BY date DESC;";
    $results_entries = $mysqli->query($sql_entries);

    if ($results_entries == false ) {
        echo $mysqli->error;
        exit();
    }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>About | Gratitude</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">    	
</head>
<body>

    <?php include 'nav.php'; ?>
    <div id="main">
        <div class="container">
            <div class="row">
                <h1 class="col-12 mt-4">Journal</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->
        <form action="delete.php" method="POST">
            <div class="container">
                <div class="row mb-3">
                    <div class="font-italic text-danger col-sm-9 ml-sm-auto">
                        <?php 
                            if(isset($error) && !empty($error)) {
                                echo $error;
                            }
                        ?>
                    </div>
                </div> <!-- .row -->

                <?php while ($row = $results_entries->fetch_assoc() ) : ?>
                    <div class="container row">
                        <div class="col-11">
                            <h3>
                                <?php 
                                    $date = date('F d, Y', strtotime($row['date']));
                                    echo $date; 
                                ?>
                            </h3>
                        </div>
                        <a href="delete.php?entry_id=<?php echo $row['entry_id']; ?>" style="border:none;color:gray;" onclick="return confirm('You are about to delete this entry.');">
                            &times;
                        </a>
                        <div class="col-12" style="word-break:break-all">
                            <h4>I was grateful for... <?php echo $row['entry']; ?></h4>
                        </div>
                    </div> <!-- .form-group -->
                <hr>
                <?php endwhile; ?>

            </div> <!-- .container -->
        </form>
    </div>
</body>
</html>