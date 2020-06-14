<?php

// Άν δέν υπάρχει vfcode παραμένουμε σιωπηλοί!
if (isset($_GET['vfcode'])) {

	$vfcode = $_GET['vfcode'];
	// Θεωρούμε ότι κάτι πήγε στραβά στην βάση ή δέν δώθηκε το md5 κατάλληλα!
	$result= false;
    // To vfcode πρέπει να είναι μορφής MD5 και ΤΙΠΟΤΑ άλλο !
	if (preg_match('/^[[:alnum:]]{32}/', $vfcode) === 1)
		{
			require('db_params.php');
  				try {
						$pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
     					$pdoObject -> exec('set names utf8');

     /*  Exception mode is also useful because you can structure your error handling more clearly than with traditional PHP-style warnings, and with less code/nesting than by running in silent mode and explicitly checking the return value of each database call. 
     */

			     $pdoObject -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			     $sql='UPDATE user
			              SET verified=1
			              WHERE vfcode=:vfcode';

			      $statement = $pdoObject->prepare($sql);
			      
			      $result= $statement->execute( array( ':vfcode'=>$vfcode ) );



			     $statement->closeCursor();
			     $pdoObject = null;
			      } catch (PDOException $e) {
			      		// Συμπεριλαμβάνουμε και το exception στο result.
			      		$result = false;
			      		//echo $e->getMessage();
			      }
		}
		if ($result)
			echo 'Ο λογαριασμός σας ενεργοποιήθηκε επιτυχώς';
		else
			echo 'Αποτυχία ενεργοποίησης λογαριασμού';


}





?>