<?php

function terminate(){
	header('HTTP/1.0 401 Unauthorized');
    exit();
}



//Προχωράμε άν και μόνο άν, έχουν σταλθεί ΟΛΑ τα πεδία!
if ( isset($_POST['username'], $_POST['password'], $_POST['email'], $_POST['g-recaptcha-response']) ) {
	
	//Το username μπορεί να περιέχει 0-9, A-Z, a-z, _  με μήκος>8 και <20 
	$username = filter_input(INPUT_POST, 'username', FILTER_VALIDATE_REGEXP, 
			array(
            	 "options" => array("regexp"=>"/\w{8,20}/")
        	)
        );
	$password = 


}




?>