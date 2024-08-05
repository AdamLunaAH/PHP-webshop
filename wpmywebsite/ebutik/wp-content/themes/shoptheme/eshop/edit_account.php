<?php 
/* Template Name: Self Edit Account Info */
	require "eshopfunctions.php";

	if (!isset($_SESSION['userid']) ) {
		header("location: /wpmywebsite/ebutik/logga-in/");
		exit();}
		
?>
<?php

function userInfoHead() {
  $pdo = connectPDO();
  $useridNr = htmlspecialchars($_SESSION["userid"]);
  $memberInfo = "SELECT Fornamn FROM medlem WHERE MemberID = :useridNr";
  $stmt = $pdo->prepare($memberInfo);
  $stmt->bindParam(':useridNr', $useridNr);
  $stmt->execute();
  $memberInfoResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if ($memberInfoResult !== false && count($memberInfoResult) > 0) {
    echo "<h1>Information om ". $memberInfoResult[0]["Fornamn"] . "</h1>" . "
    <br>";
  } else {
    echo "0 results";
  }
	$pdo = null;
}

// current meber data
function userInfoOld() {
  $pdo = connectPDO();
  $useridNr = htmlspecialchars($_SESSION["userid"]);
  $memberInfo = "SELECT MemberID, Fornamn, Efternamn, Epost, Mobilnr, Gatuadress, Postnr, Ort, Skapad FROM Medlem WHERE MemberID = :userid";
  $stmt = $pdo->prepare($memberInfo);
  $stmt->execute(['userid' => $useridNr]);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if (!empty($rows)) {
    echo "<h2 class='h2text'>Nuvarande data</h2><div class='col-6 col-s-6'><ul class='proMainList'>";
    foreach ($rows as $row) {
      echo "<li>Medlemsnummer</li><li class='proPageInfo'>" . $row["MemberID"] . "</li>
      <li>Förnamn</li><li class='proPageInfo'>" . $row["Fornamn"] . "</li>
      <li>Efternamn</li><li class='proPageInfo'>" . $row["Efternamn"] . "</li>
      <li>E-post</li><li class='proPageInfo'>" . $row["Epost"] . "</li>
      <li>Mobilnummer</li><li class='proPageInfo'>" . $row["Mobilnr"] . "</li>
      <li>Gatuadress</li><li class='proPageInfo'>" . $row["Gatuadress"] . "</li>
      <li>Postnummer</li><li class='proPageInfo'>" . $row["Postnr"] . "</li>
      <li>Ort</li><li class='proPageInfo'>" . $row["Ort"] . "</li>
      <li>Konton skapads</li><li class='proPageInfo'>" . $row["Skapad"] . "</li>";
    }
    echo "</ul></div>";
  } else {
    echo "0 results";
  }
	$pdo = null;
}
				


		/* edit member account first name function */
		function editFornamn($Fornamn){
			$pdo = connectPDO();
			$useridNr = htmlspecialchars($_SESSION["userid"]);
			$args = func_get_args();
			$args = array_map(function ($value) {
				return trim($value);
			}, $args);
			foreach ($args as $value) {
				if(empty($value)){
					return "Förnamnet måste fyllas i!";}}
			foreach ($args as $value) {
				if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
					return "Specialtecken får inte användas";}}
				if (strlen($Fornamn) > 40) {
					return "Förnamnet är för långt (max 40 tecken)";}
			$stmt = $pdo->prepare("UPDATE medlem SET Fornamn=:Fornamn WHERE MemberID = :useridNr");
			$stmt->bindParam(":Fornamn", $Fornamn);
			$stmt->bindParam(":useridNr", $useridNr);
			$stmt->execute();
			if ($stmt->rowCount() != 1) {
				return "Ett fel uppstod. Var god försök igen";
			} else {
				return "success";
			}
		}
	
	
	// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
		function responseEditFornamn() {
		if (isset($_POST['submitEditFornamn'])) {
		$response = editFornamn($_POST['Fornamn'] );}
		if (@$response == "success") {
			if (isset($_POST['submitEditFornamn'])) { 
				echo "<script>alert('Förnamnet har ändrats till: " . htmlspecialchars($_POST['Fornamn']) . "')</script>";
				echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/self-edit-account/'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Fornamn"]) . "</span><br>Förnamnet har ändrats.<br></p>";
				}	} else {
					echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
				}}

	// edit account last name function
	function editEfternamn($Efternamn){
		$pdo = connectPDO();
		$useridNr = htmlspecialchars($_SESSION["userid"]);
		$args = func_get_args();
		$args = array_map(function ($value) {
			return trim($value);
		}, $args);
		foreach ($args as $value) {
			if(empty($value)){
				return "Efternamnet måste fyllas i!";}}
		foreach ($args as $value) {
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
				return "Specialtecken får inte användas";}}
			if (strlen($Efternamn) > 10) {
				return "Efternamnet är för långt (max 100 tecken)";}
		$stmt = $pdo->prepare("UPDATE medlem SET Efternamn=:Efternamn WHERE MemberID = :useridNr");
		$stmt->bindParam(":Efternamn", $Efternamn);
		$stmt->bindParam(":useridNr", $useridNr);
		$stmt->execute();
		if ($stmt->rowCount() != 1) {
			return "Ett fel uppstod. Var god försök igen";
		} else {
			return "success";
		}
	}


// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
	function responseEditEfternamn() {
	if (isset($_POST['submitEditEfternamn'])) {
	$response = editEfternamn($_POST['Efternamn'] );}
	if (@$response == "success") {
		if (isset($_POST['submitEditEfternamn'])) { 
			echo "<script>alert('Efternamnet har ändrats till: " . htmlspecialchars($_POST['Efternamn']) . "')</script>";
			echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/self-edit-account/'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Efternamn"]) . "</span><br>Efternamn har ändrats.<br></p>";
			}	} else {
				echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
			}}

/* edit member email function */
	function editEpost($Epost){
		$pdo = connectPDO();
		$useridNr = htmlspecialchars($_SESSION["userid"]);
		$args = func_get_args();
		$args = array_map(function ($value) {
			return trim($value);
		}, $args);
		foreach ($args as $value) {
			if(empty($value)){
				return "Eposten måste fyllas i!";}}
		foreach ($args as $value) {
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
				return "Specialtecken får inte användas";}}
			if (strlen($Epost) > 100) {
				return "E-postadressen är för lång (max 100 tecken)";}
				if (!filter_var($Epost, FILTER_VALIDATE_EMAIL)) {
					return "E-post är inte giltig";}
		$stmt = $pdo->prepare("UPDATE medlem SET Epost=:Epost WHERE MemberID = :useridNr");
		$stmt->bindParam(":Epost", $Epost);
		$stmt->bindParam(":useridNr", $useridNr);
		$stmt->execute();
		if ($stmt->rowCount() != 1) {
			return "Ett fel uppstod. Var god försök igen";
		} else {
			return "success";
		}
	}


// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditEpost() {
if (isset($_POST['submitEditEpost'])) {
$response = editEpost($_POST['Epost']);}
if (@$response == "success") {
	if (isset($_POST['submitEditEpost'])) { 
		echo "<script>alert('E-post har ändrats till: " . htmlspecialchars($_POST['Epost']) . "')</script>";
				echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/self-edit-account/'>";
        session_destroy();
        header("Refresh:0");
        exit();
				echo "<p class='success registrationSuccess><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Epost"]) . "</span><br>E-post har ändrats.<br></p>";
		}	} else {
			echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
		}}


