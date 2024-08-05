<?php

// PHP code for AJAX live search function
require "eshopfunctions.php";

// Connect to the database using the function connectPDO
$pdo = connectPDO();
$themeLink = "http://83.255.187.87/wpmywebsite/ebutik/wp-content/themes/shoptheme/eshop/img/produkter/";
// Check if the query parameter has been set in the POST request
if(isset($_POST["queryProductSearch"])){
  // Sanitize and trim the query input
  $searchProductsAdmin = htmlspecialchars($_POST["queryProductSearch"]);
  $searchProductsAdmin = trim($searchProductsAdmin);

  // Prepare a SQL statement to retrieve products and categories that match the query
  $stmt = $pdo->prepare("SELECT * FROM produkter INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID WHERE produkter.Produktnamn LIKE CONCAT('%', :searchProductsAdmin, '%') OR produkter.Produktbeskrivning LIKE CONCAT('%', :searchProductsAdmin, '%') OR produkter.CategoryID LIKE CONCAT('%', :searchProductsAdmin, '%') OR produkter.Pris LIKE CONCAT('%', :searchProductsAdmin, '%') OR produkter.Bild LIKE CONCAT('%', :searchProductsAdmin, '%') OR kategorier.Kategorinamn LIKE CONCAT('%', :searchProductsAdmin, '%')");

  // Bind the search parameter to the prepared statement
  $stmt->bindParam(':searchProductsAdmin', $searchProductsAdmin);

  // Execute the prepared statement and retrieve the results as an array of rows
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // If there are results, display them in a product list page
  if($result !== false && count($result) > 0){
    echo "<div class='productListPage'>";
    foreach($result as $row){
      // Display each product as a grid item with its name, image, description, price, category name, and links to its detail page and edit page
      $descriptionLimit = mb_strimwidth(htmlspecialchars($row["Produktbeskrivning"]), 0, 100, "...");
      echo "<div class='productPageGrid kategori-". htmlspecialchars($row['CategoryID']) ."'>
      <h3 class='productName '>" . htmlspecialchars($row["Produktnamn"]). "</h3><br>" .
      "<img class='productImg' src='" . $themeLink . htmlspecialchars($row["Bild"]) . "' width='300' height='300' alt='" . htmlspecialchars($row["Produktnamn"]) . "'>" .
      "<br>" . htmlspecialchars($row["ProductID"]). "<br>" . /*htmlspecialchars($row["Produktbeskrivning"])*/ $descriptionLimit. "<br>".
      htmlspecialchars($row["Pris"]). "<br>". htmlspecialchars($row["Kategorinamn"]). "<br>
      <a href='/wpmywebsite/ebutik/produkt?produktnr={$row['ProductID']}'>Länk</a>"."<br>
      <a href='/wpmywebsite/ebutik/edit-product?produktnr={$row['ProductID']}'>Ändra</a>"."</div>";
    }
    echo "</div>";
  } else {
    // If there are no results, display a message
    echo "<p>No results found.</p>";
  }
}
?>