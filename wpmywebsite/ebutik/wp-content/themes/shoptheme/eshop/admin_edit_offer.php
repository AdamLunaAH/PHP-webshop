<?php 
/* Template Name: Admin Edit Offer Info */
	require "eshopfunctions.php";

	if (!isset($_SESSION['admin']) ) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();}
		
?>
<?php

		function adminOfferInfoHead() {
			$pdo = connectPDO();
				$offerPageNr = htmlspecialchars($_GET["offerid"]);
				$offerInfo = "SELECT DiscountID FROM erbjudanden WHERE DiscountID = :offerPageNr";
        $offerInfoResult = $pdo->prepare($offerInfo);
          $offerInfoResult->bindParam(':offerPageNr', $offerPageNr, PDO::PARAM_STR);
          $offerInfoResult->execute();
					if ($offerInfoResult->rowCount() > 0) {
            $row = $offerInfoResult->fetch(PDO::FETCH_ASSOC);
            echo "<h1>". $row["DiscountID"] . "</h1>" . "<br>";
					echo "";
          } else {
						echo "0 results";}
          $pdo = null;}

            // show current offer info
			function adminOfferInfoOld() {
				$pdo = connectPDO();
					$offerPageNr = htmlspecialchars($_GET["offerid"]);
					$offerInfo = "SELECT DiscountID, ProductID, ErbjudPris, Starttid, Sluttid FROM erbjudanden WHERE DiscountID = :offerPageNr";
					$offerInfoResult = $pdo->prepare($offerInfo);
          $offerInfoResult->bindParam(':offerPageNr', $offerPageNr, PDO::PARAM_STR);
          $offerInfoResult->execute();
					if ($offerInfoResult->rowCount() > 0) {
            $row = $offerInfoResult->fetch(PDO::FETCH_ASSOC);
							echo "<h2 class='h2text'>Nuvarande data</h2><div class='col-6 col-s-6'><ul class='proMainList'>
							<li>Erbjudandenummer</li><li class='proPageInfo'>" . $row["DiscountID"] . "</li>
              <li>Produktnummer</li><li class='proPageInfo'>" . $row["ProductID"] . "</li>
							<li>Erbjudandepris</li><li class='proPageInfo'>" . $row["ErbjudPris"] . "</li>
              <li>Starttid</li><li class='proPageInfo'>" . $row["Starttid"] . "</li>
              <li>Sluttid</li><li class='proPageInfo'>" . $row["Sluttid"] . "</li>
							</ul></div>";
						echo "";
					} else {
						echo "0 results";}
					$pdo = null;}
				

/* edit offer ProductID function */
function editOfferProductID($ProductID){
  $pdo = connectPDO();
  $offerPageNr = htmlspecialchars($_GET["offerid"]);
  $args = func_get_args();
  $args = array_map(function ($value) {
    return trim($value);
  }, $args);
  foreach ($args as $value) {
    if(empty($value)){
      return "Produktnummret måste fyllas i!";}}
  foreach ($args as $value) {
    if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
      return "Specialtecken får inte användas";}}
      if (is_numeric($ProductID) == false){
        return "Produktnummer är inte ett nummer";}
  $stmt = $pdo->prepare("UPDATE erbjudanden SET ProductID=:ProductID WHERE DiscountID = :offerPageNr");
  $stmt->bindParam(':ProductID', $ProductID, PDO::PARAM_STR);
  $stmt->bindParam(':offerPageNr', $offerPageNr, PDO::PARAM_INT);
  $stmt->execute();
  if ($stmt->rowCount() != 1) {
    return "Ett fel uppstod. Var god försök igen";
  } else {
    return "success";}}


// "connects" the input field data to the function for usage, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditOfferProductID() {
  $offerPageNr = htmlspecialchars($_GET["offerid"]);
