<?php 
/* Template Name: Admin Edit Product Info */
	require "eshopfunctions.php";

	if (!isset($_SESSION['admin']) ) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();}
		
?>
<?php

function adminProductInfoHead() {
	$pdo = connectPDO();
	$proPageNr = htmlspecialchars($_GET["produktnr"]);
	$imagesLink = get_bloginfo('template_directory') . "/eshop/img/produkter/";
	$proInfo = "SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning,
	produkter.Pris, produkter.Bild, kategorier.Kategorinamn FROM produkter
	INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID WHERE produkter.ProductID = :id";
	$stmt = $pdo->prepare($proInfo);
	$stmt->execute(['id' => $proPageNr]);
	if ($stmt->rowCount() > 0) {
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	echo "<h1>". $row["Produktnamn"] . "</h1>" . "
	<img class='productImgEdit' src='" . $imagesLink . $row["Bild"] . "' width='200' height='200' alt='" . $row["Produktnamn"] . "'><br>";
	} else {
	echo "0 results";
	}
	$pdo = null;
	}

// current product info
	function adminProductInfoOld() {
    $pdo = connectPDO();
    $proPageNr = htmlspecialchars($_GET["produktnr"]);
    $proInfo = "SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning,
                produkter.Pris, produkter.Bild, kategorier.CategoryID FROM produkter
                INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID WHERE produkter.ProductID = :proPageNr";
    $stmt = $pdo->prepare($proInfo);
    $stmt->bindParam(':proPageNr', $proPageNr, PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<h2 class='h2text'>Nuvarande data</h2><div class='col-6 col-s-6'><ul class='proMainList'>
              <li>Produktnummer</li><li class='proPageInfo'>" . $row["ProductID"] . "</li>
              <li>Produktnamn</li><li class='proPageInfo'>" . $row["Produktnamn"] . "</li>
              <li>Pris</li><li class='proPageInfo'>" . $row["Pris"] . " kr</li>
              <li>Produktbeskrivning</li><li class='proPageInfo'>" . $row["Produktbeskrivning"] . "</li>
              <li>Kategori</li><li class='proPageInfo'>" . $row["CategoryID"] . "</li>
              <li>Bild</li><li class='proPageInfo'>" . $row["Bild"] . "</li>
              </ul></div>";
    } else {
        echo "0 results";
    }
    $pdo = null;
}
				

		// Function to edit product name (Produktnamn) information in the database
