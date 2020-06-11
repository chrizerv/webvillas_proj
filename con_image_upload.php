<?php

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





// Να ελένξω άν ο user που προσπαθεί να ανεβάσει εικόνα, έχει όντως villa.


	if ( isset( $_FILES['imgFile'], $_FILES['imgFile']['name'], $_POST['caption'] ) ) {


		$username='karamitros24';
		$caption = $_POST['caption'];

		$filename= $_FILES['imgFile']['name'];


		$extension = strtolower(substr($filename, -3));

		if ($extension !=="jpg")
			exit(-1);

		$max_size=500;  //in KB
		$size=filesize($_FILES['imgFile']['tmp_name']);   //σε bytes!
		
		if ( $size>= $max_size*1024 ) {
		   // header('Location: index.php?msg=ERROR: Το αρχείο είναι μεγαλύτερο από το όριο!');
		    exit(-1);
		  }
		//Εδώ η κατάσταση είναι λίγο δίκοπο μαχαίρι , διότι δέν μπορούμε να στερήσουμε απο τον χρήση τα σημεία στίξης.  
		if ( preg_match('/^[\w\p{Greek}0-9\s[:punct:]]+$/u', $caption) !== 1 )
			exit(-1);

		$new_filename = guid().'.'.$extension ;

		$copyResult = copy($_FILES['imgFile']['tmp_name'], 'villas_images/'.$new_filename);


		 if (!$copyResult) {
   // header('Location: index.php?msg=ERROR: Η αντιγραφή του προσωρινού αρχείου απέτυχε!');
    exit(-1);
  }


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
     $sql='INSERT INTO image (filename, description, villa_idvilla)
            VALUES (:filename, :description, :villa_idvilla)';

      $statement = $pdoObject->prepare($sql);
      
      $result= $statement->execute( array(       ':filename'=>$new_filename,
                                                 ':description'=>$caption,
                                                 ':villa_idvilla'=>1 ) );


      //τερματισμός pdo
     $statement->closeCursor();
     $pdoObject = null;

      } catch (PDOException $e) {

        $result=false;
      		//echo $e->getMessage();
      }



	}

?>