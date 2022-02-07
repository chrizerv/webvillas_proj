//Θεωρούμε ότι και τα 4 πεδία , είναι συμπληρωμένα με λάθος μορφή.
			var finalResults = new Array(4).fill(false);
			var ajaxObject = '';


			//Αρχικοποίηση AJAX
			function initAJAX() {
				  if (window.XMLHttpRequest) { 
				    return xmlhttp=new XMLHttpRequest();
				  } else if (window.ActiveXObject) {   
				    return xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  } else {   
				    alert("Your browser does not support AJAX calls!");
				    return false;
				  }
				}


			function myAJAXCall(type, value) {

			  ajaxObject=initAJAX();

			  if (ajaxObject) {

			    var url= './con_existence.php';
			    ajaxObject.open("POST",url,true);
			    ajaxObject.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			    ajaxObject.send("type="+type+"&"+"value="+value); 
		
			  } 
			} 

			

			function validateField(field){
				
				// Σε κάθε onblur ελέγχουμε ποιο πεδίο είναι. Άν είναι σωστό γίνεται πράσινο αλλιώς παραμένει κόκκινο μέχρι να γίνει σωστό!
				// Κάθε φορά που ένα πεδίο είναι σωστό η λάθος , ενημερώνεται αντίστοιχα, η αντίστοιχη θέση του στο finalResults.


				switch(field) {

					case 'username':
						
						var username=document.getElementById("username");
				 		var acceptedChars = new RegExp(/^\w{8,20}$/);
				 		
						if ( !acceptedChars.test(username.value) ){
							finalResults[0] = false;
							username.style.border="solid 2px red";
							alert('To username πρέπει να περιέχει τουλάχιστον 8 λατινικούς χαρακτήρες, οι οποίοι ανήκουν στα σύνολα A-Z, a-z, 0-9, _(κάτω παύλα) ');
							
  							
						}else{
							
							//Εάν το username έχει σωστή σύνταξη, ελέγχουμε δυναμικά άν τυχόν χρησιμοποιείται ήδη.
							myAJAXCall('username', username.value);
							ajaxObject.onreadystatechange=function() {
								
								response = '';			       
								if(ajaxObject.readyState==4 && ajaxObject.status==200) {

									response = ajaxObject.responseText;

									if (response === 'true'){      //χρησιμοποείται
										finalResults[0] = false;
										username.style.border="solid 2px red";
										alert('Αυτό το username χρησιμοποιείται ήδη.');
									}else{

										finalResults[0] = true;
										username.style.border="solid 2px green";
									}
								} 
							
							} 
						}


					break;

					case 'password':
						
						var password=document.getElementById("password");
				 		var acceptedChars = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,128}$/);
				 		var conpassword=document.getElementById("conpassword");

						
				 		
						if ( !acceptedChars.test(password.value) ){
							finalResults[1] = false;
							password.style.border="solid 2px red";
							alert('Το password πρέπει να περιέχει τουλάχιστον 8 λατινικούς χαρακτήρες με πεζά(a-z) ΚΑΙ κεφαλαία(A-Z) ΚΑΙ αριθμούς(0-9) ');
							
  							
						}else{

							finalResults[1] = true;
							password.style.border="solid 2px green";

							// Έλεγχος άν το password είναι ίδιο με το confirm password

							if ( (conpassword.value != "") && (conpassword.value !== password.value) ){
								finalResults[1] = false;
								password.style.border="solid 2px red";
								alert('Αναντιστοιχία των passwords. ');
							}
						}

					break;

					case 'email':

						
						var email=document.getElementById("email");
				 		var acceptedChars = new RegExp(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);
				 		
						if ( !acceptedChars.test(email.value) ){
							finalResults[2] = false;
							email.style.border="solid 2px red";
							alert('Λανθασμένο email !');
							
  							
						}else{
								//Εάν το email έχει σωστή σύνταξη, ελέγχουμε δυναμικά άν τυχόν χρησιμοποιείται ήδη.
								myAJAXCall('email', email.value);
								ajaxObject.onreadystatechange=function() {
								
								response = '';			       
								if(ajaxObject.readyState==4 && ajaxObject.status==200) {

									response = ajaxObject.responseText;
									
									if (response === 'true'){      //χρησιμοποείται
										finalResults[2] = false;
										email.style.border="solid 2px red";
										alert('Αυτό το email χρησιμοποιείται ήδη.');
									}else{

										finalResults[2] = true;
										email.style.border="solid 2px green";
									}
								} 
							
							} 

						}

					break;

					case 'conpassword':

						var password=document.getElementById("password");
						var conpassword=document.getElementById("conpassword");

						// Έλεγχος άν το confirm password είναι ίδιο με το password.(Το οποίο ήδη ελέγχεται για την μορφή του.)

						if ( (password.value != "") && (conpassword.value === password.value) ){
							finalResults[3] = true;
							conpassword.style.border="solid 2px green";
							
							
						}else{
							finalResults[3] = false;
							conpassword.style.border="solid 2px red";
							alert('Αναντιστοιχία των passwords. ');
						}

					break;

					default:


				}	
			}

			function validateForm(){
				
				//Άν ο πίνακας finalResults δέν έχει όλα τα στοιχεία true, κάτι δέν συμπληρώθηκε σωστά!
				//Επίσης, πρέπει να είναι σωστό και το captcha!

				var response = grecaptcha.getResponse();

				  if( finalResults.includes(false) || response.length === 0) 
				  { 
				    
				    alert("Υπάρχουν πεδία που δεν ελέγχθηκαν επιτυχώς!"); 
				    return false;
				  }

				  return true;

			}

			 