/* edit member password function */
	function editpassword($password, $confirm_password){
		$pdo = connectPDO();
		$useridNr = htmlspecialchars($_SESSION["userid"]);
		$args = func_get_args();
		$args = array_map(function ($value) {
			return trim($value);
		}, $args);
		foreach ($args as $value) {
			if(empty($value)){
				return "The password fields must be filled in!";}}
		foreach ($args as $value) {
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
				return "Special characters are not allowed";}}
		if (strlen($password) > 255) {
			return "Password is too long";}
		if (strlen($password) < 10) {
			return "Password is too short, the password must consist of at least 10 characters";}
		if ($password != $confirm_password) {
			return "The passwords are not the same";}
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		$stmt = $pdo->prepare("UPDATE medlem SET password = :password WHERE MemberID = :useridNr");
		$stmt->bindParam(":password", $hashed_password);
		$stmt->bindParam(":useridNr", $useridNr);
		$stmt->execute();
		if ($stmt->rowCount() != 1) {
			return "An error occurred. Please try again";
		} else {
			return "success";
		}
	}
	
	
	// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
		function responseEditpassword() {
		if (isset($_POST['submitEditpassword'])) {
		$response = editpassword($_POST['password'], $_POST['confirm_password']);}
		if (@$response == "success") {
			if (isset($_POST['submitEditpassword'])) { 
				echo "<script>alert('Lösenordet har ändrats.')</script>";
				echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/self-edit-account/'>";
        session_destroy();
        header("Refresh:0");
        exit();
        echo "<p class='success registrationSuccess'><span class='registrationSuccessHead'></span><br>Lösenordet har ändrats.<br></p>";
				}	} else {
					echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
				}}

/* edit member mobile number function */
		function editMobilnr($Mobilnr){
			$pdo = connectPDO();
			$useridNr = htmlspecialchars($_SESSION["userid"]);
			$args = func_get_args();
			$args = array_map(function ($value) {
				return trim($value);
			}, $args);
			foreach ($args as $value) {
				if(empty($value)){
					return "Mobilnumret måste fyllas i!";}}
			foreach ($args as $value) {
				if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
					return "Specialtecken får inte användas";}}
				if (is_numeric($Mobilnr) == false){
					return "Mobilnumret får bara innehålla siffror";}
			  if (strlen($Mobilnr) > 20) {
					return "Mobilnumret är för långt (max 20 tecken)";}
			$stmt = $pdo->prepare("UPDATE medlem SET Mobilnr=:Mobilnr WHERE MemberID = :useridNr");
			$stmt->bindParam(":Mobilnr", $Mobilnr);
			$stmt->bindParam(":useridNr", $useridNr);
			$stmt->execute();
			if ($stmt->rowCount() != 1) {
				return "Ett fel uppstod. Var god försök igen";
			} else {
				return "success";
			}
		}

// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditMobilnr() {
if (isset($_POST['submitEditMobilnr'])) {
$response = editMobilnr($_POST['Mobilnr']);}
if (@$response == "success") {
	if (isset($_POST['submitEditMobilnr'])) { 
		echo "<script>alert('Mobilnumret har ändrats till: " . htmlspecialchars($_POST['Mobilnr']) . "')</script>";
				echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/self-edit-account/'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Mobilnr"]) . "</span><br>Mobilnumret har ändrats.<br></p>";
		}	} else {
			echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
		}}

