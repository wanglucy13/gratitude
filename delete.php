<?php
	session_start();
	require 'config/config.php';
	
	if ( !isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] ) {
		header('Location: login.php');
	}

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}
	
	$sql_user = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "';";
	$results = $mysqli -> query($sql_user);
	$user = $results->fetch_assoc();

	$mysqli->set_charset('utf8');

	$sql = "DELETE FROM entries
					WHERE entry_id = " . $_GET['entry_id'] . ";";
	header('Location: journal.php');
					

	$results = $mysqli->query($sql);
	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();

?>
