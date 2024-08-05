<?php 
/* Template Name: Admin Category page */
	require "eshopfunctions.php";

  if (!isset($_SESSION['admin']) ) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();} 

  // creates the admin category list
    function adminCategoryTable(){
      $pdo = connectPDO();
      $categoryList = "SELECT CategoryID , Kategorinamn FROM kategorier";
      $stmt = $pdo->prepare($categoryList);
      $stmt->execute();
      $result = $stmt->fetchAll();
      if ($result !== false && count($result) > 0) {
        echo "<div class='itemTable'><table class='dbResult'><tr class ='dbResultRow'><th class='tableHead'>CategoryID</th><th class='tableHead'>Kategorinamn</th></tr>";
        // output data of each row
        foreach ($result as $row) {
          echo "<tr>
            <td>"
              . $row["CategoryID"] .
            "</td>
            <td>"
            . $row["Kategorinamn"] . 
            "</td>
            <td>
              <a href='/wpmywebsite/ebutik/administration/admin-edit-category?categoryid={$row["CategoryID"]}'>Ändra</a>
            </td>
          </tr>     
        ";}
        echo "</table>";
      } else {
        echo "0 results"; }
      $pdo = null;
    } ?>
<?php get_header();?>
<main id="maintest">

  <div class="col-1 col-s-1"></div>
<div class="row"><div class="col-10 col-s-10">
  <!-- category list -->
    <h1>Visar kategorier</h1>
    <?php adminCategoryTable(); ?>
</div></div></main>
<?php get_footer();?>