// edit member street address function
	function editGatuadress($Gatuadress){
		$pdo = connectPDO();
		$useridNr = htmlspecialchars($_SESSION["userid"]);
		$args = func_get_args();
		$args = array_map(function ($value) {
			return trim($value);
		}, $args);
		foreach ($args as $value) {
			if(empty($value)){
				return "Gatuadressen måste fyllas i!";}}
		foreach ($args as $value) {
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
				return "Specialtecken får inte användas";}}
			if (strlen($Gatuadress) > 100) {
				return "Gatuadressen är för lång (max 100 tecken)";}
		$stmt = $pdo->prepare("UPDATE medlem SET Gatuadress=:Gatuadress WHERE MemberID = :useridNr");
		$stmt->bindParam(":Gatuadress", $Gatuadress);
		$stmt->bindParam(":useridNr", $useridNr);
		$stmt->execute();
		if ($stmt->rowCount() != 1) {
			return "Ett fel uppstod. Var god försök igen";
		} else {
			return "success";
		}
	}

	// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
    function responseEditGatuadress() {
    if (isset($_POST['submitEditGatuadress'])) {
    $response = editGatuadress($_POST['Gatuadress']);}
    if (@$response == "success") {
      if (isset($_POST['submitEditGatuadress'])) { 
        echo "<script>alert('Gatuadressen har ändrats till: " . htmlspecialchars($_POST['Gatuadress']) . "')</script>";
            echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/self-edit-account/'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Gatuadress"]) . "</span><br>Gatuadressen har ändrats.<br></p>";
        }	} else {
					echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
				}}

// edit member post code function
	function editPostnr($Postnr){
		$pdo = connectPDO();
		$useridNr = htmlspecialchars($_SESSION["userid"]);
		$args = func_get_args();
		$args = array_map(function ($value) {
			return trim($value);
		}, $args);
		foreach ($args as $value) {
			if(empty($value)){
				return "Postnumret måste fyllas i!";}}
		foreach ($args as $value) {
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
				return "Specialtecken får inte användas";}}
			if (strlen($Postnr) > 10) {
				return "Postnumret är för långt (max 10 tecken)";}
		$stmt = $pdo->prepare("UPDATE medlem SET Postnr=:Postnr WHERE MemberID = :useridNr");
		$stmt->bindParam(":Postnr", $Postnr);
		$stmt->bindParam(":useridNr", $useridNr);
		$stmt->execute();
		if ($stmt->rowCount() != 1) {
			return "Ett fel uppstod. Var god försök igen";
		} else {
			return "success";
		}
	}

	// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
        function responseEditPostnr() {
        if (isset($_POST['submitEditPostnr'])) {
        $response = editPostnr($_POST['Postnr']);}
        if (@$response == "success") {
          if (isset($_POST['submitEditPostnr'])) { 
            echo "<script>alert('Postnumret har ändrats till: " . htmlspecialchars($_POST['Postnr']) . "')</script>";
                echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/self-edit-account/'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Postnr"]) . "</span><br>Postnumret har ändrats<br></p>";
            }	} else {
							echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
						}}


// edit member area function
	function editOrt($Ort){
		$pdo = connectPDO();
		$useridNr = htmlspecialchars($_SESSION["userid"]);
		$args = func_get_args();
		$args = array_map(function ($value) {
			return trim($value);
		}, $args);
		foreach ($args as $value) {
			if(empty($value)){
				return "Ortnamnet måste fyllas i!";}}
		foreach ($args as $value) {
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
				return "Specialtecken får inte användas";}}
			if (strlen($Ort) > 40) {
				return "Ortnamnet är för långt (max 40 tecken)";}
		$stmt = $pdo->prepare("UPDATE medlem SET Ort=:Ort WHERE MemberID = :useridNr");
		$stmt->bindParam(":Ort", $Ort);
		$stmt->bindParam(":useridNr", $useridNr);
		$stmt->execute();
		if ($stmt->rowCount() != 1) {
			return "Ett fel uppstod. Var god försök igen";
		} else {
			return "success";
		}
	}

	// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
	function responseEditOrt() {
	if (isset($_POST['submitEditOrt'])) {
	$response = editOrt($_POST['Ort']);}
	if (@$response == "success") {
		if (isset($_POST['submitEditOrt'])) { 
			echo "<script>alert('Orten har ändrats till: " . htmlspecialchars($_POST['Ort']) . "')</script>";
					echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/self-edit-account/'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Ort"]) . "</span><br>Orten har ändrats.<br></p>";
			}	} else {
				echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
			}}




