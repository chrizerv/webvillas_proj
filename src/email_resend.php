<?php
require './functions.php';


if (isset($_GET['user'])) {
	$user = $_GET['user'];

//user να περιέχει 0-9, A-Z, a-z, _  με μήκος>8 και <20..
if ( preg_match('/^\w{8,20}$/', $user) !== 1 )
		exit(-1);

//Θεωρούμε ότι δέν έχουμε exception error.
$exception_error = false;

require('db_params.php');
  try {

  	 $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
     $pdoObject -> exec('set names utf8');

     /*  Exception mode is also useful because you can structure your error handling more clearly than with traditional PHP-style warnings, and with less code/nesting than by running in silent mode and explicitly checking the return value of each database call. 
     */

     $pdoObject -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $sql='SELECT * FROM user
           WHERE username=:username';

      $statement = $pdoObject->prepare($sql);
      
      $result= $statement->execute( array( ':username'=>$user ));

      

     if ($record = $statement -> fetch()){

      // Δέν θα στείλουμε mail σε user του οποίου ο λογαριασμός, είναι ήδη ενεργοποιημένος. 
       
        if (!$record['verified'])
          send_mail($record['email'],
        				'WebVillas - Account Activation',
        				'Click <a href=http://172.17.0.3/kokor_2020/con_activate.php?vfcode='.$record['vfcode'].'>here</a> to activate your account.');
     }

     

     $statement->closeCursor();
     $pdoObject = null;
      } catch (PDOException $e) {
      		//echo $e->getMessage();
          $exception_error = true;
      }

     if ($exception_error){
        echo 'Κάτι πήγε στραβά. Δοκιμάστε ξανά!';
        exit(-1);
    }

    
     header("Location: login.php ");
     exit(1);


}

?>