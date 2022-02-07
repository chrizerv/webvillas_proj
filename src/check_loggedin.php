<?php 
	
	$loggedin = false;

	session_start();
	if (isset($_SESSION['username']))
		$loggedin = true;


?>