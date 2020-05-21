<!DOCTYPE html>
<html lang="el">
<head>
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<meta charset="utf-8" />
	<title>Login</title>
</head>
<body>

 <form id="userdata" name="userdata" action="con_login.php" method="post" onsubmit="return true" >
   
         
    <table style="width: 100%;">
      <tr>
        <!-- για ευκολία, βάζουμε πλάτος κελιού με τον παλιό τρόπο και όχι
          με CSS. Δεν χρειάζεται να το κάνουμε για όλα τα κελιά! Αρκεί για
          τα κελιά της πρώτης σειράς του πίνακα. -->
        <td width="25%">&nbsp;</td>
        <td>LOGIN</td>
      </tr>
      <tr>
        <td ><strong>username</strong>:</td>
        <td>
          <input type="text" name="username" id="username" size="25" maxlength="25" 
                 onfocus="highlightOn('username');" onblur="highlightOff('username');" />
        </td>
      </tr>
      <tr>
        <td class="right"><strong>password</strong>:</td>
        <td>
          <input type="password" name="password" id="password" size="25" maxlength="25"
                 onfocus="highlightOn('password');" onblur="highlightOff('password');" />
        </td>
      </tr>
      <tr>
      	<td>
      		<button name="submit" type="submit" id="submit" value="Αποστολή">Αποστολή</button>
      	</td>
      </tr> 
    </table>
  </form>

	
</body>


</html>