/* change all member data function */

		function editMemberAll($Fornamn, $Efternamn, $Epost, $password, $confirm_password, $Mobilnr, $Gatuadress, $Postnr, $Ort) {
			$pdo = connectPDO();
			$useridNr = htmlspecialchars($_SESSION["userid"]);
			$args = func_get_args();
			$args = array_map(function ($value) {
					return trim($value);
			}, $args);
			foreach ($args as $value) {
					if (empty($value)) {
							return "Alla fälten måste fyllas i";
					}
			}
			foreach ($args as $value) {
					if (preg_match("/([[\/[^\'<|£$%^&*()}{:\'#~?><>,;\|\-=\-_+\-¬\`\]';>])/", $value)) {
							return "Specialtecken får inte användas";
					}
			}
			if (strlen($Fornamn) > 40) {
					return "Förnamnet är för långt (max 40 tecken)";
			}
			if (strlen($Efternamn) > 100) {
					return "Efternamnet är för långt (max 100 tecken)";
			}
			if (!filter_var($Epost, FILTER_VALIDATE_EMAIL)) {
					return "E-post är inte giltig";
			}
			if (strlen($password) > 255) {
					return "Lösenordet är för långt";
			}
			if (strlen($password) < 10) {
					return "Lösenordet är för kort, lösenordet måste bestå av minst 10 tecken";
			}
			if ($password != $confirm_password) {
					return "Lösenorden är inte lika";
			}
			if (is_numeric($Mobilnr) == false) {
					return "Mobilnumret får bara innehålla siffror";
			}
			if (strlen($Mobilnr) > 20) {
					return "Mobilnumret är för långt (max 20 tecken)";
			}
			if (strlen($Gatuadress) > 100) {
					return "Adressen är för lång (max 100 tecken)";
			}
			if (strlen($Postnr) > 10) {
					return "Postnumret är för långt (max 10 tecken)";
			}
			if (strlen($Ort) > 40) {
					return "Ortnamnet är för lång (max 40 tecken)";
			}
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $pdo->prepare("UPDATE medlem SET Fornamn=?, Efternamn =?, Epost =?, password =?, Mobilnr =?, Gatuadress =?, Postnr =?, Ort =? WHERE MemberID = ?");
			$stmt->bindParam(1, $Fornamn, PDO::PARAM_STR);
			$stmt->bindParam(2, $Efternamn, PDO::PARAM_STR);
			$stmt->bindParam(3, $Epost, PDO::PARAM_STR);
			$stmt->bindParam(4, $hashed_password, PDO::PARAM_STR);
			$stmt->bindParam(5, $Mobilnr, PDO::PARAM_STR);
			$stmt->bindParam(6, $Gatuadress, PDO::PARAM_STR);
			$stmt->bindParam(7, $Postnr, PDO::PARAM_STR);
			$stmt->bindParam(8, $Ort, PDO::PARAM_STR);
			$stmt->bindParam(9, $useridNr, PDO::PARAM_STR);
			$stmt->execute();
			if ($stmt->rowCount() != 1) {
				return "Ett fel uppstod. Var god försök igen";
			} else {
				return "success";
			}
		}

		// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditMemberAll() {
if (isset($_POST['submitEditMemberAll'])) {
$response = editMemberAll($_POST['Fornamn'], $_POST['Efternamn'], $_POST['Epost'], $_POST['password'], $_POST['confirm_password'], $_POST['Mobilnr'], $_POST['Gatuadress'], $_POST['Postnr'], $_POST['Ort']);}
if (@$response == "success") {
	if (isset($_POST['submitEditMemberAll'])) { 
		echo "<script>alert('All medlemsinformation har ändrats: " . htmlspecialchars($_POST['Produktnamn']) . "')</script>";
				echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/self-edit-account/'>";
        session_destroy();
        header("Refresh:0");
        exit();
				echo "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Fornamn"]) . "</span><br>Medlemsinformationen har ändrats.<br></p>";
		}	} else {
			echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
		}}


