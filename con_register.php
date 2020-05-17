<?php

require 'functions.php';


//Προχωράμε άν και μόνο άν, έχουν σταλεί ΟΛΑ τα πεδία!
if ( isset($_POST['username'], $_POST['password'], $_POST['email'], $_POST['g-recaptcha-response']) ) {
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$captcha_token = $_POST['g-recaptcha-response'];

// Άν έστω και κάτι απο το input δέν είναι όπως το θέλουμε, δέν δεχόμαστε περαιτέρω διαπραγματέυσεις 
// και δέν λέμε ούτε το γιατί, δεδομένου ότι υπάρχει client-side validation!

//username να περιέχει 0-9, A-Z, a-z, _  με μήκος>8 και <20..  
	if ( preg_match('/\w{8,20}/', $username) !== 1 )
		terminate();

// password να περιέχει αυστηρά αριθμούς, μικρά, κεφαλαία, με μήκος>8 και <20.. 
	if ( 
		  preg_match('@[a-z]@', $password) !== 1 ||
	      preg_match('@[A-Z]@', $password) !== 1 ||
	      preg_match('@[0-9]@', $password) !== 1 ||
	      strlen($password) < 8 	||
	      strlen($password) > 20
	   )
		terminate();

// το email να είναι email :D !	
	if ( !filter_var($email, FILTER_VALIDATE_EMAIL) )
		terminate();

// Ελέγχουμε άν είναι robot ! ..
	// Εδώ επίσης υπάρχει το θέμα του ότι δέν μας συμφέρει να κάνουμε filter το token γιατί δέν εξαρτάται απο εμάς..
	// Άμα π.χ αποκλείσουμε τα '< >' και η Google αύριο συμπεριλάβει και απο αυτά , δέν θα δουλεύει... Αυτά είναι τα κακά των 3rd parties ! :D  
	if ( !validate_recaptcha($captcha_token) )
		terminate();

   $random_vfcode = md5(random_int(00000,99999).' '.rand());


   $enc_password = crypt($password,'$6$rounds=5000$w6tLIsFTm4PKuXaC$');

 
     
    $result=false;
     

	 require('db_params.php');
  try {

  	 $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
     $pdoObject -> exec('set names utf8');

     /*  Exception mode is also useful because you can structure your error handling more clearly than with traditional PHP-style warnings, and with less code/nesting than by running in silent mode and explicitly checking the return value of each database call. 
     */

     $pdoObject -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $sql='INSERT INTO user (username, password, email, vfcode)
            VALUES (:username, :password, :email, :vfcode)';

      $statement = $pdoObject->prepare($sql);
      
      $result= $statement->execute( array(       ':username'=>$username,
                                                 ':password'=>$enc_password,
                                                 ':email'=>$email,
                                                 ':vfcode'=>$random_vfcode  ) );



     $statement->closeCursor();
     $pdoObject = null;
      } catch (PDOException $e) {
      		echo $e->getMessage();
      }
     
    if (!$result)
    	terminate();
    else
    	echo 'H εγγραφή σας ήτανε επιτυχής.<br>';

    if ( !send_mail($email,
    				'WebVillas - Account Activation',
    				'Click <a href=http://172.17.0.3/kokor_2020/activate.php?vfcode='.$random_vfcode.'>here</a> to activate your account.') )
    	terminate();
    else
    	echo '<br>Σας έχει σταλεί email για την ενεργοποίηση του λογαριασμού σας.';

}




?>