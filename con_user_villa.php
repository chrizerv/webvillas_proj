<?php
session_start();

//Μόνο συνδεδεμένοι χρήστες μπορούν να καταχωρήσουν αγγελία βίλας.
if (!isset($_SESSION['username'])){
	session_destroy();
	exit(-1);
}


if (isset( $_POST['title'], $_POST['prefecture'], $_POST['address'], $_POST['phone'],
			$_POST['individuals'], $_POST['latitude'], $_POST['longitude'], $_POST['stars']
			)) {


	$title = $_POST['title'];
	$prefecture = $_POST['prefecture'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$individuals = $_POST['individuals'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$stars = $_POST['stars'];
	// θεωρούμε ότι δέν επιλέχθηκε εξοπλισμός.
	$equipment = NULL;
	$username = $_SESSION['username'];




	// --------- ΈΛεγχος με regex. Άν κάτι δέν είναι όπως το θέλουμε τερματίζουμε χωρίς εξήγηση, δεδομένου ότι έχουμε client side validation. 

    //O τίτλος πρέπει να περιέχει κάτι.
	if ( preg_match('/^[^ \t\n\f].+/u', $title) !==1 )     // Δυστυχώς, δέν μπορούμε να περιορίσουμε τους χαρακτήρες που θέλει να χρησιμοποιήσει ο χρήστης για τον τίτλο του.
		exit(-1);

	// Τους νομούς τους λαμβάνουμε προκαθορισμένα στα Ελληνικά και δέν υπερβαίνουν τους 25 σε πλήθος χαρακτήρες.	
	if ( preg_match('/^[\p{Greek}\s]{2,25}$/u', $prefecture) !== 1 )
		exit(-1);
	// H διεύθυνση πρέπει να περιέχει κάτι.
	if ( preg_match('/^[^ \t\n\f].+/u', $address) !== 1 )
		exit(-1);
	// Το τηλέφωνο να είναι 10 νούμερα.
	if ( preg_match('/^\d{10}$/', $phone) !== 1 )
		exit(-1);
	// Ο αριθμός ατόμων μπορεί να είναι μέχρι διψήφιος αριθμός.
	if ( preg_match('/^\d{1,2}$/', $individuals) !== 1 )
		exit(-1);
	// Οι συντεταγμένες πρέπει να έχουν μορφή ακεραίου ή δεκαδικού
	if ( preg_match('/^\-?\d+(\.\d+)?$/', $latitude) !== 1 )
		exit(-1);

	if ( preg_match('/^\-?\d+(\.\d+)?$/', $latitude) !== 1 )
		exit(-1);

	// Τα αστέρια μια βίλας μπορούν να είναι απο 1 μέχρι 3. 
	if ( preg_match('/^[1-3]{1}$/', $stars) !== 1 )
		exit(-1);

	// Ελέγχουμε άν επιλέχθηκε εξοπλισμός.
	if (isset($_POST['equipment'])) {
		$equipment =  $_POST['equipment'];
	
	// Εφόσον γνωρίζουμε ότι ο εξοπλισμός είναι συνολικά 4 επιλογές , δέν υφίσταται να μας στείλουν 5. 
		if (count($equipment) > 4)
			exit(-1);

		// Εφόσον η μορφή των επιλογών είναι προκαθορισμένη, οτίδήποτε περίεργο τρώει πόρτα :D.
		for($i=0;$i<count($equipment);$i++)
			if ( preg_match('/^[\p{Greek}\s]{2,15}$/u', $equipment[$i]) !== 1 )
					exit(-1);

		// Μετατροπή του array σε comma seperated string για να το εισάγουμε στην μορφή του 'SET' data type της db.
		$equipment = implode(",", $equipment);
	}
	// ------------------------------------------------------------------------

	
	
	$result = false;
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
     $sql='INSERT INTO villa (title, prefecture, address, phone, individuals, latitude, longitude, stars, equipment, user_username)
            VALUES (:title, :prefecture, :address, :phone, :individuals, :latitude, :longitude, :stars, :equipment, :username)';

      $statement = $pdoObject->prepare($sql);
      
      $result= $statement->execute( array(       ':title'=>$title,
                                                 ':prefecture'=>$prefecture,
                                                 ':address'=>$address,
                                                 ':phone'=>$phone,
                                                 ':individuals'=>$individuals,
                                                 ':latitude'=>$latitude,
                                                 ':longitude'=>$longitude,
                                                 ':stars'=>$stars,
                                                 ':equipment'=> $equipment,
                                                 ':username'=>$username

                                             ) );


      //τερματισμός pdo
     $statement->closeCursor();
     $pdoObject = null;

      } catch (PDOException $e) {

        $result=false;
      		//echo $e->getMessage();
      }

      if (!$result){
      	echo 'Κάτι πήγε στραβά. Προσπαθήστε ξανά!';
      	exit (-1);
      }else{
      		header('Location: user_villa.php');
      		exit(1);
      }

}



?>