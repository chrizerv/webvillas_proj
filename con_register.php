<?php

require 'functions.php';


//Προχωράμε άν και μόνο άν, έχουν σταλεί ΟΛΑ τα πεδία!
if ( isset($_POST['username'], $_POST['password'], $_POST['conpassword'], $_POST['email'], $_POST['g-recaptcha-response']) ) {
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$conpassword = $_POST['conpassword'];
  $email = $_POST['email'];
	$captcha_token = $_POST['g-recaptcha-response'];


// Άν έστω και κάτι απο το input δέν είναι όπως το θέλουμε, δέν δεχόμαστε περαιτέρω διαπραγματέυσεις 
// και δέν λέμε ούτε το γιατί, δεδομένου ότι υπάρχει client-side validation!

//το username να περιέχει 0-9, A-Z, a-z, _  με μήκος>8 και <20..  
	if ( preg_match('/^\w{8,20}$/', $username) !== 1 )
		exit(-1);

//το password να περιέχει αυστηρά αριθμούς KAI μικρά KAI κεφαλαία, με μήκος>8 και <128.. 
	
  if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,128}$/', $password) !== 1)
    exit(-1);

// Άν επιβεβαίωσε σωστά το password
  if ($conpassword !== $password)
    exit(-1);

  
// το email να είναι email και να μήν ξεφεύγει πάνω απο 254 :D !	
	if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ||  strlen($email) > 254 )
		exit(-1);

// Ελέγχουμε άν είναι robot ! ..
	// Εδώ επίσης υπάρχει το θέμα του ότι δέν μας συμφέρει να κάνουμε filter το token γιατί δέν εξαρτάται απο εμάς..
	// Άμα π.χ αποκλείσουμε τα '< >' και η Google αύριο συμπεριλάβει και απο αυτά , δέν θα δουλεύει... Αυτά είναι τα κακά των 3rd parties ! :D  
	if ( !validate_recaptcha($captcha_token) )
		exit(-1);

   //random αλφαριθμητικό τύπου md5 για ενεργοποίηση μέσω email
   $random_vfcode = md5(random_int(00000,99999).' '.rand());

   //κρυπτογράφηση SHA-512
   $enc_password = crypt($password,'$6$rounds=5000$w6tLIsFTm4PKuXaC$');

 
    // Θεωρούμε ότι έχει γίνει κάτι λάθος με την προσπέλαση στην database και ελέγχουμε μετά άν έχουμε δίκιο !
    $result=false;
     

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
     $sql='INSERT INTO user (username, password, email, vfcode)
            VALUES (:username, :password, :email, :vfcode)';

      $statement = $pdoObject->prepare($sql);
      
      $result= $statement->execute( array(       ':username'=>$username,
                                                 ':password'=>$enc_password,
                                                 ':email'=>$email,
                                                 ':vfcode'=>$random_vfcode  ) );


      //τερματισμός pdo
     $statement->closeCursor();
     $pdoObject = null;

      } catch (PDOException $e) {

        $result=false;
      	//	echo $e->getMessage();
      }
    
    //Στέλνουμε τους αριθμούς 0,1,2 στις σελίδες register/login ανάλογα με το τί συνέβει ώστε να δείξουμε και τα ανάλογα μηνύματα.
    // 0 - Άν δεν μπόρεσε να γίνει εγγραφή.
    // 1 - Άν μπόρεσε να γίνει εγγραφή ΑΛΛΑ απέτυχε η αποστολή email !
    // 2 - Άν πέτυχαν όλα.

    if (!$result){
      header ('Location: register.php?msg=0');
      exit(-1);
    }
    else{
    // Αποστολή email
      if ( !send_mail($email,
      				'WebVillas - Account Activation',
      				'Click <a href=http://172.17.0.3/kokor_2020/con_activate.php?vfcode='.$random_vfcode.'>here</a> to activate your account.') ){
        header ('Location: login.php?msg=1');
        exit(-1);
      }
      else{

        header ('Location: login.php?msg=2');
        exit(-1);	
      }
    
    }   

}


?>