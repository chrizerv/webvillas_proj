<!DOCTYPE html>
<html lang="el">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<title>WebVillas - Σύνδεση</title>
		<link rel="stylesheet" href="css/style.css">
		<style type="text/css">
			
			main {
					width: 50%;
					margin: 6em auto;
					background-color: #d2d2d2;
				}

		</style>
	</head>
  	<body>
		<div id="container">

			<?php require('page_parts/part_header2.php'); ?>
			<a href="index.php">Αρχική</a>
    		<main>
    			<?php 
    				if (isset($_GET['msg'])){
    					$msg = $_GET['msg'];

    					if ($msg == 1){ ?>
    						<p style="text-align: center; color: green;">Η εγγραφή σας ήταν επιτυχής.</p>
    						<p style="text-align: center; color: red;">Η αποστολή email για την ενεργοποίηση του λογαριασμού σας δέν ήτανε επιτυχής. Συνδεθείτε και προσπαθήστε ξανά.</p>
    					<?php  
    					} elseif ($msg == 2){ ?>
    						<p style="text-align: center; color: green;">Η εγγραφή σας ήταν επιτυχής.</p>
    						<p style="text-align: center; color: green;">Σας έχει σταλεί email για την ενεργοποίηση του λογαριασμού σας. </p> 
    					<?php
    					} elseif ($msg == 3){ ?>
    						<p style="text-align: center; color: red;"> Λανθασμένα στοιχεία σύνδεσης. Δοκιμάστε ξανά </p>
					
						<?php
						} elseif ($msg == 4){ ?>
    					
    						<p style="text-align: center; color: brown;">Ο λογαριασμός σας είναι απενεργοποιημένος.</p>
    						<p style="text-align: center;"><a href="#">Ξαναστείλε email</a></p>


    					<?php
    					}
					}
    			?>

       			<form action="./con_login.php" method="post">
					<table style="width: 100%;">
						<tbody>
							<tr>
					        	<td class="right" ><strong>username</strong>:</td>
					        	<td>
					      			<input type="text" name="username" id="username" size="25" maxlength="25" 
					           			onfocus="highlightOn('username');" onblur="highlightOff('username');" />
					        	</td>
					      	</tr>
					      	<tr>
					        	<td class="right"><strong>password</strong>:</td>
					       		<td>
					          		<input type="password" name="password" id="password" size="25" maxlength="25"
					                 onfocus="highlightOn('password');" onblur="highlightOff('password');" />
					        	</td>
					      	</tr>
					      	<tr>
								<td>&nbsp;</td>
								<td>
									  
								  	<input type="submit" value="Σύνδεση">
								</td>
							</tr>        
						</tbody>
					</table>
				</form>
    		</main>

			<?php require('page_parts/part_footer.php'); ?>

		</div>
	</body>
</html>