<?php
/* Template Name: Products page */
	require "eshopfunctions.php";
  ?>
<?php get_header();?>



<!-- links to the jquery library and jquery css -->
<link rel='stylesheet' href="<?php echo get_bloginfo('template_directory'); ?>/jquery/jquery-ui.css">
<script src='<?php echo get_bloginfo('template_directory'); ?>/jquery/jquery-3.6.0.min.js'></script>
<script src='<?php echo get_bloginfo('template_directory'); ?>/jquery/jquery-ui-1.12.1.min.js'></script>
<script>

// javascript code for autocomplete function
$(function() {
  // set up the autocomplete functionality on the input field with ID "searchProducts"
  $('#searchProducts').autocomplete({
    // function is called when the user types in the input field and triggers the autocomplete
    source: function(request, response) {
      // send an AJAX request to the server to retrieve product data that matches the user's input
      $.ajax({
        url: "<?php echo get_bloginfo('template_directory'); ?>/eshop/product_autofill_search.php",
        dataType: 'json',
        data: {
          term: request.term
        },
        // function is called when the server returns the product data
        success: function(data) {
          // map the product data to an array of objects that have a "label" and "value" property
          response($.map(data, function(item) {
            return {
              label: item.Produktnamn,
              value: item.Produktnamn
            }
          }));
        }
      });
    },
    // the minimum number of characters the user must type to trigger the autocomplete
    minLength: 2
  });
});

// javascript code for AJAX live search function
// code block runs when the document is ready
$(document).ready(function(){
  // function is called when the user types in the search input field
  $("#searchProducts").keyup(function(){
    // Get the value of the search input field
    var queryProductSearch = $(this).val();
    // Check if the search input field is not empty
    if(queryProductSearch != ''){
      // Send an AJAX request to the server to search for products
      $.ajax({
        // URL of the PHP script that will handle the search request
        url: "<?php echo get_bloginfo('template_directory'); ?>/eshop/searchProducts.php",
        // Use the POST method to send the search query to the server
        method:"POST",
        data:{queryProductSearch:queryProductSearch},
        // This function is called when the server responds with data
        success:function(data){
          // Replace the contents of the result div with the search results
          $("#result").html(data);
          // Show the search result div
          $("#result").show();
          // Hide the default product div
          $('#default').hide();
        }
        });
        }
          // If the search input field is empty
          else {
          // Show the default product div
          $('#default').show();
          // Hide the search results div
          $("#result").hide();
    }
  });
});
</script>

<?php

  // creates the product list
  function productlist(){
    $pdo = connectPDO();
    $themeLink = get_bloginfo('template_directory')."/eshop/img/produkter/";
    $productList = "SELECT produkter.ProductID , produkter.Produktnamn, produkter.Produktbeskrivning,
    produkter.Pris, kategorier.CategoryID, kategorier.Kategorinamn, produkter.Bild FROM produkter
    INNER JOIN kategorier ON kategorier.CategoryID = produkter.CategoryID";
    $stmt = $pdo->prepare($productList);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result !== false && count($result) > 0) {
      echo "<div class='productListPage'>";
      // output data of each row
      foreach ($result as $row) {
        $descriptionLimit = mb_strimwidth(htmlspecialchars($row["Produktbeskrivning"]), 0, 100, "...");
        echo "<div class='productPageGrid kategori-". htmlspecialchars($row['CategoryID']) ."'>
        <h3 class='productName '>" . htmlspecialchars($row["Produktnamn"]). "</h3><br>" .
        "<img class='productImg' src='" . $themeLink . htmlspecialchars($row["Bild"]) . "' width='300' height='300' alt='" . htmlspecialchars($row["Produktnamn"]) . "'>" .
         "<br>" . htmlspecialchars($row["ProductID"]) . "<br>" . /*htmlspecialchars($row["Produktbeskrivning"])*/ $descriptionLimit. "<br>" .
         htmlspecialchars($row["Pris"]) . "<br>" . htmlspecialchars($row["Kategorinamn"]) . "<br>
         <a href='/php-webshop/wpmywebsite/ebutik/produkt?produktnr=" . htmlspecialchars($row["ProductID"]) . "'>Länk</a>"."</div>";}
      echo "</div>";
    } else {
      echo "0 results"; } } ?>


<main id="maintest">
  <div class="col-1 col-s-1"></div>
<div class="row"><div class="col-10 col-s-10">

  <!-- product list -->
    <h1>Produkter</h1>
    <div class="row"><div class='productListPage'>Produktsökning
  <input type="text" id="searchProducts" name="searchProducts" placeholder="Sök..."></div></div><br>
  <div id="result"></div>
  <div id="default"><?php ProductList(); ?></div>
</div></div></main>
<?php get_footer();?>