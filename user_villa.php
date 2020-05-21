<!DOCTYPE html>
<html lang="el">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<title>WebVillas - Η villa μου</title>
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
			
    		<main>
    			<form action="/action_page.php">
					<table style="width: 100%;">
						<tbody>
							<tr>
								<td class="right">Τίτλος :</td>
								<td><input type="text" id="title" name="title"></td>
							</tr>
							<tr>
								<td class="right">Νομός: </td>
								<td>				    
									<select id="country" name="country">
					      				<option value="australia">Αθηνών</option>
				      					<option value="canada">Ανατολικής Αττικής</option>
									    <option value="usa">Δυτικής Αττικής</option>
								     	<option value="canada">Πειραιά</option>
									    <option value="usa">Ευβοίας</option>
										<option value="canada">Ευρυτανίας</option>
										<option value="usa">Φωκίδας</option>
									    <option value="canada">Χαλκιδικής</option>
										<option value="usa">Ημαθίας</option>
										<option value="usa">Κιλκίς</option>
										<option value="usa">Πέλλας</option>
										<option value="usa">Πιερίας</option>
										<option value="usa">Σερρών</option>
										<option value="usa">Θεσσαλονίκης</option>
										<option value="usa">Καρδίτσας</option>
										<option value="usa">Λάρισας</option>
										<option value="usa">Μαγνησίας</option>
										<option value="usa">Τρικάλων</option>
								    </select>
							   	</td>
							</tr>
							<tr>
								<td class="right">Διεύθυνση :</td>
								<td><input type="text" id="address" name="address"></td>
							</tr>
							<tr>
								<td class="right">Τηλέφωνο :</td>
								<td>
									<input type="tel" id="phone" name="phone" placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required>
								</td>
							</tr>
							<tr>
								<td class="right">Άτομα :</td>
								<td><input type="number" id="quantity" name="quantity" min="1" max="10"></td>
							</tr>
							<tr>
								<td class="right">Latitude :</td>
								<td> <input type="text" name="latitude"></td>
							</tr>
							<tr>
								<td class="right">Longitude :</td>
								<td> <input type="text" name="longitude"></td>
							</tr>
							<tr>
								<td class="right">Αστέρων :</td>
			  					<td><input type="number" id="quantity" name="quantity" min="1" max="3"></td>
							</tr>
							<tr>
								<td class="right">Εξοπλισμός :</td>
			  					<td>
			  						<label>
										<input type="checkbox" id="equipment1" name="equipment1" value="Car">Πισίνα
									</label>
									<br>
									<label> 
										<input type="checkbox" id="equipment2" name="equipment2" value="Boat">Γυμναστήριο
									</label>
									<br>
									<label>
										<input type="checkbox" id="equipment3" name="equipment3" value="Boat">Σάουνα
									</label>
									<br>
									<label>
										<input type="checkbox" id="equipment4" name="equipment4" value="Boat">Παιδική Χαρά
									</label>
			  					</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							  	<td>
							  		<input name="reset" type="reset" id="reset" value="Επαναφορά" />  
							  		<input type="submit" value="Καταχώρηση">
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