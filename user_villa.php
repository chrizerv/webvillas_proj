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
									<td><input type="text" id="title" name="title" value="<?php echo $title ?>" ></td>
								</tr>
								<tr>
									<td class="right">Νομός: </td>
									<td>				    
										<select id="prefecture" name="prefecture">
						      				<option value="athens">Αθηνών</option>
					      					<option value="east_att">Ανατολικής Αττικής</option>
										    <option value="west_att">Δυτικής Αττικής</option>
									     	<option value="piraeus">Πειραιά</option>
										    <option value="evias">Ευβοίας</option>
											<option value="evritanias">Ευρυτανίας</option>
											<option value="fokidas">Φωκίδας</option>
										    <option value="chalkidikhs">Χαλκιδικής</option>
											<option value="imathias">Ημαθίας</option>
											<option value="kilkis">Κιλκίς</option>
											<option value="pellas">Πέλλας</option>
											<option value="pierias">Πιερίας</option>
											<option value="serrwn">Σερρών</option>
											<option value="thessalonikhs">Θεσσαλονίκης</option>
											<option value="karditsas">Καρδίτσας</option>
											<option value="larissas">Λάρισας</option>
											<option value="magnisias">Μαγνησίας</option>
											<option value="trikalwn">Τρικάλων</option>
									    </select>
								   	</td>
								</tr>
								<tr>
									<td class="right">Διεύθυνση :</td>
									<td><input type="text" id="address" name="address" value="<?php echo $address ?>" ></td>
								</tr>
								<tr>
									<td class="right">Τηλέφωνο :</td>
									<td>
										<input type="tel" id="phone" name="phone" value="<?php echo $phone ?>"  >
									</td>
								</tr>
								<tr>
									<td class="right">Άτομα :</td>
									<td><input type="number" id="individuals" name="individuals" min="1" max="10" value="<?php echo $individuals ?>" ></td>
								</tr>
								<tr>
									<td class="right">Latitude :</td>
									<td> <input type="text" name="latitude" value="<?php echo $latitude ?>" ></td>
								</tr>
								<tr>
									<td class="right">Longitude :</td>
									<td> <input type="text" name="longitude" value="<?php echo $longitude ?>" ></td>
								</tr>
								<tr>
									<td class="right">Αστέρων :</td>
				  					<td><input type="number" id="stars" name="stars" min="1" max="3" value="<?php echo $stars ?>" ></td>
								</tr>
								<tr>
									<td class="right">Εξοπλισμός :</td>
				  					<td>
				  						<label>
											<input type="checkbox" id="equipment1" name="equipment[]" value="pool">Πισίνα
										</label>
										<br>
										<label> 
											<input type="checkbox" id="equipment2" name="equipment[]" value="gym">Γυμναστήριο
										</label>
										<br>
										<label>
											<input type="checkbox" id="equipment3" name="equipment[]" value="sauna">Σάουνα
										</label>
										<br>
										<label>
											<input type="checkbox" id="equipment4" name="equipment[]" value="playground">Παιδική Χαρά
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