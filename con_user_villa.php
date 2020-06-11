<?php

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


	// --------- ΈΛεγχος με regex. Άν κάτι δέν είανι όπως το θέλουμε τερματίζουμε χωρίς εξήγηση, δεδομένου ότι έχουμε client side validation 

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
	// ------------------------------------------------------------------------

	print_r($_POST);
	echo 'something';



}



?>