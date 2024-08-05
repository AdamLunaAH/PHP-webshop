<?php 
/* Template Name: Account page */
	require "eshopfunctions.php";
	if (!isset($_SESSION['user']) /*|| ( $_SESSION['userid'])*/) {
		header("location: /wpmywebsite/ebutik/logga-in/");
		exit();}
	if (isset($_GET['logout'])) {logoutUser();}
	if (isset($_GET['confirm-account-deletion'])) {deleteAccount();}
	//Member name on account page
	function username(){
			$pdo = connectPDO();
			$stmt = $pdo->prepare("SELECT Fornamn FROM medlem WHERE Epost = :user");
			$stmt->bindParam(':user', $_SESSION['user']);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			$firstName = $result["Fornamn"];
			echo htmlspecialchars($firstName);
		} 


	// Orders made by member

	function userInfo() {
			$pdo = connectPDO();
			$useridNr = htmlspecialchars($_SESSION["userid"]);
			$stmt = $pdo->prepare("SELECT MemberID, Fornamn, Efternamn, Epost, Mobilnr, Gatuadress, Postnr, Ort, Skapad FROM Medlem WHERE MemberID = :userid");
			$stmt->bindParam(':userid', $useridNr);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if (!empty($result)) {
				echo "<h2 class='h2text'>Kontoinformation</h2><div class='col-6 col-s-6'><ul class='proMainList'>";
				foreach ($result as $row) {
					echo 
					"<li>Medlemsnummer</li><li class='proPageInfo'>" . htmlspecialchars($row["MemberID"]) . "</li>
					<li>Förnamn</li><li class='proPageInfo'>" . htmlspecialchars($row["Fornamn"]) . "</li>
					<li>Efternamn</li><li class='proPageInfo'>" . htmlspecialchars($row["Efternamn"]) . "</li>
					<li>E-post</li><li class='proPageInfo'>" . htmlspecialchars($row["Epost"]) . "</li>
					<li>Mobilnummer</li><li class='proPageInfo'>" . htmlspecialchars($row["Mobilnr"]) . "</li>
					<li>Gatuadress</li><li class='proPageInfo'>" . htmlspecialchars($row["Gatuadress"]) . "</li>
					<li>Postnummer</li><li class='proPageInfo'>" . htmlspecialchars($row["Postnr"]) . "</li>
					<li>Ort</li><li class='proPageInfo'>" . htmlspecialchars($row["Ort"]) . "</li>
					<li>Konton skapads</li><li class='proPageInfo'>" . htmlspecialchars($row["Skapad"]) . "</li>";
				}
				echo "</ul></div>";
			} else {
				echo "0 results";
			}
		}


		function memberOrders(){
			$pdo = connectPDO();
			$userid=$_SESSION['userid'];
			$memberOrderID = $userid;
			$orderInfo = "SELECT bestallning.MemberID, bestallning.OrderID, bestallning.Bestallningsdatum,bestallningsdetaljer.ProductID, bestallningsdetaljer.Antal, produkter.Produktnamn, produkter.Pris
			,SUM(produkter.Pris * bestallningsdetaljer.Antal) AS totalPris
			,SUM(bestallningsdetaljer.Antal) AS totalProdukter
			FROM bestallning
			INNER JOIN bestallningsdetaljer ON bestallningsdetaljer.OrderID = bestallning.OrderID
			INNER JOIN produkter ON produkter.ProductID = bestallningsdetaljer.ProductID
			WHERE MemberID = :memberOrderID
			GROUP BY bestallning.OrderID
			ORDER BY bestallning.Bestallningsdatum";
			$stmt = $pdo->prepare($orderInfo);
			$stmt->bindParam(':memberOrderID', $memberOrderID, PDO::PARAM_INT);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
					echo "<div class='col-5 col-s-5 orderMainInfo'>";
					// output data of each row
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							echo "<div class='orderInfo'>" . "<p class='orderHead'>" . "Ordernummer: " . htmlspecialchars($row['OrderID']) . "<br>" ."Beställningsdatum: " . htmlspecialchars($row["Bestallningsdatum"]). "<br>".  "Totalpris: " . htmlspecialchars($row['totalPris']). "<br>" . "Antal produkter: " . htmlspecialchars($row['totalProdukter']) . "<br>";
							// Order product information
							$orderInfo2 = "SELECT bestallning.MemberID, bestallning.OrderID, bestallning.Bestallningsdatum,
							bestallningsdetaljer.ProductID, bestallningsdetaljer.Antal, produkter.Produktnamn, produkter.Pris
							FROM bestallning
							INNER JOIN bestallningsdetaljer ON bestallningsdetaljer.OrderID = bestallning.OrderID
							INNER JOIN produkter ON produkter.ProductID = bestallningsdetaljer.ProductID
							WHERE MemberID = :memberOrderID
							GROUP BY bestallningsdetaljer.ProductID";
							$stmt2 = $pdo->prepare($orderInfo2);
							$stmt2->bindParam(':memberOrderID', $memberOrderID, PDO::PARAM_INT);
							$stmt2->execute();
							if ($stmt2->rowCount() > 0) {
									echo "<div class='orderMainInfo2'>";
									// output data of each row
									while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
											echo "<div class='orderProductInfo'><ul class='orderProductList'><li>Produktnamn: " . htmlspecialchars($row2["Produktnamn"]) . "</li><li>" . "Produktnummer: " . htmlspecialchars($row2["ProductID"]). "</li><li>" . "Pris: " . htmlspecialchars($row2["Pris"]) . "</li><li>" . "Antal: " . htmlspecialchars($row2["Antal"]) . "</li><li>". "<a class='orderProductLink' href='/wpmywebsite/ebutik/produkt?produktnr=" . htmlspecialchars($row2["ProductID"]) . "'>Länk</a>"."</li></ul></div>";}
									echo "<hr class='orderDivider'></div>";}}
							echo "</div></div></div>";} else {
					echo "<div class='orderProductInfo'> Du har ej lagt en order ännu.</div>";}
	} ?><?php get_header();?>
<main>
<div class="col-12 col-s-12">
	<div class="headerPage">
		<h2>Välkommen <?php username();	?> </h2></div></div><div class="row"></div>
<div class="row"><div class="col-1 col-s-1"></div>
<div class="col-4 col-s-4">
	<h4>Detta är din kontosida</h4>
<?php userInfo(); ?>
		<a href="?logout">Logga ut</a><br><br>
		<a href="/wpmywebsite/ebutik/self-edit-account">Ändra kontoinformation</a><br><br>
		<?php if (isset($_GET['delete-account'])) { 
					echo "<p class='confirm-deletion'>
						Är du säker på att du vill avsluta kontot permanent?
						<a class='confirm-deletion' href='?confirm-account-deletion'>Avsluta kontot</a></p>";
						 } else { 
							echo "<a href='?delete-account'>Avsluta konto</a>";
							} 
							echo "</div><div class='col-1 col-s-1'></div>";
							?>
	<?php memberOrders(); ?></div></main>		<?php get_footer();?>