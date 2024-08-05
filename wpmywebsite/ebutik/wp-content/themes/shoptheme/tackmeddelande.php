<?php /* Template Name: Tack Meddelande Page */ ?>
<!-- contact thanks page -->
<?php get_header(); ?>
<main>
  <div class="row">
  <div class="col-4 col-s-4"></div>
  <div class="col-4 col-s-4">
  <div class="tack">
        <h1>Meddelande skickat</h1>
          <p class="tack-text">
            Tack för ditt meddelande, <?php echo htmlspecialchars($_POST["KontaktNamn"]); ?>!<br>
            Ditt meddelande har skickats in och vi besvarar det så fort vi kan.<br>Svaret kommer att skickas till E-postadressen: <?php echo htmlspecialchars($_POST["kontaktEpost"]); ?>
          </p>
          <div class="wp-container-1 is-content-justification-center wp-block-buttons">
          <div class="wp-block-button"><a class="wp-block-button__link" href="/wpmywebsite/ebutik/">Hem</a></div>  
      </div>
  </div>
  </div>
  </div>
</main>
<?php get_footer(); ?>  