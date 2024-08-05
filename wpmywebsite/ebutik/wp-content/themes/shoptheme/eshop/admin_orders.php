<?php 
/* Template Name: Admin Orders page */
	require "eshopfunctions.php";

 
  if (!isset($_SESSION['admin']) ) {
		header("location: ebutik/administration_login/");
		exit();} 

    // creates the admin order list   
      function adminOrderList(){
        $pdo = connectPDO();
        // $userid=$_SESSION['userid']);
        // $memberOrderID = $userid;
        $orderInfo = "SELECT bestallning.MemberID, bestallning.OrderID, bestallning.Bestallningsdatum,bestallningsdetaljer.ProductID, bestallningsdetaljer.Antal, produkter.Produktnamn, produkter.Pris
        ,SUM(produkter.Pris * bestallningsdetaljer.Antal) AS totalPris
        ,SUM(bestallningsdetaljer.Antal) AS totalProdukter
        FROM bestallning
        INNER JOIN bestallningsdetaljer ON bestallningsdetaljer.OrderID = bestallning.OrderID
        INNER JOIN produkter ON produkter.ProductID = bestallningsdetaljer.ProductID
        -- WHERE MemberID = :memberOrderID
        GROUP BY bestallning.OrderID
        ORDER BY bestallning.Bestallningsdatum";
        $stmt = $pdo->prepare($orderInfo);
        // $stmt->bindParam(':memberOrderID', $memberOrderID, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "<div class='col-5 col-s-5 orderMainInfo'>";
            // output data of each row
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='orderInfo'>" . "<p class='orderHead'>" . "Ordernummer: " . htmlspecialchars($row['OrderID']) . "<br>" . "Medlemsnummer: " . htmlspecialchars($row['MemberID']) . "<br>" ."Beställningsdatum: " . htmlspecialchars($row["Bestallningsdatum"]). "<br>".  "Totalpris: " . htmlspecialchars($row['totalPris']). "<br>" . "Antal produkter: " . htmlspecialchars($row['totalProdukter']) . "<br>";
                // Order product information
                $orderInfo2 = "SELECT bestallning.MemberID, bestallning.OrderID, bestallning.Bestallningsdatum,
                bestallningsdetaljer.ProductID, bestallningsdetaljer.Antal, produkter.Produktnamn, produkter.Pris
                FROM bestallning
                INNER JOIN bestallningsdetaljer ON bestallningsdetaljer.OrderID = bestallning.OrderID
                INNER JOIN produkter ON produkter.ProductID = bestallningsdetaljer.ProductID
                -- WHERE MemberID = :memberOrderID
                GROUP BY bestallningsdetaljer.ProductID";
                $stmt2 = $pdo->prepare($orderInfo2);
                // $stmt2->bindParam(':memberOrderID', $memberOrderID, PDO::PARAM_INT);
                $stmt2->execute();
                if ($stmt2->rowCount() > 0) {
                    echo "<div class='orderMainInfo2'>";
                    // output data of each row
                    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='orderProductInfo'><ul class='orderProductList'><li>Produktnamn: " . htmlspecialchars($row2["Produktnamn"]) . "</li><li>" . "Produktnummer: " . htmlspecialchars($row2["ProductID"]). "</li><li>" . "Pris: " . htmlspecialchars($row2["Pris"]) . "</li><li>" . "Antal: " . htmlspecialchars($row2["Antal"]) . "</li><li>". "<a class='orderProductLink' href='/wpmywebsite/ebutik/produkt?produktnr={$row2["ProductID"]}'>Länk</a>"."</li></ul></div>";}
                    echo "<hr class='orderDivider'></div>";}}
                echo "</div></div></div>";} else {
            echo "<div class='orderProductInfo'> Du har ej lagt en order ännu.</div>";}
    }
    
?>
<?php get_header();?>
<main id="maintest">
  <div class="col-1 col-s-1"></div>
<div class="row"><div class="col-10 col-s-10">
  <!-- admin order list -->
    <h1>Visar Beställningar</h1>
    <?php adminOrderList(); ?>
</div></div></main>
<?php get_footer();?>