if (isset($_POST['submitEditOfferProductID'])) {
$response = editOfferProductID($_POST['ProductID'] );}
if (@$response == "success") {
  if (isset($_POST['submitEditOfferProductID'])) { 
    echo "<script>alert('Produktnummret har ändrats till: " . htmlspecialchars($_POST['ProductID']) . "')</script>";
    echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-offer/?offerid=" . $offerPageNr . "'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["ProductID"]) . "</span><br>Produktnummret har ändrats.<br></p>";
    }	} else {
      echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
     }}

/* edit offer price function */
function editOfferPrice($ErbjudPris){
  $pdo = connectPDO();
  $offerPageNr = htmlspecialchars($_GET["offerid"]);
  $args = func_get_args();
  $args = array_map(function ($value) {
    return trim($value);
  }, $args);
  foreach ($args as $value) {
    if(empty($value)){
      return "Erbjudandepriset måste fyllas i!";}}
  foreach ($args as $value) {
    if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
      return "Specialtecken får inte användas";}}
      if (is_numeric($ErbjudPris) == false){
        return "Erbjudandepriset är inte ett nummer";}
  $stmt = $pdo->prepare("UPDATE erbjudanden SET ErbjudPris = :ErbjudPris WHERE DiscountID = :offerPageNr");
  $stmt->bindParam(':ErbjudPris', $ErbjudPris, PDO::PARAM_STR);
  $stmt->bindParam(':offerPageNr', $offerPageNr, PDO::PARAM_INT);
  $stmt->execute();
  if ($stmt->rowCount() != 1) {
    return "Ett fel uppstod. Var god försök igen";
  } else {
    return "success";}}


// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditOfferPrice() {
  $offerPageNr = htmlspecialchars($_GET["offerid"]);
  if (isset($_POST['submitEditOfferPrice'])) {
$response = editOfferPrice($_POST['ErbjudPris']);}
if (@$response == "success") {
if (isset($_POST['submitEditOfferPrice'])) {
  echo "<script>alert('Erbjudandepriset har ändrats till: " . htmlspecialchars($_POST['ErbjudPris']) . "')</script>";
  echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-offer/?offerid=" . $offerPageNr . "'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["ErbjudPris"]) . "</span><br>Erbjudandepriset har ändrats.<br></p>";
 }	} else {
  echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
}}

/* edit Offer Start Date function */
function editOfferStartDate($Starttid){
  $pdo = connectPDO();
  $offerPageNr = htmlspecialchars($_GET["offerid"]);
  setlocale(LC_ALL, 'se');
  date_default_timezone_get();
  $datetime = date('y-m-d');
  $args = func_get_args();
  $args = array_map(function ($value) {
    return trim($value);
  }, $args);
  foreach ($args as $value) {
    if(empty($value)){
      return "Starttiden måste fyllas i!";
    }
  }
  foreach ($args as $value) {
    if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
      return "Specialtecken får inte användas";
    }
  }
  if ($Starttid > $datetime){
    return "Ogiltig Starttid";
  }
  $stmt = $pdo->prepare("UPDATE erbjudanden SET Starttid = ? WHERE DiscountID = ?");
  $Starttid = $Starttid." 00:00:00";
  $stmt->bindParam(1, $Starttid);
  $stmt->bindParam(2, $offerPageNr);
  $stmt->execute();
  if ($stmt->rowCount() != 1) {
    return "Ett fel uppstod. Var god försök igen";
  } else {
    return "success";
  }
}


// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditOfferStartDate() {
  $offerPageNr = htmlspecialchars($_GET["offerid"]);
  if (isset($_POST['submitEditOfferStartDate'])) {
$response = editOfferStartDate($_POST['Starttid']);}
if (@$response == "success") {
if (isset($_POST['submitEditOfferStartDate'])) { 
echo "<script>alert('Starttiden har ändrats: " . htmlspecialchars($_POST['Starttid']) . "')</script>";
echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-offer/?offerid=" . $offerPageNr . "'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>"  . htmlspecialchars($_POST["Starttid"]) . "</span><br>Starttiden har ändrats.<br></p>";
 }	} else {
  echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
}}