function editProductName($Produktnamn) {
  // Connect to the database using the function connectPDO
  $pdo = connectPDO();

  // retrieve the product number from the URL query string and sanitize it
  $proPageNr = htmlspecialchars($_GET["produktnr"]);

  // get the arguments passed to the function and trim them
  $args = func_get_args();
  $args = array_map(function ($value) {
    return trim($value);
  }, $args);

  // check if the product name already exists in the database
  $stmt = $pdo->prepare("SELECT Produktnamn FROM produkter WHERE Produktnamn = :Produktnamn");
  $stmt->bindParam(":Produktnamn", $Produktnamn);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($result != NULL) {
    return "Produktnamnet används redan";
  }

  // check if any of the arguments are empty
  foreach ($args as $value) {
    if (empty($value)) {
      return "Produktnamnet måste fyllas i!";
    }
  }

  // check if any of the arguments contain special characters
  foreach ($args as $value) {
    if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
			// Return error message if any of the arguments contains special characters
      return "Specialtecken får inte användas";
    }
  }

  // check if the product name is too long
  if (strlen($Produktnamn) > 40) {
		// Return error message if Produktnamn is to long
    return "Produktnamnet är för långt (max 40 tecken)";
  }

  // Prepare and execute an SQL statement to update the product name (Produktnamn) information in the database
  $stmt = $pdo->prepare("UPDATE produkter SET Produktnamn = :Produktnamn WHERE ProductID = :proPageNr");
  $stmt->bindParam(":Produktnamn", $Produktnamn, PDO::PARAM_STR);
  $stmt->bindParam(":proPageNr", $proPageNr, PDO::PARAM_INT);
  $stmt->execute();

  // Check if the update was successful
  if ($stmt->rowCount() != 1) {
		// Return error message if the update was not successful
    return "Ett fel uppstod. Var god försök igen";
  } else {
		 // Return success message if the update was successful
    return "success";
  }
}
	
	
	// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditProductName() {
	$proPageNr = htmlspecialchars($_GET["produktnr"]);
	if (isset($_POST['submitEditProductName'])) {
	$response = editProductName($_POST['Produktnamn'] );}
	if (@$response == "success") {
	if (isset($_POST['submitEditProductName'])) {
	echo "<script>alert('Produktnamnet har ändrats till: " . htmlspecialchars($_POST['Produktnamn']) . "')</script>";
	echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-product/?produktnr=" . $proPageNr . "'>";
	echo "<p class='success registrationSuccess'>";
	echo "<span class='registrationSuccessHead>" . htmlspecialchars($_POST["Produktnamn"]) . "</span>";
	echo "<br>Produktnamnet har ändrats.<br></p>";
			}	} else {
			echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>"; }}



	// This function is used to edit the description of a product in the database using PDO
function editProductDesc($Produktbeskrivning){
	// Get the product number from the GET parameter
	$proPageNr = htmlspecialchars($_GET["produktnr"]);
	
	// Convert all arguments to trimmed values and store in an array
	$args = func_get_args();
	$args = array_map(function ($value) {
		return trim($value);
	}, $args);
	
	// Check if any of the arguments are empty and return error message if true
	foreach ($args as $value) {
		if(empty($value)){
			return "Produktbeskrivningen måste fyllas i!";
		}
	}
	
	// Check if any of the arguments contain special characters and return error message if true
	foreach ($args as $value) {
		if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
			return "Specialtecken får inte användas";
		}
	}
	
	// Check if the product description is too long and return error message if true
	if (strlen($Produktbeskrivning) > 400) {
		return "Produktbeskrivningen är för lång (max 400 tecken)";
	}
	
	// Connect to the database using the function connectPDO
	$pdo = connectPDO();
	
	// Prepare the SQL statement to update the product description in the database
	$stmt = $pdo->prepare("UPDATE produkter SET Produktbeskrivning = :Produktbeskrivning WHERE ProductID = :proPageNr");
	$stmt->bindParam(":Produktbeskrivning", $Produktbeskrivning, PDO::PARAM_STR);
	$stmt->bindParam(":proPageNr", $proPageNr, PDO::PARAM_INT);
	$stmt->execute();

	// Check if the update was successful and return appropriate message
	if ($stmt->rowCount() != 1) {
		return "Ett fel uppstod. Var god försök igen";
	} else {
		return "success";
	}
}

// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
		function responseEditProductDesc() {
			$proPageNr = htmlspecialchars($_GET["produktnr"]);
			if (isset($_POST['submitEditProductDesc'])) {
			$response = editProductDesc($_POST['Produktbeskrivning']);
			}
			
			if (@$response == "success") {
			if (isset($_POST['submitEditProductDesc'])) {
			echo "<script>alert('Produktbeskrivningen har ändrats till: " . htmlspecialchars($_POST['Produktbeskrivning']) . "')</script>";
			echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-product/?produktnr=" . $proPageNr . "'>";
			echo "<p class='success registrationSuccess'>";
			echo "<span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Produktbeskrivning"]) . "</span>";
			echo "<br>Produktbeskrivningen har ändrats.<br>";
			echo "</p>";
			}
			} else {
			echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
			}
			}

// Function to edit product category (CategoryID) information in the database
function editProductCategory($CategoryID){
  // Connect to the database using PDO
  $pdo = connectPDO();

  // Get the product ID from the URL and sanitize it
  $proPageNr = htmlspecialchars($_GET["produktnr"]);

  // Get all the arguments passed to the function and trim them
  $args = func_get_args();
  $args = array_map(function ($value) {
    return trim($value);
  }, $args);

  // Check if any of the arguments are empty
  foreach ($args as $value) {
    if(empty($value)){
      return "Kategorin måste fyllas i!";
    }
  }

  // Check if any of the arguments contain special characters
  foreach ($args as $value) {
    if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
      return "Specialtecken får inte användas";
    }
  }

  // Check if the CategoryID argument is a number
  if (is_numeric($CategoryID) == false){
    return "CategoryID är inte ett nummer";
  }

  // Prepare and execute an update statement to change the CategoryID of a product
  $stmt = $pdo->prepare("UPDATE produkter SET CategoryID = :CategoryID WHERE ProductID = :proPageNr");
  $stmt->bindParam(':CategoryID', $CategoryID, PDO::PARAM_INT);
  $stmt->bindParam(':proPageNr', $proPageNr, PDO::PARAM_INT);
  $stmt->execute();

  // Check if the update was successful
  if ($stmt->rowCount() != 1) {
    return "Ett fel uppstod. Var god försök igen";
  } else {
    return "success";
  }
}


// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditProductCategory() {
	$proPageNr = htmlspecialchars($_GET["produktnr"]);
if (isset($_POST['submitEditProductCategory'])) {
$response = editProductCategory($_POST['CategoryID']);}
if (@$response == "success") {
	if (isset($_POST['submitEditProductCategory'])) { 
		echo "<script>alert('CategoryID har ändrats till: " . htmlspecialchars($_POST['CategoryID']) . "')</script>";
				echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-product/?produktnr=" . $proPageNr . "'>";
			
		echo "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["CategoryID"]) . "</span>
		<br>Produkten har ändrats.<br>
				</p>";
		 }	} else {
			echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>"; }}


// Function to edit the price of a product in the database
function editProductPrice($Pris) {
	 // Connect to the database using the function connectPDO
	$pdo = connectPDO();

	// Get the product number from the GET parameters and sanitize it
	$proPageNr = htmlspecialchars($_GET["produktnr"]);

	// Get the arguments passed to the function and trim whitespaces
	$args = func_get_args();
	$args = array_map(function ($value) {
		return trim($value);
	}, $args);

	// Check if any of the arguments are empty and return an error message if so
	foreach ($args as $value) {
		if(empty($value)){
			return "Pris måste fyllas i!";
		}
	}

	// Check if any of the arguments contain special characters and return an error message if so
	foreach ($args as $value) {
		if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
			return "Specialtecken får inte användas";
		}
	}

	// Check if the price is numeric and return an error message if not
	if (is_numeric($Pris) == false){
		return "Pris är inte ett nummer";
	}

	// Prepare the SQL statement to update the product price in the database
	$stmt = $pdo->prepare("UPDATE produkter SET Pris = :Pris WHERE ProductID = :ProductID");
	$stmt->bindParam(':Pris', $Pris, PDO::PARAM_INT);
	$stmt->bindParam(':ProductID', $proPageNr, PDO::PARAM_INT);
	$stmt->execute();

	// Check if the update was successful and return a success or error message
	if ($stmt->rowCount() != 1) {
		return "Ett fel uppstod. Var god försök igen";
	} else {
		return "success";
	}
}
	// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
		function responseEditProductPrice() {
			$proPageNr = htmlspecialchars($_GET["produktnr"]);
		if (isset($_POST['submitEditProductPrice'])) {
		$response = editProductPrice($_POST['Pris']);}
		if (@$response == "success") {
			if (isset($_POST['submitEditProductPrice'])) { 
				echo "<script>alert('Priset har ändrats till: " . htmlspecialchars($_POST['Pris']) . "')</script>";
				echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-product/?produktnr=" . $proPageNr . "'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Pris"]) . "</span>
				<br>Produkten har ändrats.<br>
						</p>";
				}	} else {
					echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>"; }}

// Function to edit the image of a product in the database
function editProductImg($Bild) {
  
 // Connect to the database using the function connectPDO
  $pdo = connectPDO();
  
  // Get the product number from the GET parameters and sanitize it
  $proPageNr = htmlspecialchars($_GET["produktnr"]);
  
  // Get the arguments passed to the function and trim them
  $args = func_get_args();
  $args = array_map(function ($value) {
    return trim($value);
  }, $args);
  
  // Check if any of the arguments is empty
  foreach ($args as $value) {
    if(empty($value)) {
      // Return an error message if one of the arguments is empty
      return "Bild måste fyllas i!";
    }
  }
  
  // Check if any of the arguments contains special characters
  foreach ($args as $value) {
    if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
      // Return an error message if one of the arguments contains special characters
      return "Specialtecken får inte användas";
    }
  }
  
  // Check if the length of the image URL is too long
  if (strlen($Bild) > 40) {
    // Return an error message if the length of the image URL is too long
    return "Bild-URL:en är för lång (max 40 tecken)";
  }
  
  // Prepare a SQL statement to update the image of the product in the database
  $stmt = $pdo->prepare("UPDATE produkter SET Bild = :Bild WHERE ProductID = :ProductID");
  $stmt->bindParam(":Bild", $Bild, PDO::PARAM_STR);
  $stmt->bindParam(":ProductID", $proPageNr, PDO::PARAM_INT);
  
  // Execute the statement
  $stmt->execute();
  
  // Check if the statement was successful
  if ($stmt->rowCount() != 1) {
    // Return an error message if the statement was not successful
    return "Ett fel uppstod. Var god försök igen";
  } else {
    // Return "success" if the statement was successful
    return "success";
  }
}


// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
function responseEditProductImg() {
	$proPageNr = htmlspecialchars($_GET["produktnr"]);
if (isset($_POST['submitEditProductImg'])) {
$response = editProductImg($_POST['Bild']);}
if (@$response == "success") {
	if (isset($_POST['submitEditProductImg'])) { 
		echo "<script>alert('Bilden har ändrats till: " . htmlspecialchars($_POST['Bild']) . "')</script>";
				echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-product/?produktnr=" . $proPageNr . "'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Bild"]) . "</span>
		<br>Produkten har ändrats.<br>
				</p>";
		}	} else {
			echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>"; }}


/* edit product data function */
function editProductAll($Produktnamn, $Produktbeskrivning, $CategoryID, $Pris, $Bild){
	 // Connect to the database using the function connectPDO
	$pdo = connectPDO();
// retrieve the ID from the URL query string and sanitize it
	$proPageNr = htmlspecialchars($_GET["produktnr"]);
  // Get the arguments passed to the function and trim them
	$args = func_get_args();
	$args = array_map(function ($value) {
			return trim($value);
	}, $args);
	 // check if the name already exists in the database
	 $stmt = $pdo->prepare("SELECT Produktnamn FROM produkter WHERE Produktnamn = :Produktnamn");
	 $stmt->bindParam(":Produktnamn", $Produktnamn);
	 $stmt->execute();
	 $result = $stmt->fetch(PDO::FETCH_ASSOC);
	 if ($result != NULL) {
		 return "Produktnamnet används redan"; }
	  // Check if any of the arguments is empty
	foreach ($args as $value) {
			if(empty($value)){
					return "Alla fälten måste fyllas i";	}	}
		    // Check if any of the arguments contains special characters	
	foreach ($args as $value) {
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
					return "Specialtecken får inte användas";	}	}
	  // Check if the CategoryID argument is a number
	if (is_numeric($CategoryID) == false){
			return "CategoryID är inte ett nummer";	}
	  // check if the product name is too long
	if (strlen($Produktnamn) > 40) {
			return "Produktnamnet är för långt (max 40 tecken)";	}
		// Check if the product description is too long
	if (strlen($Produktbeskrivning) > 400) {
			return "Produktbeskrivningen är för lång (max 400 tecken)";	}
		// Check if the price is numeric
	if (is_numeric($Pris) == false){
		return "Pris är inte ett nummer";	}
	  // Check if the length of the image URL is too long
	if (strlen($Bild) > 40) {
		 // Return an error message if the length of the image URL is too long
		return "Bild-URL:en är för lång (max 40 tecken)";	}
	// Prepare an update statement to edit all the product information in the database
	$stmt = $pdo->prepare("UPDATE produkter SET Produktnamn=?, Produktbeskrivning=?, CategoryID=?, Pris=?, Bild=? WHERE ProductID=?");
	// Bind the values to the statement
	$stmt->bindParam(1, $Produktnamn, PDO::PARAM_STR);
	$stmt->bindParam(2, $Produktbeskrivning, PDO::PARAM_STR);
	$stmt->bindParam(3, $CategoryID, PDO::PARAM_INT);
	$stmt->bindParam(4, $Pris, PDO::PARAM_INT);
	$stmt->bindParam(5, $Bild, PDO::PARAM_STR);
	$stmt->bindParam(6, $proPageNr, PDO::PARAM_INT);
	// Execute the statement
	$stmt->execute();
	// Check if the statement executed successfully, if not, return an error message
	if ($stmt->rowCount() != 1) {
		return "Ett fel uppstod. Var god försök igen";
	} else {
		return "success";}	}



//This function is for editing all the editable data for the item
function responseEditProductAll() {
  //Getting the database table row ID from the URL, and sanitizing the input
  $proPageNr = htmlspecialchars($_GET["produktnr"]);
  //Checking if the form has been submitted
  if (isset($_POST['submitEditProductAll'])) {
    //Call the function with the values from the form
    $response = editProductAll($_POST['Produktnamn'], $_POST['Produktbeskrivning'], $_POST['CategoryID'], $_POST['Pris'], $_POST['Bild']);
  }
  //Checking if the function call returned "success"
  if (@$response == "success") {
    //If the form was submitted and the call was successful
    if (isset($_POST['submitEditProductAll'])) { 
      //Displaying an alert message, and then redirecting/refresh to the edit page with the updated data
      echo "<script>alert('Alla produktinformation har ändrats: " . htmlspecialchars($_POST['Produktnamn']) . "')</script>";
      echo "<meta http-equiv='refresh' content='0;url=/wpmywebsite/ebutik/administration/admin-edit-product/?produktnr=" . $proPageNr . "'>" . "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Produktnamn"]) . "</span>
      <br>Produkten har ändrats.<br>
      </p>";
    }	
  } else {
    //If the call returned an error message
    echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
  }
}


