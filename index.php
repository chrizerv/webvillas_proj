<?php
	require './check_loggedin.php';
?>

<!DOCTYPE html>
<html lang="el">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<title></title>
		<link rel="stylesheet" href="css/style.css">
		<style type="text/css">
		
			main {
					width: 50%;
					margin: 1em auto;
					background-color: #d2d2d2;
				}

		</style>
	</head>
  	<body>
		<div id="container">

			<?php require('page_parts/part_header.php'); ?>
			
    		<main>
    			<form action="./search_results.php" method="GET">
					<table style="width: 100%;">
						<tbody>
							<tr>
								<td class="right">Νομός: </td>
								<td>				    
									<select id="prefecture" name="prefecture">
										<option disabled selected value> -- Παρακαλώ επιλέξτε -- </option>
					      				<option value="Αθηνών">Αθηνών</option>
				      					<option value="Ανατολικής Αττικής">Ανατολικής Αττικής</option>
									    <option value="Δυτικής Αττικής">Δυτικής Αττικής</option>
								     	<option value="Πειραιά">Πειραιά</option>
									    <option value="Ευβοίας">Ευβοίας</option>
										<option value="Ευρυτανίας">Ευρυτανίας</option>
										<option value="Φωκίδας">Φωκίδας</option>
									    <option value="Χαλκιδικής">Χαλκιδικής</option>
										<option value="Ημαθίας">Ημαθίας</option>
										<option value="Κιλκίς">Κιλκίς</option>
										<option value="Πέλλας">Πέλλας</option>
										<option value="Πιερίας">Πιερίας</option>
										<option value="Σερρών">Σερρών</option>
										<option value="Θεσσαλονίκης">Θεσσαλονίκης</option>
										<option value="Καρδίτσας">Καρδίτσας</option>
										<option value="Λάρισας">Λάρισας</option>
										<option value="Μαγνησίας">Μαγνησίας</option>
										<option value="Τρικάλων">Τρικάλων</option>
								    </select>
							   	</td>
							</tr>
							<tr>
								
								<td class="right">Άτομα :</td>
									<td><input type="number" id="individuals" name="individuals" min="1" max="10" size="2"></td>
							</tr>
							<tr>
								<td class="right">Αστέρων :</td>
			  					<td><input type="number" id="stars" name="stars" min="1" max="3"  size="1"></td>
							</tr>
							<tr>
								<td class="right">Εξοπλισμός :</td>
			  					<td>
			  						<label>
										<input type="checkbox" id="equipment1" name="equipment[]" value="Πισίνα">Πισίνα
									</label>
									<br>
									<label> 
										<input type="checkbox" id="equipment2" name="equipment[]" value="Γυμναστήριο">Γυμναστήριο
									</label>
									<br>
									<label>
										<input type="checkbox" id="equipment3" name="equipment[]" value="Σάουνα">Σάουνα
									</label>
									<br>
									<label>
										<input type="checkbox" id="equipment4" name="equipment[]" value="Παιδική Χαρά">Παιδική Χαρά
									</label>
			  					</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							  	<td>
							  		<input name="reset" type="reset" id="reset" value="Επαναφορά" />  
							  		<input type="submit" value="Αναζήτηση">
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