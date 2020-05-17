<?php

require 'functions.php';


//Προχωράμε άν και μόνο άν, έχουν σταλεί ΟΛΑ τα πεδία!
if ( isset($_POST['username'], $_POST['password'] ) ) {
	
	$username = $_POST['username'];
	$password = $_POST['password'];

// Άν έστω και κάτι απο το input δέν είναι όπως το θέλουμε, δέν δεχόμαστε περαιτέρω διαπραγματέυσεις.

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


require('db_params.php');
  try {

  	 $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
     $pdoObject -> exec('set names utf8');

     /*  Exception mode is also useful because you can structure your error handling more clearly than with traditional PHP-style warnings, and with less code/nesting than by running in silent mode and explicitly checking the return value of each database call. 
     */

     $pdoObject -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $sql='SELECT * FROM user
           WHERE username=:username AND password=:password';

      $enc_password = crypt($password,'$6$rounds=5000$w6tLIsFTm4PKuXaC$');

      $statement = $pdoObject->prepare($sql);
      
      $result= $statement->execute( array(       ':username'=>$username,
                                                 ':password'=>$enc_password
                                             								));
   	  if ($record = $statement -> fetch()){
   	  	if (!$record['verified'])
   	  		echo 'Ο λογαριασμός σας δέν είναι ενεργοποιημένος!';
   	  } 
     

     $statement->closeCursor();
     $pdoObject = null;
      } catch (PDOException $e) {
      		echo $e->getMessage();
      }
     


}


?>