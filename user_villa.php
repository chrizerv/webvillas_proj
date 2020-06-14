<?php
	require './check_loggedin.php';
	session_start();

	if (!isset($_SESSION['username'])){
		session_destroy();
		header('Location: login.php');
		exit(-1);
	}

	$mode = "insert";
	$username = $_SESSION['username'];
	
	$title = '';
	$prefecture = '';
	$address = '';
	$phone = '';
	$individuals = '';
	$latitude = '';
	$longitude = '';
	$stars = '';
	$equipment = '';
	$images = '';



	require('db_params.php');
  try {

    //αρχικοποίηση pdo

  	 $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
     $pdoObject -> exec('set names utf8');

     /*  Exception mode is also useful because you can structure your error handling more clearly than with traditional PHP-style warnings, and with less code/nesting than by running in silent mode and explicitly checking the return value of each database call. 
     */
     //Για μεγαλύτερη σιγουριά βάζουμε να 'πετάει' exception σε οτιδήποτε πήγε στραβά.
     $pdoObject -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     // Ελέγχουμε άν ο συνδεδεμένος user έχει καταχωρημένη villa. Άν έχει, δεδομένου ότι γνωρίζουμε πώς κάθε χρήστης μπορεί να καταχωρήσει ΜΟΝΟ μία villa , γυρίζουμε την λειτουργία της φόρμας σε "update" mode, πάνω στην villa του εκάστοτε user!
     $sql='SELECT * FROM villa WHERE user_username=:username';

      $statement = $pdoObject->prepare($sql);
      
      $result= $statement->execute( array( ':username'=>$username ) );

      if ($record = $statement->fetch()){
      	
      	$mode = "update";
      	$title = $record['title'];
      	$prefecture = $record['prefecture'];
      	$address = $record['address'];
      	$phone = $record['phone'];
      	$individuals = $record['individuals'];
      	$latitude = $record['latitude'];
      	$longitude = $record['longitude'];
      	$stars = $record['stars'];
      	$equipment = $record['equipment'];

      	$idvilla = $record['idvilla'];


      	$sql = 'SELECT * FROM image WHERE villa_idvilla=:idvilla';

      	$statement = $pdoObject->prepare($sql);

      	$result= $statement->execute( array( ':idvilla'=>$idvilla ) );

      	if ($record = $statement->fetchAll())
      		$images = $record;

      }


      //τερματισμός pdo
     $statement->closeCursor();
     $pdoObject = null;

      } catch (PDOException $e) {

        $result=false;
      	//	echo $e->getMessage();
      }



?>



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
    			<div id="vildata">
	    			<h3>Στοιχεία</h3>
	    			<form action="./con_user_villa.php" method="post">
						<table style="width: 100%;">
							<tbody>
								<tr>
									<td class="right">Τίτλος :</td>
									<td><input type="text" id="title" name="title" value="<?php echo $title ?>" size="40"  title="Δεν επιτρέπεται να ξεκινά με κενά"
        pattern="^[^ \t\n\f].+" required></td>
								</tr>
								<tr>
									<td class="right">Νομός: </td>
									<td>				    
										<select id="prefecture" name="prefecture">
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
									<td class="right">Διεύθυνση :</td>
									<td><input type="text" id="address" name="address" value="<?php echo $address ?>" size="10" title="Δεν επιτρέπεται να ξεκινά με κενά"
        pattern="^[^ \t\n\f].+" required></td>
								</tr>
								<tr>
									<td class="right">Τηλέφωνο :</td>
									<td>
										<input type="tel" id="phone" name="phone" value="<?php echo $phone ?>"  size="10" title="Όχι πάνω απο 10 ψηφία" pattern="^\d{10}$" required>
									</td>
								</tr>
								<tr>
									<td class="right">Άτομα :</td>
									<td><input type="number" id="individuals" name="individuals" min="1" max="10" value="<?php echo $individuals ?>" size="2"></td>
								</tr>
								<tr>
									<td class="right">Latitude :</td>
									<td> <input type="text" name="latitude" value="<?php echo $latitude ?>" size="4" title="Πρέπει να είναι ακέραιος ή δεκαδικός" pattern="^-?\d+(\.\d+)?$" required></td>
								</tr>
								<tr>
									<td class="right">Longitude :</td>
									<td> <input type="text" name="longitude" value="<?php echo $longitude ?>" size="4" title="Πρέπει να είναι ακέραιος ή δεκαδικός" pattern="^-?\d+(\.\d+)?$" required></td>
								</tr>
								<tr>
									<td class="right">Αστέρων :</td>
				  					<td><input type="number" id="stars" name="stars" min="1" max="3" value="<?php echo $stars ?>" size="1"></td>
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
								  		<input type="submit" value="Καταχώρηση">
								  	</td>
								</tr>
							</tbody>
						</table>
					</form>
			</div>

				<div id="images" style="margin-top: 30px">
					<h3>Εικόνες</h3>

					<form action="./con_image_upload.php" method="post" enctype="multipart/form-data">
						<fieldset <?php if ($mode === "insert") echo 'disabled="disabled"'?> >
							<table style="width: 100%;">
									<tbody>
										<?php 
											if ($images !== ''){ 

												for($i=0;$i<count($images);$i++){

												?>
											<tr>
												<td class="right"><img src="./images/jpg.ico"/></td>
												<td><a href="./villas_images/<?php echo $images[$i]['filename'] ?> " target="_blank">Προβολή</a> &nbsp;&nbsp;<a href="./con_image_delete.php?id=<?php echo $images[$i]['id']?> ">Διαγραφή</a></td>
											</tr>	

										<?php 
												}
									     }  ?>
										<tr>
											<td class="right">Εικόνα :</td>
											<td><input type="file" id="imgFile" name="imgFile" accept=".jpg, .jpeg"></td>
										</tr>
										<tr>
											<td class="right">Λεζάντα :</td>
											<td><input type="text" id="caption" name="caption"></td>
										</tr>
									 	<tr>
									 		<td>&nbsp;</td>
											<td><input type="submit" value="Upload"></td>
										</tr>
									</tbody>
							</table>
					</fieldset>
						 
					</form>
				</div>

			</main>
			

		<?php require('page_parts/part_footer.php'); ?>

		</div>
	</body>
</html>