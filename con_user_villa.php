<?php
session_start();

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
	$equipment = NULL;
	$username = $_SESSION['username'];




	// --------- ΈΛεγχος με regex. Άν κάτι δέν είναι όπως το θέλουμε τερματίζουμε χωρίς εξήγηση, δεδομένου ότι έχουμε client side validation. 

    //Aναγνώριση και ελληνικών χαρακτήρων.
	if ( preg_match('/^[a-zA-Z\p{Greek}0-9\s]{4,255}$/u', $title) !== 1 )
		exit(-1);

	if ( preg_match('/^\w{2,100}$/', $prefecture) !== 1 )
		exit(-1);

	if ( preg_match('/^[a-zA-Z\p{Greek}0-9\s]{2,100}$/u', $address) !== 1 )
		exit(-1);

	if ( preg_match('/^\d{10}$/', $phone) !== 1 )
		exit(-1);

	if ( preg_match('/^\d{1,2}$/', $individuals) !== 1 )
		exit(-1);

	if ( preg_match('/^\-?\d+(\.\d+)?$/', $latitude) !== 1 )
		exit(-1);

	if ( preg_match('/^\-?\d+(\.\d+)?$/', $latitude) !== 1 )
		exit(-1);

	if ( preg_match('/^[1-3]{1}$/', $stars) !== 1 )
		exit(-1);

	if (isset($_POST['equipment'])) {
		$equipment =  $_POST['equipment'];
	
	// Εφόσον γνωρίζουμε ότι ο εξοπλισμός είναι συνολικά 4 επιλογές , δέν υφίσταται να μας στείλουν 5. 
		if (count($equipment) > 4)
			exit(-1);

		// Εφόσον η μορφή των επιλογών είναι προκαθορισμένη, οτίδήποτε περίεργο τρώει πόρτα :D.
		for($i=0;$i<count($equipment);$i++)
			if ( preg_match('/^[a-z]{2,11}$/', $equipment[$i]) !== 1 )
					exit(-1);

		$equipment = implode(",", $equipment);
	}
	// ------------------------------------------------------------------------

	print_r($_POST);
	
	// Προετιμάζουμε τις επιλογές για να τις εισάγουμε στην μορφή του 'SET' data type της db.
	

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
      	//	echo $e->getMessage();
      }

      if (!$result)
      	echo 'Κάτι πήγε στραβά. Προσπαθήστε ξανά!';

}



?>