?>


<?php get_header();?>
<main>

	<div class="row">
    <div class="col-4 col-s-4"></div>
    <div class="col-4 col-s-4">
      <?php 
        adminProductInfoHead();
      ?>
    </div>
  </div>
	<div class="row">
		<div class="col-1 col-s-1"></div>
	<div class="col-5 col-s-5">
	<div class="products">
		
		<!-- shows current product info  -->
    <?php adminProductInfoOld(); ?>
  </div></div>


	<div class="col-5 col-s-5">
	<div class="productform">
	<!-- edit product form -->
	<form class="registrationForm" action="#" method="post" autocomplete="on">
		<div class="col-12 col-s-12">
		<h2 class='h2text'>Ändra produkt</h2>
		<p class="topText">
			Ändra produktinformation.<br><br>
	</p></div>
<div class="row"></div><div class="row">
			<div class="registrationField">
				<label>Produktnamn</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="text" name="Produktnamn" value="<?php echo htmlspecialchars(@$_POST['Produktnamn']); ?>" >
				<button class="registrationSubmitMany" type="submit" name="submitEditProductName">Ändra</button></div><?php responseEditProductName(); ?>
			</div>
			<div class="registrationField">
				<label>Produktbeskrivning</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="text" name="Produktbeskrivning" value="<?php echo htmlspecialchars(@$_POST['Produktbeskrivning']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditProductDesc">Ändra</button></div><?php responseEditProductDesc(); ?></div>
			<div class="registrationField">
				<label>CategoryID</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="text" name="CategoryID" value="<?php echo htmlspecialchars(@$_POST['CategoryID']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditProductCategory">Ändra</button></div><?php responseEditProductCategory(); ?></div>
			<div class="registrationField">
				<label>Pris</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="text" name="Pris" value="<?php echo htmlspecialchars(@$_POST['Pris']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditProductPrice">Ändra</button></div><?php responseEditProductPrice(); ?></div>
			<div class="registrationField">
				<label>Bild</label>
				<div class="formInputButtonRow"><input class="registrationInput" type="text" name="Bild" value="<?php echo htmlspecialchars(@$_POST['Bild']); ?>" ><button class="registrationSubmitMany" type="submit" name="submitEditProductImg">Ändra</button></div><?php responseEditProductImg(); ?></div>
		<div class="rowThings">
		<div class="formInputButton"><button class="registrationSubmit" type="submit" name="submitEditProductAll">Ändra allt</button></div><?php responseEditProductAll(); ?>	</div></div></div></form>
	</div>
		</div></div>
		
</main>
		<?php get_footer();?>