<?php

 //Στέλνουμε με POST request το response token μαζί με το secret_key στην Google για να επιβεβαιώσουμε 
 // ότι, he is not a robot :D !
function validate_recaptcha($captcha_token){

//Χρησιμοποιούμε το cURL 

	//Ετοιμάζουμε τα fields όπως τα ζητά το API.. 

	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$fields = array(
	'secret' => urlencode('6LcepfcUAAAAAHQIJdNSxzLeyBghZ9uxXM9hR9Dm'),
	'response' => urlencode($captcha_token)
	);

	// Προετιμασία (λεγόμενη url-ify ) για POST method
	foreach($fields as $key=>$value) 
		$fields_string .= $key.'='.$value.'&';
	
	$fields_string=rtrim($fields_string, '&');
    

    // Αρχικοποίηση, πέρασμα url , num of fields και post data 
    $ch = curl_init();
    
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, True);

    // Εκτέλεση του post
    $result = curl_exec($ch);
    
    // Τερματισμός του curl
    curl_close($ch);

    // Η Google μας επιστρέφει σε JSON μια μεταβλητή success και έτσι γνωρίζουμε την αλήθεια !
    $result = json_decode($result,true);
   
    if(isset($result))
    	return $result['success'];
    else
    	return false;

}


function terminate(){
	header('HTTP/1.0 401 Unauthorized');
    exit();
}



//Προχωράμε άν και μόνο άν, έχουν σταλθεί ΟΛΑ τα πεδία!
if ( isset($_POST['username'], $_POST['password'], $_POST['email']) ) {
	
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


}




?>