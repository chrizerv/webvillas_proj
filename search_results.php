<?php
	require './check_loggedin.php';
	$get_parameters = array();
	
	

	if(isset($_GET['prefecture']) && $_GET['prefecture']!== ''){

		$get_parameters['prefecture'] = $_GET['prefecture'];
	}

	if(isset($_GET['individuals']) && $_GET['individuals']!== ''){

		$get_parameters['individuals'] = $_GET['individuals'];
	}

	if(isset($_GET['stars']) && $_GET['stars']!== ''){
	
		$get_parameters['stars'] = $_GET['stars'];
	}

	if(isset($_GET['equipment']) && $_GET['equipment']!== ''){
		
		$get_parameters['equipment'] = $_GET['equipment'];
		//$get_parameters['equipment'] = implode(',', $get_parameters['equipment']);
	}


	if (count($get_parameters) < 1)
		exit(-1);

	$operator = '';
	$sql_params = '';
	$prepare_params = array();

	foreach ($get_parameters as $key => $value) {

		$operator = '=';
		
		if ($key === 'individuals')
			$operator = '>=';

		if ($key === 'equipment')
			foreach ($get_parameters['equipment'] as $kkey => $vvalue) {
				$sql_params .= 'equipment LIKE :equip'.$kkey.' AND ';
				$prepare_params[':equip'.$kkey] = '%'.$vvalue.'%';
			}else{

				$sql_params .= $key.$operator.':'.$key . ' AND ';
				$prepare_params[':'.$key] = $value;

			}
		
	}

	$sql_params = rtrim($sql_params," AND ");

	echo $sql_params;
	echo '<br>';
	print_r($prepare_params);

	
	


	
		$villas_list = '';
		

	require('db_params.php');
  try {

    //αρχικοποίηση pdo

  	 $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
     $pdoObject -> exec('set names utf8');

     /*  Exception mode is also useful because you can structure your error handling more clearly than with traditional PHP-style warnings, and with less code/nesting than by running in silent mode and explicitly checking the return value of each database call. 
     */
     //Για μεγαλύτερη σιγουριά βάζουμε να 'πετάει' exception σε οτιδήποτε πήγε στραβά.
     $pdoObject -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


     $sql='SELECT * FROM villa WHERE '. $sql_params.';';
    
    

      $statement = $pdoObject->prepare($sql);

      
      $result= $statement->execute(  $prepare_params  );
     

     if ($record = $statement->fetchAll()){
     	echo 'tipota';
     	$villas_list = $record;

     }



      //τερματισμός pdo
     $statement->closeCursor();
     $pdoObject = null;

      } catch (PDOException $e) {

        $result=false;
      		echo $e->getMessage();
      }


?>





<!DOCTYPE html>
<html lang="el">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
		<title></title>
		<link rel="stylesheet" href="css/style.css">
	</head>
  	<body>
		<div id="container">

		<?php require('page_parts/part_header2.php'); ?>
			
    		<main>
       			<?php if ($villas_list !== '') {for($i=0;$i<count($villas_list);$i++) {?>
       			<article>
					<h4><?php echo $villas_list[$i]['title']; ?></h4>
					<p>Νομός <?php echo $villas_list[$i]['prefecture']; ?></p>
				</article>
			<?php } }?>
    		</main>

		<?php require('page_parts/part_footer.php'); ?>

		</div>
	</body>
</html>