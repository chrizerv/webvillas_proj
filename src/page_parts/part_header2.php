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
			<li style="float:left;"><img src="images/textfx.png" alt="webvillas" width="103px"> </li>
		</ul>
	</nav>
</header>
<a href="index.php">Αρχική</a>