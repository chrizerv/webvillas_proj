<?php
	
	if (isset($_POST['type'],$_POST['value']) ){

		$type = $_POST['type'];
		$value = $_POST['value'];

		$is_username =  preg_match('/^\w{8,20}$/', $value);
		$is_email = filter_var($value, FILTER_VALIDATE_EMAIL) &&  strlen($value) < 254 ;

		// Το type , κατα δική μας σύμβαση μπορεί να έχει μόνο 2 διαφορετικές τιμές(username,email). Αλλιώς κάτι συμβαίνει!

		if ($type !== 'username' && $type !== 'email')
			exit(-1);

		// Άν το value δέν έχει ούτε την μορφή username αλλά ούτε και την μορφή email.

		if ( !$is_username && !$is_email )
			exit(-1);

		require('db_params.php');
	  try {

	    //αρχικοποίηση pdo

	  	 $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
	     $pdoObject -> exec('set names utf8');

	     /*  Exception mode is also useful because you can structure your error handling more clearly than with traditional PHP-style warnings, and with less code/nesting than by running in silent mode and explicitly checking the return value of each database call. 
	     */
	    
	     $pdoObject -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	     // Ανάλογα με το τί είναι το type κάνουμε το κατάλληλο sql query χρησιμοποιώντας το value ώς τιμή username/email.
			if ($type === 'username'){
	     	
	     	$sql='SELECT * FROM user WHERE username=:username';
	     	$statement = $pdoObject->prepare($sql);
	     	$result= $statement->execute( array(   ':username'=>$value ) );
	     	$record = $statement->fetch();

	     }
	     else if ($type === 'email'){

	     	$sql='SELECT * FROM user WHERE email=:email';
	     	$statement = $pdoObject->prepare($sql);
	     	$result= $statement->execute( array(   ':email'=>$value ) );
	     	$record = $statement->fetch();

	     }
	      
	      if ($record)
	      	echo 'true';


	      //τερματισμός pdo
	     $statement->closeCursor();
	     $pdoObject = null;

	      } catch (PDOException $e) {

	        // Συμπεριλαμβάνουμε και το exception στο result.
	         $result=false;
	      	//	echo $e->getMessage();
	      }



	}

?>