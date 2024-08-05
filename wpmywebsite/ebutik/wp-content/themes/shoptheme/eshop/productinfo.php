<?php 
/* Template Name: Product information page */
	require "eshopfunctions.php";
?>






<?php get_header();?>
<main>
<div class="row">
<div class="col-2 col-s-2"></div>
	<div class="products">
		<?php
		/* Product info page */
		function productInfo() {
			$pdo = connectPDO();
			$proPageNr = htmlspecialchars($_GET["produktnr"]);
			$imagesLink = get_bloginfo('template_directory') . "/eshop/img/produkter/";
			$proInfo = "SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning,
			produkter.Pris, produkter.Bild, kategorier.Kategorinamn FROM produkter
			INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID WHERE produkter.ProductID = :productid";
			$proInfoResult = $pdo->prepare($proInfo);
			$proInfoResult->execute(['productid' => $proPageNr]);
			if ($proInfoResult !== false && $proInfoResult->rowCount() > 0) {
			// output data of each row
			while ($row = $proInfoResult->fetch(PDO::FETCH_ASSOC)) {
			echo "<h1>". $row["Produktnamn"] . "</h1>" . "<div class='col-2 col-s-2'></div><div class='col-2 col-s-2'>
			<img class='productImg' src='" . $imagesLink . $row["Bild"] . "' alt='" . $row["Produktnamn"] . "'></div>".
			"<div class='col-6 col-s-6'><ul class='proMainList'>
			<li>Artikelnummer</li><li class='proPageInfo'>" . $row["ProductID"] . "</li>
			<li>Pris</li><li class='proPageInfo'>" . $row["Pris"] . " kr</li>
			<li>Produktbeskrivning</li><li class='proPageInfo'>" . $row["Produktbeskrivning"] . "</li>
			<li>Kategori</li><li class='proPageInfo'>" . $row["Kategorinamn"] . "</li></ul></div>";}
			echo "";
			} else {
			echo "0 results";}
			$pdo = null;}
		?>
		<!-- creates product info page -->
    <?php productInfo(); ?>
  </div></div>
</main>
		<?php get_footer();?>