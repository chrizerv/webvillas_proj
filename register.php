<!DOCTYPE html>
<html lang="el">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<title>WebVillas - Εγγραφή</title>
		<link rel="stylesheet" href="css/style.css">
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<style type="text/css">
			
			main {
					width: 50%;
					margin: 6em auto;
					background-color: #d2d2d2;
				}

		</style>
		<script type="text/javascript" src="./js/register.js"></script>
				
	</head>
  	<body>
		<div id="container">

			<?php require('page_parts/part_header2.php'); ?>
			

    		<main>
    			<?php 
    				if (isset($_GET['msg'])){
    					$msg = $_GET['msg'];

    					if ($msg == 0){ ?>
    						<p style="text-align: center; color: red;">Αποτυχία εγγραφής. Δοκιμάστε ξανά!</p>
    					<?php  
    					}
					}

    			?>

       			<form name="registerForm" action="./con_register.php" method="post" onsubmit="return validateForm()">
					<table style="width: 100%;">
						<tbody>
							<tr>
					        	<td class="right" ><strong>username</strong>:</td>
					        	<td>
					      			<input type="text" name="username" id="username" size="20" maxlength="20" 
					           			 onblur="validateField('username');"/>

					        	</td>
					      	</tr>
					      	<tr>
					        	<td class="right"><strong>password</strong>:</td>
					       		<td>
					          		<input type="password" name="password" id="password" size="20" maxlength="128"
					          			onblur="validateField('password');"/>
					        	</td>
					      	</tr>
					      	<tr>
					        	<td class="right"><strong>confirm password</strong>:</td>
					       		<td>
					          		<input type="password" name="conpassword" id="conpassword" size="20" maxlength="128"
					          			onblur="validateField('conpassword');" />
					        	</td>
					      	</tr>
					      	<tr>
					        	<td class="right"><strong>e-mail</strong>:</td>
					        	<td>
					          		<input type="text" name="email" id="email" size="30" maxlength="254" 
					          			onblur="validateField('email');"/>
					        	</td>
					      	</tr>
					      	<tr>
					      		<td>&nbsp;</td>
					      		<td>
					      			<div class="g-recaptcha" data-sitekey="6LcepfcUAAAAAEphOOV1aA66VLyqL2xyEQBleamp"></div>
					      		</td>
					      	</tr>
					      	<tr>
								
								<td>&nbsp;</td>
								<td>
								  	<input type="submit" value="Εγγραφή">
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