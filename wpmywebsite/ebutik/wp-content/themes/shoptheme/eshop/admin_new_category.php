<?php 
/* Template Name: Admin New Category page */
	require "eshopfunctions.php";
	if (!isset($_SESSION['admin']) /*|| ( $_SESSION['userid'])*/) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();} 

    		
	/* new category function */
	function newCategory($Kategorinamn) {
		$pdo = connectPDO();
		$args = func_get_args();
		$args = array_map(function ($value) {
			return trim($value);
		}, $args);
		foreach ($args as $value) {
			if (empty($value)) {
				return "All fields must be filled in";
			}
		}
		foreach ($args as $value) {
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
				return "Special characters are not allowed";
			}
		}
		
			$stmt = $pdo->prepare("SELECT Kategorinamn FROM kategorier WHERE Kategorinamn = ?");
			$stmt->execute([$Kategorinamn]);
			$data = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($data != NULL) {
				return "Category name already in use";
			}
			$stmt = $pdo->prepare("INSERT INTO kategorier (Kategorinamn) VALUES (?)");
			$stmt->execute([$Kategorinamn]);
			if ($stmt->rowCount() != 1) {
				return "An error occurred. Please try again";
			} else {
				return "success";
			}
	}


// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
	function responseHTML() {
	if (isset($_POST['submit'])) {
  $response = newCategory($_POST['Kategorinamn']);}
	if (@$response == "success") {
		if (isset($_POST['submit'])) { 
			echo "<p class='success registrationSuccess'>
			<span class='registrationSuccessHead'>"
			. htmlspecialchars($_POST["Kategorinamn"]) . "</span>
			<br>Kategorin är skapad<br></p>";
			}	} else {
				echo "<p class='registrationError'>"
				. htmlspecialchars(@$response) . "</p>";
				}}; ?>
<?php get_header();?>


<main>
<div class="col-12 col-s-12">
	<!-- new category creation form -->
	<form class="registrationForm" action="#" method="post" autocomplete="on">
		<div class="col-12 col-s-12">
		<h1>Ny produkt</h1>
		<p class="topText">
			Fyll i formuläret för att lägga till en ny kategori.<br>
			Alla fälten måste fyllas i.<br>

	</p></div>
<div class="row"></div><div class="row"><div class="col-3 cols-s-3"></div><div class="col-6 col-s-6">
			<div class="registrationField">
				<label>Kategorinamn *</label><input class="registrationInput" type="text" name="Kategorinamn" value="<?php echo htmlspecialchars(@$_POST['Kategorinamn']); ?>" ></div>
			

		<div class="rowThings">
		<button class="registrationSubmit" type="submit" name="submit">Lägg till kategori</button><?php responseHTML(); ?>	</div></div></div></form></div>
		</main>
		<?php get_footer();?>
