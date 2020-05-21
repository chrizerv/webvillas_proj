<?php
	
	$title='WebVillas - Εγγραφή';
	$head_scripts = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<style>main{
	width: 50%;
	height: auto;
	margin: auto;
	background-color: #d2d2d2;
  
}</style>';
  	require ('page_parts/part_header2.php');

?>

<main>
	<form action="/action_page.php">
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
		        	<td class="right"><strong>e-mail</strong>:</td>
		        	<td>
		          		<input type="text" name="email" id="email" size="30" maxlength="100" />
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
						<input name="reset" type="reset" id="reset" value="Επαναφορά" />  
					  	<input type="submit" value="Εγγραφή">
					</td>
				</tr>    
			</tbody>
		</table>
	</form>
</main>


<?php require('page_parts/part_footer.php'); ?>
