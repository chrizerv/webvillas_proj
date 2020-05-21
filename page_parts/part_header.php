<!DOCTYPE html>
<html lang="el">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<title><?php echo $title ?></title>
		<link rel="stylesheet" href="css/style.css">
		<?php
			// Να μπορεί κάποια σελίδα να προσθέσει js , μόνο για δική της χρήση. 
			echo $head_scripts 
		?>
	</head>

	<body>
		<div id="container">
			<header>
				<nav class="nav">
					<ul>
						<li><a href="./register.php">Εγγραφή</a></li>
						<li><a href="./news.html">Σύνδεση</a></li>
					</ul>
				</nav>
				<img src="images/textfx.png" alt="webvillas" class="center"> 
			</header>