<?php 
/* Template Name: Admin Member Offers page */
	require "eshopfunctions.php";


  if (!isset($_SESSION['admin']) ) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();} 

  // creates the member offer list
    function adminOfferTable(){
      $pdo = connectPDO();
      $offerList = $pdo->prepare("SELECT OfferID, MemberID, DiscountID FROM medlemserbjudanden");
      $offerList->execute();
      $result = $offerList->fetchAll(PDO::FETCH_ASSOC);
      if (count($result) > 0) {
          echo "<div class='itemTable'><table class='dbResult'><tr class ='dbResultRow'><th class='tableHead'>OfferID</th><th class='tableHead'>MemberID</th><th class='tableHead'>DiscountID</th></tr>";
          foreach ($result as $row) {
              echo "<tr>
              <td>" . $row["OfferID"] . "</td>
              <td>" . $row["MemberID"] . "</td>
              <td>" . $row["DiscountID"] . "</td>
              <td>
              <a href='/wpmywebsite/ebutik/administration/admin-edit-memberoffer?memberofferid={$row["OfferID"]}'>Ändra</a>
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