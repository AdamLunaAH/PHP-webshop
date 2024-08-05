<?php 
/* Template Name: Admin New Member Offer page */
	require "eshopfunctions.php";
	if (!isset($_SESSION['admin']) /*|| ( $_SESSION['userid'])*/) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();} 

    		
	/* new offer function */
	function newOffer($MemberID, $DiscountID){
		$pdo = connectPDO();
		$args = func_get_args();
		$args = array_map(function ($value) {
			return trim($value);
		}, $args);
		
		foreach ($args as $value) {
			if(empty($value)){
				return "All fields must be filled in";
			}
			if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
				return "Special characters are not allowed";
			}
		}
	
		if (!is_numeric($MemberID)){
			return "MemberID is not a number";
		}
		if (!is_numeric($DiscountID)){
			return "DiscountID is not a number";
		}
	
		$stmt = $pdo->prepare("INSERT INTO medlemserbjudanden(MemberID, DiscountID)  VALUES(?,?)");
		$stmt->execute([$MemberID, $DiscountID]);
		
		if ($stmt->rowCount() != 1) {
			return "An error occurred. Please try again";
		} else {
			return "success";
		}
	}

// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
	function responseHTML() {
	if (isset($_POST['submit'])) {
  $response = newOffer($_POST['MemberID'], $_POST['DiscountID']  );}
	if (@$response == "success") {
		if (isset($_POST['submit'])) { 
			echo "<p class='success registrationSuccess'><span class='registrationSuccessHead'>Medlemserbjudanden skapat</span>
			<br><br>
					</p>";
			}	} else {
				echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
				}}; ?>
<?php get_header();?>


<main>
<div class="col-12 col-s-12">
	<!-- new member offer creation form -->
	<form class="registrationForm" action="#" method="post" autocomplete="on">
		<div class="col-12 col-s-12">
		<h1>Nytt medlemserbjudande</h1>
		<p class="topText">
      Fyll i formuläret för att skapa ett nytt medlemserbjudande.<br>
			Alla fälten måste fyllas i.<br>
	</p></div>
<div class="row"></div><div class="row"><div class="col-3 cols-s-3"></div><div class="col-6 col-s-6">
			<div class="registrationField">
				<label>MemberID *</label><input class="registrationInput" type="text" name="MemberID" value="<?php echo htmlspecialchars(@$_POST['MemberID']); ?>" ></div>
			<div class="registrationField">
				<label>DiscountID *</label>
				<input class="registrationInput" type="text" name="DiscountID" value="<?php echo htmlspecialchars(@$_POST['DiscountID']); ?>" ></div>

		<div class="rowThings">
		<button class="registrationSubmit" type="submit" name="submit">Skapa medlemserbjudande</button><?php responseHTML(); ?>	</div></div></div></form></div>
		</main>
		<?php get_footer();?>
