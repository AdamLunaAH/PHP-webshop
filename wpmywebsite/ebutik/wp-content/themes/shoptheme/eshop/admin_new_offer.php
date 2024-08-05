<?php 
/* Template Name: Admin New Offer page */
	require "eshopfunctions.php";
	if (!isset($_SESSION['admin']) ) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();} 

    		
	/* registration function */
	function newOffer($ProductID, $ErbjudPris, $Starttid, $Sluttid){
    $pdo = connectPDO();
    setlocale(LC_ALL, 'se');
    date_default_timezone_set('Europe/Stockholm');
    $datetime = date('y-m-d');
    $args = func_get_args();
    $args = array_map(function ($value) {
        return trim($value);
    }, $args);
    foreach ($args as $value) {
        if(empty($value)){
            return "Alla fälten måste fyllas i";}}
    foreach ($args as $value) {
        if (preg_match("([[[^<|£$^*()}{#~?><>;|=_+-¬]>])", $value)) {
            return "Specialtecken får inte användas";}}
    if (is_numeric($ProductID) == false){
      return "ProductID är inte ett nummer";}
    if ($Starttid > $datetime){
      return "Ogiltig Starttid";}
    if ($Sluttid <= $Starttid){
      return "Ogiltig Sluttid";}
    if (is_numeric($ErbjudPris) == false){
      return "Pris är inte ett nummer";}
			
        $stmt = $pdo->prepare("INSERT INTO erbjudanden(ProductID, ErbjudPris, Starttid, Sluttid) VALUES(:ProductID, :ErbjudPris, :Starttid, :Sluttid)");
        $Starttid = $Starttid." 00:00:00";
        $Sluttid = $Sluttid." 23:59:59";
        $stmt->bindValue(':ProductID', $ProductID);
        $stmt->bindValue(':ErbjudPris', $ErbjudPris);
        $stmt->bindValue(':Starttid', $Starttid);
        $stmt->bindValue(':Sluttid', $Sluttid);
        $stmt->execute();
        return "success";
}

// "connects" the input field data to the function, shows successful change message or if it is unsuccessful it shows an error message with what the fault is, 
	function responseHTML() {
	if (isset($_POST['submit'])) {
  $response = newOffer($_POST['ProductID'], $_POST['ErbjudPris'], $_POST['Starttid'], $_POST['Sluttid'] );}
	if (@$response == "success") {
		if (isset($_POST['submit'])) { 
			echo "<p class='success registrationSuccess'><span class='registrationSuccessHead'>Erbjudandet är skapat</span><br><br></p>";
			}	} else {
				echo "<p class='registrationError'>" . htmlspecialchars(@$response) . "</p>";
				 }} ?>
<?php get_header();?>


<main>
<div class="col-12 col-s-12">
	<!-- new offer creation form -->
	<form class="registrationForm" action="#" method="post" autocomplete="on">
		<div class="col-12 col-s-12">
		<h1>Nytt erbjudande</h1>
		<p class="topText">
			Fyll i formuläret för att skapa ett nytt erbjudande.<br>
			Alla fälten måste fyllas i.<br>

	</p></div>
<div class="row"></div><div class="row"><div class="col-3 cols-s-3"></div><div class="col-6 col-s-6">
			<div class="registrationField">
				<label>ProductID *</label><input class="registrationInput" type="text" name="ProductID" value="<?php echo htmlspecialchars(@$_POST['ProductID']); ?>" ></div>
			<div class="registrationField">
				<label>Erbjudandenpris *</label>
				<input class="registrationInput" type="text" name="ErbjudPris" value="<?php echo htmlspecialchars(@$_POST['ErbjudPris']); ?>" ></div>
			<div class="registrationField">
				<label>Starttid *</label>
				<input class="registrationInput" type="date" name="Starttid" value="<?php echo htmlspecialchars(@$_POST['Starttid']); ?>" ></div>
			<div class="registrationField">
				<label>Sluttid *</label>
				<input class="registrationInput" type="date" name="Sluttid" value="<?php echo htmlspecialchars(@$_POST['Sluttid']); ?>" ></div>

		<div class="rowThings">
		<button class="registrationSubmit" type="submit" name="submit">Skapa erbjudande</button><?php responseHTML(); ?>	</div></div></div></form></div>
		</main>
		<?php get_footer();?>
