<header>
	<nav class="nav">
		<ul>
			<?php if (!$loggedin) { ?>
				<li><a href="./register.php">Εγγραφή</a></li>
				<li><a href="./login.php">Σύνδεση</a></li>
			<?php }else { ?>
				<li><a href="./logout.php">Αποσύνδεση</a></li>
				<li><a href="./user_villa.php">Η villa μου</a></li>
			<?php }?>
		</ul>
	</nav>
	<img src="images/textfx.png" alt="webvillas" class="center"> 
</header>