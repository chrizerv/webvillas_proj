<?php

session_start();

// Εικόνα μπορεί να διαγράψει μόνο συνδεδεμένος χρήστης. 
if (!isset($_SESSION['username'])){
	session_destroy();
	exit(-1);
}

if (isset($_GET['id'])){

	//Χρησιμοποιούμε το id της εικόνας προς διαγραφή και το username( του session) ώστε να βρούμε την εικόνα του χρήστη.
	$imgID = $_GET['id'];
	$username = $_SESSION['username'];

	// Η παράμετρος id πρέπει να είναι αριθμός!
	if ( preg_match('/^\d+$/', $imgID) !== 1 )
		exit(-1);

	//Θεωρούμε ότι δέν διαγράφηκε η εικόνα.
	$delete_result = false;
	require('db_params.php');
  try {

    //αρχικοποίηση pdo

  	 $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
     $pdoObject -> exec('set names utf8');

     /*  Exception mode is also useful because you can structure your error handling more clearly than with traditional PHP-style warnings, and with less code/nesting than by running in silent mode and explicitly checking the return value of each database call. 
     */
     //Για μεγαλύτερη σιγουριά βάζουμε να 'πετάει' exception σε οτιδήποτε πήγε στραβά.
     $pdoObject -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


     // Η εικόνα θα σβήσει, άν και μόνο άν, είναι εικόνα που έχει ανεβάσει ο συγκεκριμένος συνδεδεμένος χρήστης στην villa του.

     $sql='SELECT * FROM villa,image WHERE user_username=:username AND idvilla=villa_idvilla AND id=:imgID';

      $statement = $pdoObject->prepare($sql);
      
      $result= $statement->execute( array(       ':username'=>$username,
                                                 ':imgID'=>$imgID ) );

      if ($record = $statement->fetch()){

      	// Άν μπόρεσε να διαγραφεί το αρχείο της εικόνας , τότε θα διαγραφεί και η εγγραφή στην db! 
      	if ( unlink('./villas_images/' . $record['filename']) ){

      		$sql='DELETE FROM image WHERE id=:imgID';
      		$statement = $pdoObject->prepare($sql);

      		$delete_result= $statement->execute( array( ':imgID'=>$imgID ) );
      	}

   }
      
      //τερματισμός pdo
     $statement->closeCursor();
     $pdoObject = null;

      } catch (PDOException $e) {

        $result=false;
      	//	echo $e->getMessage();
      }
  	
  	  if(!$result){
  	  	echo 'Κάτι πήγε στραβά. Δοκιμάστε ξανά αργότερα!';
  	  	exit(-1);
  	  }

      if($delete_result){
      	header('Location: user_villa.php');
      	exit(1);
      }


}


?>