<?php
require './functions.php';
session_start();

if (isset($_GET['user'])) {
	$user = $_GET['user'];

if ( preg_match('/^\w{8,20}$/', $user) !== 1 )
		exit(-1);

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

     		send_mail($record['email'],
      				'WebVillas - Account Activation',
      				'Click <a href=http://172.17.0.3/kokor_2020/con_activate.php?vfcode='.$record['vfcode'].'>here</a> to activate your account.');
     }

     

     $statement->closeCursor();
     $pdoObject = null;
      } catch (PDOException $e) {
      		echo $e->getMessage();
      }
     header("Location: login.php ");
     exit(1);
}

?>