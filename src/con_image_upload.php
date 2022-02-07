<?php
session_start();

//Upload κάνουνε μόνο συνδεδεμένοι χρήστες. 
if (!isset($_SESSION['username'])){
	session_destroy();
	exit(-1);
}

// random unique number
function guid( $opt = false ){
    if( function_exists('com_create_guid') ){
        if( $opt ){ return com_create_guid(); }
            else { return trim( com_create_guid(), '{}' ); }
    } else {
      mt_srand( (double)microtime() * 10000 );
      $charid = strtoupper( md5(uniqid(rand(), true)) );
      $hyphen = chr( 45 );    // "-"
      $left_curly = $opt ? chr(123) : "";     //  "{"
      $right_curly = $opt ? chr(125) : "";    //  "}"
      $uuid = $left_curly
              . substr( $charid, 0, 8 ) . $hyphen
              . substr( $charid, 8, 4 ) . $hyphen
              . substr( $charid, 12, 4 ) . $hyphen
              . substr( $charid, 16, 4 ) . $hyphen
              . substr( $charid, 20, 12 )
              . $right_curly;
     return $uuid;
    }
  }




	if ( isset( $_FILES['imgFile'], $_FILES['imgFile']['name'], $_POST['caption'] ) ) {

		// Χρησιμοποιούμε το username απο το SESSION για να βρούμε την βίλα και την εικόνα του συγκεκριμένου χρήστη.
		$username= $_SESSION['username'];
		$caption = $_POST['caption'];

		$filename= $_FILES['imgFile']['name'];


		$extension = strtolower(substr($filename, -3));

		if ($extension !=="jpg")
			exit(-1);

		$max_size=500;  //in KB
		$size=filesize($_FILES['imgFile']['tmp_name']);   //σε bytes!
		
		if ( $size>= $max_size*1024 ){
			echo 'Η εικόνα δέν πρέπει να ξεπερνά τα 500ΚΒ';
		    exit(-1);
		}

		//H εικόνα πρέπει να έχει λεζάντα. 
		if ( preg_match('/^[^ \t\n\f].+/u', $caption) !== 1 )
			exit(-1);

		$new_filename = guid().'.'.$extension ;

		

$image_result = false;
// Θεωρούμε ότι δέν έχουμε exception error
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

     //εισαγωγή δεδομένων με prepare
     $sql = ' SELECT * FROM user,villa WHERE user_username=:username';

     $statement = $pdoObject->prepare($sql);

     $villa_result= $statement->execute( array( ':username'=>$username));
     
     // Καταχώρηση εικόνας μπορεί να γίνει υπο την προυπόθεση ότι ο χρήστης έχει καταχωρήσει ήδη την villa του.
     if ( $record = $statement->fetch() ){
     	
     	$idvilla = $record['idvilla']; 
		$sql='INSERT INTO image (filename, description, villa_idvilla)
            VALUES (:filename, :description, :villa_idvilla)';

      	$statement = $pdoObject->prepare($sql);
      
      	$image_result= $statement->execute( array(       ':filename'=>$new_filename,
                                                 ':description'=>$caption,
                                                 ':villa_idvilla'=>$idvilla ) );
	}


      //τερματισμός pdo
     $statement->closeCursor();
     $pdoObject = null;

      } catch (PDOException $e) {

        $result=false;
      		//echo $e->getMessage();
      }

      if (!$result){
      	echo 'Κάτι πήγε στραβά. Δοκιμάστε αργότερα!';
      	exit(-1);
      }

      // Άν δημιουργήθηκε η εγγραφή με τα metadata της εικόνας , τότε αντιγράφεται και η ίδια.
      if ($image_result)
      	$copyResult = copy($_FILES['imgFile']['tmp_name'], 'villas_images/'.$new_filename);

      if($copyResult){
      		header('Location: user_villa.php');
      		exit(1);
      }else {
   			echo 'Δέν ήταν δυνατή η αντιγραφή της εικόνας';
    		exit(-1);
	  }


	}

?>