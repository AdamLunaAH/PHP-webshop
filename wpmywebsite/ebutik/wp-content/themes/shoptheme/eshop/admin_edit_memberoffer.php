<?php 
/* Template Name: Admin Edit Member Offer Info */
	require "eshopfunctions.php";

	if (!isset($_SESSION['admin']) ) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();}
		
?>
<?php

function adminMemberOfferInfoHead() {
  $pdo = connectPDO();
  $memberofferPageNr = htmlspecialchars($_GET["memberofferid"]);
  $stmt = $pdo->prepare("SELECT OfferID FROM medlemserbjudanden WHERE OfferID = :offerid");
  $stmt->bindParam(':offerid', $memberofferPageNr, PDO::PARAM_INT);
  $stmt->execute();
  if ($stmt->rowCount() > 0) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          echo "<h1>" . $row["OfferID"] . "</h1>" . "<br>";
      }
      echo "";
  } else {
      echo "0 results";
  }
  $pdo = null;
}

// current memberoffer info
function adminMemberOfferInfoOld() {
  $pdo = connectPDO();
  $memberofferPageNr = htmlspecialchars($_GET["memberofferid"]);
  $stmt = $pdo->prepare("SELECT OfferID, MemberID, DiscountID FROM medlemserbjudanden WHERE OfferID = :offerid");
  $stmt->bindParam(':offerid', $memberofferPageNr, PDO::PARAM_INT);
  $stmt->execute();
  if ($stmt->rowCount() > 0) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          echo "<h2 class='h2text'>Nuvarande data</h2><div class='col-6 col-s-6'><ul class='proMainList'>
                <li>Medlemserbjudandenummer</li><li class='proPageInfo'>" . $row["OfferID"] . "</li>
                <li>Medlemsnummer</li><li class='proPageInfo'>" . $row["MemberID"] . "</li>
                <li>Erbjudandenummer</li><li class='proPageInfo'>" . $row["DiscountID"] . "</li>
              </ul></div>";
      }
      echo "";
  } else {
      echo "0 results";
  }
  $pdo = null;
}
				


// function to edit a member offer based on the MemberID
function editMemberOfferMemberID($MemberID) {
  
  // Connect to the database using the function connectPDO
  $pdo = connectPDO();
  
  // retrieve the OfferID from the URL query string and sanitize it
  $memberofferPageNr = htmlspecialchars($_GET["memberofferid"]);
  
  // Get the arguments passed to the function and trim them
  $args = func_get_args();
  $args = array_map(function ($value) {
    return trim($value);
  }, $args);

  // Check if any of the arguments are empty
  foreach ($args as $value) {
    if(empty($value)){
      return "Medlemsnumret måste fyllas i!";
    }
  }
  
  // Check if any of the arguments contain special characters
  foreach ($args as $value) {
    if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
      return "Specialtecken får inte användas";
    }
  }

  // Check if the MemberID is a number
  if (is_numeric($MemberID) == false) {
    return "Medlemsnummer är inte ett nummer";
  }

  // Prepare the SQL statement
  $stmt = $pdo->prepare("UPDATE medlemserbjudanden SET MemberID=:memberID WHERE OfferID = :offerID");

  // Bind the parameters to the statement
  $stmt->bindParam(':memberID', $MemberID, PDO::PARAM_STR);
  $stmt->bindParam(':offerID', $memberofferPageNr, PDO::PARAM_INT);

  // Execute the statement
  $stmt->execute();

  // Check if the statement was successful
  if ($stmt->rowCount() != 1) {
    return "Ett fel uppstod. Var god försök igen";
  } else {
    return "success";
  }
}


// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditMemberOfferMemberID() {
  $memberofferPageNr = htmlspecialchars($_GET["memberofferid"]);
if (isset($_POST['submitEditOfferProductID'])) {
$response = editMemberOfferMemberID($_POST['MemberID'] );}

if (@$response == "success") {
  if (isset($_POST['submitEditMemberOfferMemberID'])) { 
    echo "<script>alert('Medlemsnumret har ändrats till: " . htmlspecialchars($_POST['MemberID']) . "')</script>";
    echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-memberoffer/?memberofferid=" . $memberofferPageNr . "'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["MemberID"]) . "</span><br>Medlemsnumret har ändrats.<br></p>";
    }	} else {
      echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
    }}

/* change DiscountID function */
function editMemberOfferDiscountID($DiscountID){
  $pdo = connectPDO();
  $memberofferPageNr = htmlspecialchars($_GET["memberofferid"]);
  $args = func_get_args();
  $args = array_map(function ($value) {
    return trim($value);
  }, $args);
  foreach ($args as $value) {
    if(empty($value)){
      return "Erbjudandenumret måste fyllas i!";}}
  foreach ($args as $value) {
    if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
      return "Specialtecken får inte användas";}}
      if (is_numeric($DiscountID) == false){
        return "Erbjudandenumret är inte ett nummer";}
  $stmt = $pdo->prepare("UPDATE medlemserbjudanden SET DiscountID = :DiscountID WHERE OfferID = :memberofferPageNr");
  $stmt->bindParam(':DiscountID', $DiscountID, PDO::PARAM_INT);
  $stmt->bindParam(':memberofferPageNr', $memberofferPageNr, PDO::PARAM_INT);
  $stmt->execute();
  if ($stmt->rowCount() != 1) {
    return "Ett fel uppstod. Var god försök igen";
  } else {
    return "success";
  }
}


// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditMemberOfferDiscountID() {
  $memberofferPageNr = htmlspecialchars($_GET["memberofferid"]);
  if (isset($_POST['submitEditMemberOfferDiscountID'])) {
$response = editOfferPrice($_POST['DiscountID']);}
/* if statement for a for a correct account creation or else for incorrect creation and what show what the fault is. */
if (@$response == "success") {
if (isset($_POST['submitEditOfferPrice'])) {
  echo "<script>alert('Erbjudandenumret har ändrats till: " . htmlspecialchars($_POST['DiscountID']) . "')</script>";
  echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-memberoffer/?memberofferid=" . $memberofferPageNr . "'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["DiscountID"]) . "</span><br>Erbjudandenumret har ändrats.<br></p>";
  }	} else {
    echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
 }}


// Function to edit member offer (medlemserbjudanden) information in the database
function editMemberOfferAll($MemberID, $DiscountID){
  // Connect to the database using the function connectPDO
  $pdo = connectPDO();
  
  // retrieve the MemberID from the URL query string and sanitize it
  $memberofferPageNr = htmlspecialchars($_GET["memberofferid"]);
  
  // Get all the arguments passed to the function
  $args = func_get_args();
  
  // Trim each value in the arguments array
  $args = array_map(function ($value) {
    return trim($value);
  }, $args);
  
  // Check if any of the arguments is empty
  foreach ($args as $value) {
    if(empty($value)){
  // Check if any of the arguments is empty
      return "All fields must be filled in";
    }
    // Check if any of the arguments contains special characters
    if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
      // Return error message if any of the arguments contains special characters
      return "Special characters are not allowed";
    }
  }

  // Check if MemberID is a number
  if (!is_numeric($MemberID)){
    // Return error message if MemberID is not a number
    return "Member ID is not a number";
  }
  // Check if DiscountID is a number
  if (!is_numeric($DiscountID)){
    // Return error message if DiscountID is not a number
    return "Discount ID is not a number";
  }   

  // Prepare and execute an SQL statement to update the member offer information in the database
  $stmt = $pdo->prepare("UPDATE medlemserbjudanden SET MemberID=?, DiscountID =? WHERE OfferID = ?");
  $stmt->execute([$MemberID, $DiscountID, $memberofferPageNr]);
  
  // Check if the update was successful
  if ($stmt->rowCount() != 1) {
    // Return error message if the update was not successful
    return "An error occurred. Please try again";
  } else {
    // Return success message if the update was successful
    return "success";
  }
}


// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditMemberOfferAll() {
  $memberofferPageNr = htmlspecialchars($_GET["memberofferid"]);
  if (isset($_POST['submitEditMemberOfferAll'])) {
$response = editMemberOfferAll($_POST['MemberID'], $_POST['DiscountID']);}
if (@$response == "success") {
if (isset($_POST['submitEditMemberOfferAll'])) { 
echo "<script>alert('All erbjudandedata har ändrats!" . "')</script>";
echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-memberoffer/?memberofferid=" . $memberofferPageNr . "'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'></span><br>Medlemserbjudandet har ändrats.<br></p>";
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
    adminMemberOfferInfoHead();
  ?>
</div>
</div>
<div class="row">
<div class="col-1 col-s-1"></div>
<div class="col-5 col-s-5">
<div class="products">

<!-- creates current memberoffer info page -->
<?php adminMemberOfferInfoOld(); ?>
</div></div>


<div class="col-5 col-s-5">
<div class="productform">
<!-- edit product form -->
<form class="registrationForm" action="#" method="post" autocomplete="on">
<div class="col-12 col-s-12">
<h2 class='h2text'>Ändra medlemserbjudande</h2>
<p class="topText">
  <!--Ändra medlemserbjudandeinformation<br><br>-->
</p></div>
<div class="row"></div><div class="row">
  <div class="registrationField">
    <label>Medlemsnmmmer</label>
    <div class="formInputButtonRow"><input class="registrationInput" type="text" name="MemberID" value="<?php echo htmlspecialchars(@$_POST['MemberID']); ?>" >
    <button class="registrationSubmitMany" type="submit" name="submitEditMemberOfferMemberID">Ändra</button></div><?php responseEditMemberOfferMemberID(); ?>
  </div>
  <div class="registrationField">
    <label>Erbjudandenummer</label>
    <div class="formInputButtonRow"><input class="registrationInput" type="text" name="DiscountID" value="<?php echo htmlspecialchars(@$_POST['DiscountID']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditMemberOfferDiscountID">Ändra</button></div><?php responseEditMemberOfferDiscountID(); ?></div>
<div class="rowThings">
<div class="formInputButton"><button class="registrationSubmit" type="submit" name="submitEditMemberOfferAll">Ändra allt</button></div><?php responseEditMemberOfferAll(); ?>	</div></div></div></form></div>
</div></div>
		
</main>
		<?php get_footer();?>