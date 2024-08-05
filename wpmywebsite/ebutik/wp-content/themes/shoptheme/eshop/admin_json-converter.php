<?php 
/* Template Name: JSON converter page */
	require "eshopfunctions.php";

  // creates the JSON output list

  if (!isset($_SESSION['admin']) ) {
		header("location: /wpmywebsite/ebutik/administration_login/");
		exit();} 



    function jsonOutput() {
      $pdo = connectPDO();
      $stmt = $pdo->prepare("SELECT ProductID, Produktnamn FROM produkter");
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $jsonResult = json_encode($result);
      echo $jsonResult;
    }
?>

<?php get_header();?>
<main id="main">
  
  <div class="col-1 col-s-1"></div>
<div class="row"><div class="col-10 col-s-10">

  <!-- product list -->
    <h1>Visar JSON resultat från function jsonOutput()</h1>
    <?php jsonOutput() ?>
</div></div></main>
<?php get_footer();?>