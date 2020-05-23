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

		<script type="text/javascript">

			var finalResults = new Array(3).fill(false);
			

			function validateField(field){
				
				switch(field) {

					case 'username':
						
						var username=document.getElementById("username");
				 		var acceptedChars = new RegExp(/^\w{8,20}$/);
				 		
						if ( !acceptedChars.test(username.value) ){
							finalResults[0] = false;
							username.style.border="solid 2px red";
							alert('wrong username');
							//style = document.getElementById(element).style;   //αποθήκευσε το τρέχον στυλ
  							
						}else{
							finalResults[0] = true;
							username.style.border="solid 2px green";
						}


					break;

					case 'password':
						
						var password=document.getElementById("password");
				 		var acceptedChars = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,128}$/);
				 		
						if ( !acceptedChars.test(password.value) ){
							finalResults[1] = false;
							password.style.border="solid 2px red";
							alert('wrong password');
							//style = document.getElementById(element).style;   //αποθήκευσε το τρέχον στυλ
  							
						}else{
							finalResults[1] = true;
							password.style.border="solid 2px green";
						}


					break;

					case 'email':

						
						var email=document.getElementById("email");
				 		var acceptedChars = new RegExp(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);
				 		
						if ( !acceptedChars.test(email.value) ){
							finalResults[2] = false;
							email.style.border="solid 2px red";
							alert('wrong email');
							//style = document.getElementById(element).style;   //αποθήκευσε το τρέχον στυλ
  							
						}else{
							finalResults[2] = true;
							email.style.border="solid 2px green";
						}

					break;


				}	
			}
			 
		</script>
	</head>
  	<body>
		<div id="container">

			<?php require('page_parts/part_header2.php'); ?>
			<a href="index.php">Αρχική</a>
    		<main>

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