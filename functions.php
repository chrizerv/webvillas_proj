<?php


function terminate(){
	header('HTTP/1.0 401 Unauthorized');
    exit();
}




function validate_recaptcha($captcha_token){

 //Στέλνουμε με POST request το response token μαζί με το secret_key στην Google για να επιβεβαιώσουμε 
 // ότι, he is not a robot :D !

//Χρησιμοποιούμε το cURL 

	//Ετοιμάζουμε τα fields όπως τα ζητά το API.. 

	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$fields = array(
	'secret' => urlencode('6LcepfcUAAAAAHQIJdNSxzLeyBghZ9uxXM9hR9Dm'),
	'response' => urlencode($captcha_token)
	);

	// Προσαρμογή (λεγόμενη url-ify ) για POST method
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







function send_mail($to, $subject, $body){

	require 'PHPMailerAutoload.php';

	$mail = new PHPMailer;

	//$mail->SMTPDebug = 4;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username ='email';                // SMTP username
	$mail->Password = 'password';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom('drsperker@gmail.com', 'Chri Zerv');
	$mail->addAddress($to);     // Add a recipient
	//$mail->addAddress('ellen@example.com');               // Name is optional
	//$mail->addReplyTo('info@example.com', 'Information');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');

	//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject ;
	$mail->Body    = $body;
	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	if(!$mail->send()) {
	   // echo 'Message could not be sent.';
	  //  echo 'Mailer Error: ' . $mail->ErrorInfo;
	    return false;
	} else {
	   // echo 'Message has been sent';
	    return true;
	}

}






?>