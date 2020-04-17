<?php
	session_start();
	session_destroy();
	unset($_SESSION['user_name']);
	unset($_SESSION['user_id']);
	$_SESSION['message'] = 'You are now logged out';
	header("location: homepage.html");

?>