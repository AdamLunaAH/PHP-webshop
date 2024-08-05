<?php 
/* Template Name: Forgot password page */
	require "eshopfunctions.php";
	//Password reset function not functionally usable
	if (isset($_POST['submit'])) {$response = passwordReset($_POST['epost']);}
	if (isset($_SESSION['user'])) {header("location: /wpmywebsite/ebutik/medlemskonto/");exit();} ?>
<?php get_header();?>
<main>
	<div class="row">
	<div class="col-4 col-s-4"></div>
<div class="col-4 col-s-4">
	<form class="forgotForm" action="" method="post" autocomplete="off">
		<h1>Glömt Lösenord</h1>
		<h4>Fyll i din E-post adress så att vi kan skicka dig ett nytt lösenord.</h4>
		<div><label>E-post</label>
			<input class="registrationInput" type="text" name="epost" value="<?php echo htmlspecialchars(@$_POST['epost']); ?>">
		</div>
		<button class="registrationSubmit" type="submit" name="submit">Skicka</button>
		<p>
			<a href="/wpmywebsite/ebutik/logga-in/">Tillbaka logga in sidan.</a>
		</p>
		<?php
			if (@$response == "success") { ?>
					<p class="success">Please go to your email account and use your new password.</p>
				<?php } else { ?>
					<p class="error"><?php echo htmlspecialchars(@$response); ?></p>
				<?php	}	?>
	</form>
</div></div></main>
<?php get_footer();?>
