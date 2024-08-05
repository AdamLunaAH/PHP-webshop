<?php 
/* Template Name: Admin Offers page */
	require "eshopfunctions.php";

  // creates the product list
  if (!isset($_SESSION['admin']) ) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();} 

    function adminOfferTable() {
      $pdo = connectPDO();
      $stmt = $pdo->prepare("SELECT DiscountID, ProductID, ErbjudPris, Starttid, Sluttid FROM erbjudanden");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (count($result) > 0) {
        echo "<div class='itemTable'><table class='dbResult'><tr class ='dbResultRow'><th class='tableHead'>DiscountID</th><th class='tableHead'>ProductID</th><th class='tableHead'>Erbjudandepris</th><th class='tableHead'>Starttid</th><th class='tableHead'>Sluttid</th></tr>";
        foreach ($result as $row) {
          echo "<tr>
          <td>"
          . $row["DiscountID"] .
          "</td>
          <td>"
          . $row["ProductID"] .
          "</td>
          <td>"
          . $row["ErbjudPris"] .
          "</td>
          <td>"
          . $row["Starttid"] .
          "</td>
          <td>"
          . $row["Sluttid"] .
          "</td>
          <td>
          <a href='/wpmywebsite/ebutik/administration/admin-edit-offer?offerid={$row["DiscountID"]}'>Ändra</a>
          </td>
          </tr>";
        }
        echo "</table>";
      } else {
        echo "0 results";
      }
    } ?>
<?php get_header();?>
<main id="maintest">

  <div class="col-1 col-s-1"></div>
<div class="row"><div class="col-10 col-s-10">
  <!-- offer list -->
    <h1>Visar erbjudande</h1>
    <?php adminOfferTable(); ?>
</div></div></main>
<?php get_footer();?>