?>


<?php get_header();?>
<main>

	<div class="row">
    <div class="col-4 col-s-4"></div>
    <div class="col-4 col-s-4">
      <?php 
        userInfoHead();
      ?>
    </div>
  </div>
	<div class="row">
		<div class="col-1 col-s-1"></div>
	<div class="col-5 col-s-5">
	<div class="products">
		
		<!-- creates current member info  -->
    <?php userInfoOld(); ?>
  </div></div>


	<div class="col-5 col-s-5">
	<div class="productform">
	<!-- edit member data form -->
	<form class="registrationForm" action="#" method="post" autocomplete="on">
		<div class="col-12 col-s-12">
		<h2 class='h2text'>Ändra medlemsinformation</h2>
		<p class="topText">
			Ändra information.<br><br>
	</p></div>
<div class="row"></div><div class="row">
			<div class="registrationField">
				<label>Förnamn</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="text" name="Fornamn" value="<?php echo htmlspecialchars(@$_POST['Fornamn']); ?>" >
				<button class="registrationSubmitMany" type="submit" name="submitEditFornamn">Ändra</button></div><?php responseEditFornamn(); ?>
			</div>
			<div class="registrationField">
				<label>Efternamn</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="text" name="Efternamn" value="<?php echo htmlspecialchars(@$_POST['Efternamn']); ?>" >
				<button class="registrationSubmitMany" type="submit" name="submitEditEfternamn">Ändra</button></div><?php responseEditEfternamn(); ?>
			</div>
			<div class="registrationField">
				<label>E-post</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="email" name="Epost" value="<?php echo htmlspecialchars(@$_POST['Epost']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditEpost">Ändra</button></div><?php responseEditEpost(); ?></div>
			<div class="registrationField">
				<label>Lösenord</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="password" id="psw" name="password" value="<?php echo htmlspecialchars(@$_POST['password']); ?>" ><i class="pswToggle showPass fa-solid fa-eye" onclick="pswShow(this)">Tryck här</i><button class="registrationSubmitMany" type="submit" name="submitEditPassword">Ändra</button></div><?php responseEditPassword(); ?></div>
      <div class="registrationField">
				<label>Reppetera Lösenord</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="password" id="reppsw" name="confirm_password" value="<?php echo htmlspecialchars(@$_POST['confirm_password']); ?>" ><i class="pswToggle showPass fa-solid fa-eye" onclick="pswShow(this)">Tryck här</i><button class="registrationSubmitMany" type="submit" name="submitEditpassword">Ändra</button></div><?php responseEditPassword(); ?></div>
			<div class="registrationField">
				<label>Mobilnummer</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="text" name="Mobilnr" value="<?php echo htmlspecialchars(@$_POST['Mobilnr']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditMobilnr">Ändra</button></div><?php responseEditMobilnr(); ?></div>
      <div class="registrationField">
				<label>Gatuadress</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="text" name="Gatuadress" value="<?php echo htmlspecialchars(@$_POST['Gatuadress']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditGatuadress">Ändra</button></div><?php responseEditGatuadress(); ?></div>
      <div class="registrationField">
				<label>Postnummer</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="text" name="Postnr" value="<?php echo htmlspecialchars(@$_POST['Postnr']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditPostnr">Ändra</button></div><?php responseEditPostnr(); ?></div>
      <div class="registrationField">
				<label>Ort</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="text" name="Ort" value="<?php echo htmlspecialchars(@$_POST['Ort']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditOrt">Ändra</button></div><?php responseEditOrt(); ?></div>
		<div class="rowThings">
		<div class="formInputButton"><button class="registrationSubmit" type="submit" name="submitEditMemberAll">Ändra allt</button></div><?php responseEditMemberAll(); ?>	</div></div></div></form></div>
		</div></div>
		
</main>
		<?php get_footer();?>