// edit offer end date check function
function editOfferEndDate($Sluttid){
  $pdo = connectPDO();

  $offerPageNr = htmlspecialchars($_GET["offerid"]);
  
  $args = func_get_args();
  $args = array_map(function ($value) {
    return trim($value);
  }, $args);
  foreach ($args as $value) {
    if(empty($value)){
      return "Sluttid måste fyllas i!";}}
  foreach ($args as $value) {
    if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
      return "Specialtecken får inte användas";}}
      
  // Fetch start date
  $stmt = $pdo->prepare("SELECT Starttid FROM erbjudanden WHERE DiscountID = :offerPageNr");
  $stmt->bindParam(':offerPageNr', $offerPageNr, PDO::PARAM_INT);
  $stmt->execute();
  $startDate = $stmt->fetchColumn();
  
  // Check if end date is before start date
  if ($Sluttid < $startDate) {
    return "Sluttid måste vara senare än Starttid";
  }
  
  $stmt = $pdo->prepare("UPDATE erbjudanden SET Sluttid = :Sluttid WHERE DiscountID = :offerPageNr");
  $stmt->bindParam(':Sluttid', $Sluttid, PDO::PARAM_STR);
  $stmt->bindParam(':offerPageNr', $offerPageNr, PDO::PARAM_INT);
  $stmt->execute();
  if ($stmt->rowCount() != 1) {
    return "Ett fel uppstod. Var god försök igen";
  } else {
    return "success";
  }
}

// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditOfferEndDate() {
  $offerPageNr = htmlspecialchars($_GET["offerid"]);
  if (isset($_POST['submitEditOfferEndDate'])) {
$response = editOfferEndDate($_POST['Sluttid']);}
if (@$response == "success") {
  if (isset($_POST['submitEditOfferEndDate'])) { 
    echo "<script>alert('Sluttiden har ändrats till: " . htmlspecialchars($_POST['Sluttid']) . "')</script>";
    echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-offer/?offerid=" . $offerPageNr . "'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Sluttid"]) . "</span><br>Sluttiden har ändrats.<br></p>";
  }	} else {
    echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
  }}


/* Edit offer all function */
function editOfferAll($ProductID, $ErbjudPris, $Starttid, $Sluttid){
  $pdo = connectPDO();
  $offerPageNr = htmlspecialchars($_GET["offerid"]);
  // Set time zone and time format
  setlocale(LC_ALL, 'se');
  date_default_timezone_get();
  $datetime = date('y-m-d');  
  $args = func_get_args();
  $args = array_map(function ($value) {
    return trim($value);
  }, $args);
  foreach ($args as $value) {
    if(empty($value)){
      return "Alla fälten måste fyllas i";    }  }
  foreach ($args as $value) {
    if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
      return "Specialtecken får inte användas";    }  }
  // Check if the ProductID argument is a number
  if (is_numeric($ProductID) == false){
    return "ProductID är inte ett nummer";  }
  // Check if Starttid is after current time
  if ($Starttid > $datetime){
    return "Ogiltig Starttid";  } 
  // Check if Sluttid is after Starttid
  if ($Sluttid <= $Starttid){
    return "Ogiltig Sluttid";  }
    // Check if the ProductID argument is a number
  if (is_numeric($ErbjudPris) == false){
    return "Erbjudandepriset är inte ett nummer";  }   
  // Prepare an update statement to edit the selected information in the database
  $stmt = $pdo->prepare("UPDATE erbjudanden SET ProductID = :ProductID, ErbjudPris = :ErbjudPris, Starttid = :Starttid, Sluttid = :Sluttid WHERE DiscountID = :offerPageNr");
  	// Bind the values to the statement
  $stmt->bindParam(':ProductID', $ProductID, PDO::PARAM_INT);
  $stmt->bindParam(':ErbjudPris', $ErbjudPris, PDO::PARAM_STR);
  $stmt->bindParam(':Starttid', $Starttid, PDO::PARAM_STR);
  $stmt->bindParam(':Sluttid', $Sluttid, PDO::PARAM_STR);
  $stmt->bindParam(':offerPageNr', $offerPageNr, PDO::PARAM_INT);
  	// Execute the statement
  $stmt->execute();
  	// Check if the statement executed successfully, if not, return an error message
  if ($stmt->rowCount() != 1) {
    return "Ett fel uppstod. Var god försök igen";
  } else {
    return "success";  }}

    // "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditOfferAll() {
  //Getting the database table row ID from the URL, and sanitizing the input
  $offerPageNr = htmlspecialchars($_GET["offerid"]);
    //Checking if the form has been submitted
  if (isset($_POST['submitEditOfferAll'])) {
    //Call the function with the values from the form
$response = editOfferAll($_POST['ProductID'], $_POST['ErbjudPris'], $_POST['Starttid'], $_POST['Sluttid']);}
  //Checking if the function call returned "success"
