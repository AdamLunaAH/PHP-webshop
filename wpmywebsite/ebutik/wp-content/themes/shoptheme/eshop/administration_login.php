<?php 
/* Template Name: Administration Login page */

	// admin session check that if there is a valid admin session. If an valid admin session already exists, the user is sent to the administration-page
	require "eshopfunctions.php";
	if (isset($_SESSION['admin'])) {
		header("location: /wpmywebsite/ebutik/administration/");
		exit();}

			// admin login function
			function loginAdmin($username, $password) {
				 // Connect to the database using the function connectPDO
				$pdo = connectPDO();

				// Filters the inputs from harmful code
				$username = htmlspecialchars($username);
				$password = htmlspecialchars($password);

				// trim the inputs
				$username = trim($username);
				$password = trim($password);

				// checks if both input fields are filled in, if not it shows an error message
				if ($username == "" || $password == "") {
						return "Both fields are required";
				}

				// Checks if the inputted username is available in the database
				$sql = "SELECT username, password FROM admin WHERE username = :username";
				$stmt = $pdo->prepare($sql);
				$stmt->execute(['username' => $username]);
				$data = $stmt->fetch(PDO::FETCH_ASSOC);

				// show an error message if the username is not available in the database
				if ($data == NULL) {
						return "Incorrect username or password";}

				// checks if the password is correct for the username
				if (password_verify($password, $data["password"]) == TRUE) {
						//start a session and redirect the user to the administration page.
						session_start();
						session_regenerate_id(true);
						$_SESSION["admin"] = htmlspecialchars($username);
						header("location: /wpmywebsite/ebutik/administration/");
						exit();
				} else {
						return "Incorrect username or password";
				}		}
		
		// starts the loginAdmin function when the submit button is pressed
		if (isset($_POST['submit'])) {
				$response = loginAdmin($_POST['username'], $_POST['password']);
		}
		
		?>
	
	

<?php get_header();?>
<!-- admin login page -->
<main>
<div class="col-12 col-s-12">
	<form class="registrationForm account-form" action="#" method="post" autocomplete="off">
		<div class="col-12 col-s-12">
		<h1>Administration</h1>
		<p class="topText">Fyll i formuläret för att logga in.</p>
		</div>
		<div class="row"></div>
		<div class="row">
		<div class="col-4 col-s-4"></div>
		<div class="col-4 col-s-4">
		<div class="registrationField">
				<label>Användarnamn</label>
				<input class="registrationInput" type="text" name="username" value="<?php echo htmlspecialchars(@$_POST['epost']); ?>"></div>
			<div class="registrationField">
			<label>Lösenord</label>
			<div class="passwordRow">
				<input class="registrationInput" type="password" id="psw" name="password" value="">
				<i class="pswToggle showPass fa-solid fa-eye" onclick="pswShow(this)">click here</i></div>
			</div>
		<button class="registrationSubmit" type="submit" name="submit">Logga in</button>

		<p class="registrationError"><?php echo htmlspecialchars(@$response); ?></p>
	</div>
		</div>
	</form>
</div>
</main>
<?php get_footer(); ?>