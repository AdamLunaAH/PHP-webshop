<?php 
/* Template Name: Administration page */
	require "eshopfunctions.php";

		// admin session check that if there is no valid admin session. If no valid admin session already exists, the user is sent to the admin-login-page
	if (!isset($_SESSION['admin']) ) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();}

		//  logout admin function connection
	if (isset($_GET['logout'])) {logoutUser();}

	
	//Admin name on the administration page
	function username() {
		$pdo = connectPDO();
		$stmt = $pdo->prepare("SELECT Fornamn FROM admin WHERE Username = :username");
		$stmt->bindParam(':username', $_SESSION['admin']);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$firstName = $row["Fornamn"];
		echo htmlspecialchars($firstName);
		}
		// get Adminid for usage on the page
		function loggedInUserData() {
			$pdo = connectPDO();
			$stmt = $pdo->prepare("SELECT AdminID FROM admin WHERE Username = :username");
			$stmt->bindParam(':username', $_SESSION['admin']);
			$stmt->execute();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$userid = $row["AdminID"];
			return htmlspecialchars($userid);
			} ?><?php get_header();?>
<main>
<div class="col-12 col-s-12">
	<div class="headerPage">
		<h2>Välkommen <?php username();	?> </h2></div></div><div class="row"></div>
<div class="row"><div class="col-1 col-s-1"></div>
<div class="col-4 col-s-4">
	<h4>Detta är din administrationssida</h4>
	<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla nostrum, aspernatur. Sed harum facere ab nihil recusandae autem quos corporis nobis tempora sapiente cupiditate illo tempore obcaecati error non, eligendi.</p><br>
	<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla nostrum, aspernatur. Sed harum facere ab nihil recusandae autem quos corporis nobis tempora sapiente cupiditate illo tempore obcaecati error non, eligendi.</p><br>
	<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla nostrum, aspernatur. Sed harum facere ab nihil recusandae autem quos corporis nobis tempora sapiente cupiditate illo tempore obcaecati error non, eligendi.</p>
		<a href="?logout">Logga ut</a><br>
	</div>

	<!-- links to the different administration pages and functions -->
	<div class="col-4 col-s-4 menu-text">
		<h2>Administrationsfunktioner</h2>
		<h3>Produkter</h3>
		<a href="/wpmywebsite/ebutik/administration/admin-productlist">Se/ändra</a><br>
		<a href="/wpmywebsite/ebutik/administration/admin-newproduct">Ny produkt</a><br>
		<h3>Kategorier</h3>
		<a href="/wpmywebsite/ebutik/administration/admin-categorylist">Se/ändra</a><br>
		<a href="/wpmywebsite/ebutik/administration/admin-newcategory">Ny kategori</a><br>
		<h3>Erbjudanden</h3>
		<a href="/wpmywebsite/ebutik/administration/admin-offerlist">Se/ändra</a><br>
		<a href="/wpmywebsite/ebutik/administration/admin-newoffer">Nytt erbjudande</a><br>
		<a href="/wpmywebsite/ebutik/administration/admin-memberoffer">Se/ändra medlemserbjudande</a><br>
		<a href="/wpmywebsite/ebutik/administration/admin-newmemberoffer">Nytt medlemserbjudande</a><br>
		<h3>Medlem</h3>
		<a href="/wpmywebsite/ebutik/administration/admin-memberlist">Se</a><br>
		<h3>Beställningar</h3>
		<a href="/wpmywebsite/ebutik/administration/admin-orders">Se</a><br>
		<h3>JSON Resultat</h3>
		<a href="/wpmywebsite/ebutik/administration/admin-json-converter">Se</a><br>
	</div>	

</main>		<?php get_footer();?>