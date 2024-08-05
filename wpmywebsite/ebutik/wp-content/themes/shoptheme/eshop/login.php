<?php 
/* Template Name: Login page */
	require "eshopfunctions.php";
	
	if (isset($_SESSION['user'])) {
		header("location: /wpmywebsite/ebutik/medlemskonto/");
		exit();} 
	if (isset($_POST['submit'])) {
		$response = loginUser($_POST['Epost'], $_POST['Password']); }?>
		
<?php get_header();?>
<!-- login page -->
<main>
<div class="col-12 col-s-12">
	<form class="registrationForm account-form" action="#" method="post" autocomplete="off">
		<div class="col-12 col-s-12">
		<h1>Logga in</h1>
		<p class="topText">Fyll i formuläret för att logga in.</p>
		</div>
		<div class="row"></div>
		<div class="row">
		<div class="col-4 col-s-4"></div>
		<div class="col-4 col-s-4">
		<div class="registrationField">
				<label>E-post</label>
				<input class="registrationInput" type="text" name="Epost" value="<?php echo htmlspecialchars(@$_POST['epost']); ?>"></div>
			<div class="registrationField">
			<label>Lösenord</label>
			<div class="passwordRow">
				<input class="registrationInput" type="password" id="psw" name="Password" value="">
				<i class="pswToggle showPass fa-solid fa-eye" onclick="pswShow(this)">click here</i></div>
			</div>
		<button class="registrationSubmit" type="submit" name="submit">Logga in</button>
		<p class="topText">
			Har du inget konto?
			<a class="topText" href="/wpmywebsite/ebutik/skapa-konto/">Skapa ett här.</a>
		</p>
		<p class="topText">
			<a class="topText" href="/wpmywebsite/ebutik/forgot-password/">Glömt lösenord?</a>
		</p>
		<p class="registrationError"><?php echo htmlspecialchars(@$response); ?></p>
	</div>
		</div>
	</form>
</div>
</main>
<?php get_footer(); ?>