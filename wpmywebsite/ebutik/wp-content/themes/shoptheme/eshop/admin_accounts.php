<?php 
/* Template Name: Admin Accounts page */
	require "eshopfunctions.php";


  if (!isset($_SESSION['admin']) ) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();} 

  // creates the admin account list
    function adminMemberList() {
      $pdo = connectPDO();
      $stmt = $pdo->prepare("SELECT MemberID, Fornamn, Efternamn,
      Epost, Mobilnr, Gatuadress, Postnr, Ort, Skapad FROM medlem");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if ($result !== false && count($result) > 0) {
        echo "<div class='itemTable'><table class='dbResult'><tr class ='dbResultRow'><th class='tableHead'>MemberID</th><th class='tableHead'>Förnamn</th><th class='tableHead'>Efternamn</th><th class='tableHead'>E-post</th><th class='tableHead'>Mobilnr</th><th class='tableHead'>Gatuadress</th><th class='tableHead'>Postnr</th><th class='tableHead'>Ort</th><th class='tableHead'>Skapad</th></tr>";
        // output data of each row
        foreach ($result as $row) {
          echo "<tr>
                <td>"
                  .  htmlspecialchars($row["MemberID"]) .
                "</td>
                <td>"
                  . htmlspecialchars($row["Fornamn"]) .
                "</td>
                <td>"
                  .  htmlspecialchars($row["Efternamn"]) .
                "</td>
                <td>"
                  .  htmlspecialchars($row["Epost"]) .
                "</td>
                <td>"
                  . htmlspecialchars($row["Mobilnr"]) .
                "</td>
                <td>"
                  . htmlspecialchars($row["Gatuadress"]) .
                "</td>
                <td>"
                  . htmlspecialchars($row["Postnr"]) .
                "</td>
                <td>"
                  . htmlspecialchars($row["Ort"]) .
                "</td>
                <td>"
                  . htmlspecialchars($row["Skapad"]) .
                "</td>
          </tr>     
        ";}
        echo "</table>";
      } else {
      echo "0 results";
      }
      } ?>
<?php get_header();?>
<main id="maintest">

  <div class="col-1 col-s-1"></div>
<div class="row"><div class="col-10 col-s-10">
  <!-- admin member list -->
    <h1>Visar Medlemmar</h1>
    <?php adminMemberList(); ?>
</div></div></main>
<?php get_footer();?>