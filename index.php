<?php

	$title='WebVillas - Αρχική';
	require ('page_parts/part_header.php');

?>

<main>
	<form action="/action_page.php">
		<table style="width: 100%;">
			<tbody>
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
					<td class="right">Άτομα :</td>
					<td><input type="number" id="quantity" name="quantity" min="1" max="10"></td>
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
				  		<input type="submit" value="Αναζήτηση">
				  	</td>
				</tr>
			</tbody>
		</table>
	</form>
</main>


<?php	require('page_parts/part_footer.php'); ?>