<?php
	require './check_loggedin.php';

	if (isset($_GET['id'])){

		// Παίρνουμε το id της βίλας και προετοιμάζουμε τα πεδία.
		$id = $_GET['id'];

		$title = '';
		$prefecture = '';
		$address = '';
		$phone = '';
		$individuals = '';
		$latitude = '';
		$longitude = '';
		$stars = '';
		$equipment = NULL;
		$images = '';


		//To id πρέπει να είναι αριθμός.
		if ( preg_match('/^\d+$/', $id) !== 1 )
			exit(-1);

		$result = true;
		require('db_params.php');
  try {

    //αρχικοποίηση pdo

  	 $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
     $pdoObject -> exec('set names utf8');

     /*  Exception mode is also useful because you can structure your error handling more clearly than with traditional PHP-style warnings, and with less code/nesting than by running in silent mode and explicitly checking the return value of each database call. 
     */
     //Για μεγαλύτερη σιγουριά βάζουμε να 'πετάει' exception σε οτιδήποτε πήγε στραβά.
     $pdoObject -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // Ανακτούμε τα στοιχεία της εκάστοτε βίλας.

     $sql='SELECT * FROM villa WHERE idvilla=:id';

      $statement = $pdoObject->prepare($sql);
      
      $result= $statement->execute( array( ':id'=>$id ) );

      if ($villa_record = $statement->fetch()){

      	$title = $villa_record['title'];
      	$prefecture = $villa_record['prefecture'];
      	$address = $villa_record['address'];
      	$phone = $villa_record['phone'];
      	$individuals = $villa_record['individuals'];
      	$latitude = $villa_record['latitude'];
      	$longitude = $villa_record['longitude'];
      	$stars = $villa_record['stars'];
      	$equipment = $villa_record['equipment'];

      	// Ανακτούμε τις εικόνες που ανήνκουν στην εκάστοτε βίλα.

      	$sql='SELECT * FROM image WHERE villa_idvilla=:id';

      	$statement = $pdoObject->prepare($sql);
      
      	$result= $statement->execute( array( ':id'=>$id ) );

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

      if (!$result || !$villa_record){
      	echo 'Κάτι πήγε στραβά. Προσπαθήστε ξανά αργότερα.';
      	exit(-1);
      }

      // Άν δέν υπάρχει id , δέν έχει νόημα να δείξει κάτι η σελίδα.
	}else
		exit(-1);

?>
<!DOCTYPE html>
<html lang="el">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<title><?php echo htmlspecialchars($title); ?></title>
		<link rel="stylesheet" href="css/style.css">
		<link href="./dist/css/lightbox.css" rel="stylesheet" />
	</head>
  	<body>
		<div id="container">

		<?php require('page_parts/part_header2.php'); ?>
			
    		<main>
       			<section>
	       			<h2><?php echo htmlspecialchars($title); ?></h2>
	       			<p>Noμός <?php echo htmlspecialchars($prefecture) . ', ' . htmlspecialchars($address); ?></p>
       			</section>
       			
       			<section>
       				<h4>Εικόνες</h4>
       				<div class="gallery">
       					<?php 
       						if ($images !== '')
       							for($i=0;$i<count($images);$i++){ ?>
									<a href="villas_images/<?php echo htmlspecialchars($images[$i]['filename']); ?>" data-lightbox="villa_image" data-title="<?php echo htmlspecialchars($images[$i]['description']); ?>"> <img src="villas_images/<?php echo htmlspecialchars($images[$i]['filename']); ?>" alt="<?php echo htmlspecialchars($images[$i]['description']); ?>" width="100" height="100" /></a>
									
						<?php } ?>
					</div>
       			</section>
       			<hr>
       			
       			<section>
       				<h4>Χαρακτηριστικά</h4>
       				<ul>
       					<li>
       						<?php if ($stars > 1) 
       								echo htmlspecialchars($stars) . ' Αστέρων'; 
       							else 
       								echo htmlspecialchars($stars) . ' Αστέρα'; 
       						?>
       					</li>
       					<li>
       						<?php if ($individuals > 1) 
       								echo htmlspecialchars($individuals) . ' Ατόμων'; 
       							else 
       								echo htmlspecialchars($stars) . ' Άτομο'; 
       						?>
       					</li>
       					<?php if (!is_null($equipment)){

       						$equipment = explode(",", $equipment);
       						for($i=0;$i<count($equipment);$i++){

       							echo '<li>'.htmlspecialchars($equipment[$i]) . '</li>';

       							}
       						} 
       					?>
       				</ul>
       			</section>
       			<hr>
       			<section>
       				<h4>Επικοινωνία</h4>
       				<p> Τηλέφωνο: <?php echo htmlspecialchars($phone) ?></p>
       			</section>
       			<hr>

       			<section>
       				<h4>Χάρτης</h4>

       				<iframe
					  width="600"
					  height="450"
					  frameborder="0" style="border:0"
					  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBktTnMIE3XT32Nth-LXa-D9miqspSBYz0&q=<?php echo htmlspecialchars($latitude).','.htmlspecialchars($longitude);  ?>"
					  allowfullscreen>
					</iframe>

       			</section>
    		</main>

		<?php require('page_parts/part_footer.php'); ?>

		</div>

		<script src="./dist/js/lightbox-plus-jquery.js"></script>
	</body>
</html>