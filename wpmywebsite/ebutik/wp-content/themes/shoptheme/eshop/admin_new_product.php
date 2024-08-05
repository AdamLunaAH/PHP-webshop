<?php 
/* Template Name: Admin New Product page */
	require "eshopfunctions.php";
	if (!isset($_SESSION['admin']) /*|| ( $_SESSION['userid'])*/) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();} 

    		
	/* new product function */
	function newProduct($Produktnamn, $Produktbeskrivning, $CategoryID, $Pris, $Bild){
			 // Connect to the database using the function connectPDO
    $pdo = connectPDO();
		  // Get the arguments passed to the function and trim them
    $args = func_get_args();
    $args = array_map(function ($value) {
        return trim($value);
    }, $args);
		 // Check if any of the arguments is empty
    foreach ($args as $value) {
        if(empty($value)){
            return "Alla fälten måste fyllas i";}}
		// Check if any of the arguments contains special characters
    foreach ($args as $value) {
        if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
            return "Specialtecken får inte användas";}}
		// check if the IDe already exists in the database
    $stmt = $pdo->prepare("SELECT Produktnamn FROM produkter WHERE Produktnamn = ?");
    $stmt->execute([$Produktnamn]);
    $result = $stmt->fetch();
    if ($result){
        return "Produktnamnet används redan";}
		// Check if the CategoryID argument is a number
    if (!is_numeric($CategoryID)){
      return "CategoryID är inte ett nummer";}
				  // check if the product name is too long
    if (strlen($Produktnamn) > 40) {
        return "Produktnamnet är för långt (max 40 tecken)";}
						// Check if the product description is too long
    if (strlen($Produktbeskrivning) > 400) {
        return "Produktbeskrivningen är för lång (max 400 tecken)";}
				// Check if the price is numeric 
    if (!is_numeric($Pris)){
      return "Pris är inte ett nummer";}
			// Check if the length of the image URL is too long
    if (strlen($Bild) > 40) {
        return "Bild-URL:en är för lång (max 40 tecken)";}
				// Prepare an statement to add the new data to the database
    $stmt = $pdo->prepare("INSERT INTO produkter(Produktnamn, Produktbeskrivning, CategoryID, Pris, Bild) VALUES(?,?,?,?,?)");
		// Execute the statement
    $result = $stmt->execute([$Produktnamn, $Produktbeskrivning, $CategoryID, $Pris, $Bild]);
			// Check if the statement executed successfully, if not, return an error message
    if (!$result) {
        return "Ett fel uppstod. Var god försök igen";
    } else {
        return "success";}}

	function responseNewProduct() {
		//Checking if the form has been submitted
	if (isset($_POST['submitNewProduct'])) {
	//Call the function with the values from the form
  $response = newProduct($_POST['Produktnamn'], $_POST['Produktbeskrivning'], $_POST['CategoryID'], $_POST['Pris'], $_POST['Bild']  );}
   //Checking if the function call returned "success"
	if (@$response == "success") {
		if (isset($_POST['submitNewProduct'])) { 
			echo "<p class='success registrationSuccess'><span class='registrationSuccessHead'>" . htmlspecialchars($_POST["Produktnamn"]) . "</span><br>Produkten är tillagd.<br></p>";
		}	} else {
			echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
		}} ?>
<?php get_header();?>


<main>
<div class="col-12 col-s-12">
	<!-- new product form -->
	<form class="registrationForm" action="#" method="post" autocomplete="on">
		<div class="col-12 col-s-12">
		<h1>Ny produkt</h1>
		<p class="topText">
			Fyll i formuläret för att lägga till en ny produkt.<br>
			Alla fälten måste fyllas i.<br>
	</p></div>
<div class="row"></div><div class="row"><div class="col-3 cols-s-3"></div><div class="col-6 col-s-6">
			<div class="registrationField">
				<label>Produktnamn *</label><input class="registrationInput" type="text" name="Produktnamn" value="<?php echo htmlspecialchars(@$_POST['Produktnamn']); ?>" ></div>
			<div class="registrationField">
				<label>Produktbeskrivning *</label>
				<input class="registrationInput" type="text" name="Produktbeskrivning" value="<?php echo htmlspecialchars(@$_POST['Produktbeskrivning']); ?>" ></div>
			<div class="registrationField">
				<label>CategoryID *</label>
				<input class="registrationInput" type="text" name="CategoryID" value="<?php echo htmlspecialchars(@$_POST['CategoryID']); ?>" ></div>
			<div class="registrationField">
				<label>Pris *</label>
				<input class="registrationInput" type="text" name="Pris" value="<?php echo htmlspecialchars(@$_POST['Pris']); ?>" ></div>
			<div class="registrationField">
				<label>Bild *</label>
				<input class="registrationInput" type="text" name="Bild" value="<?php echo htmlspecialchars(@$_POST['Bild']); ?>" ></div>
			
		<div class="rowThings">
		<button class="registrationSubmit" type="submit" name="submitNewProduct">Lägg till produkt</button><?php responseNewProduct(); ?>	</div></div></div></form></div>
		</main>
		<?php get_footer();?>