if (@$response == "success") {
      //If the form was submitted and the call was successful
if (isset($_POST['submitEditOfferAll'])) { 
echo "<script>alert('All erbjudandedata har ändrats: " . "')</script>";
echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-offer/?offerid=" . $offerPageNr . "'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'></span><br>Erbjudandet har ändrats.<br></p>";
}	} else {
      //If the call returned an error message
  echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>"; } }


?>


<?php get_header();?>
<main>

<div class="row">
<div class="col-4 col-s-4"></div>
<div class="col-4 col-s-4">
  <?php 
    adminOfferInfoHead();
  ?>
</div>
</div>
<div class="row">
<div class="col-1 col-s-1"></div>
<div class="col-5 col-s-5">
<div class="products">

<!-- creates product info page -->
<?php adminOfferInfoOld(); ?>
</div></div>


<div class="col-5 col-s-5">
<div class="productform">
<!-- edit product form -->
<form class="registrationForm" action="#" method="post" autocomplete="on">
<div class="col-12 col-s-12">
<h2 class='h2text'>Ändra erbjudande</h2>
<p class="topText">
  Ändra erbjudandeinformation.<br><br>
</p></div>
<div class="row"></div><div class="row">
  <div class="registrationField">
    <label>Produktnummer</label>
    <div class="formInputButtonRow"><input class="registrationInput" type="text" name="ProductID" value="<?php echo htmlspecialchars(@$_POST['Produktnamn']); ?>" >
    <button class="registrationSubmitMany" type="submit" name="submitEditOfferProductID">Ändra</button></div><?php responseEditOfferProductID(); ?>
  </div>
  <div class="registrationField">
    <label>Erbjudandepris</label>
    <div class="formInputButtonRow"><input class="registrationInput" type="text" name="ErbjudPris" value="<?php echo htmlspecialchars(@$_POST['Produktbeskrivning']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditOfferPrice">Ändra</button></div><?php responseEditOfferPrice(); ?></div>
  <div class="registrationField">
    <label>Starttid</label>
    <div class="formInputButtonRow"><input class="registrationInput" type="date" name="Starttid" value="<?php echo htmlspecialchars(@$_POST['CategoryID']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditOfferStartDate">Ändra</button></div><?php responseEditOfferStartDate(); ?></div>
  <div class="registrationField">
    <label>Sluttid</label>
    <div class="formInputButtonRow"><input class="registrationInput" type="date" name="Sluttid" value="<?php echo htmlspecialchars(@$_POST['Pris']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditOfferEndDate">Ändra</button></div><?php responseEditOfferEndDate(); ?></div>
<div class="rowThings">
<div class="formInputButton"><button class="registrationSubmit" type="submit" name="submitEditOfferAll">Ändra allt</button></div><?php responseEditOfferAll(); ?>	</div></div></div></form></div>
</div></div>
		
</main>
		<?php get_footer();?>