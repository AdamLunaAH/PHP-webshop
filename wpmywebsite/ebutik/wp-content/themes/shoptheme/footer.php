<!-- footer of the wordpress site -->
<footer class="col-12 col-s-12 footer-distributed">
<div class="footer-left">
<img class="footericon" src="<?php echo get_bloginfo('template_directory'); ?>/img/footerImg.png" width="61" height="61"  alt="Icon" >
    <h3>Min Hemsida</h3>
    <p class="footer-company-name">© <span id="copyright"></span> Snow Production Studios  |  <a href="/wpmywebsite/ebutik/integritetspolicy/">Integritetspolicy</a></p>
</div>
<div class="footer-center">
    <div class="footer-padding">
        <i class="footerIcon fa-solid fa-map-location-dot"></i>
          <p><span>Sörbygden</span>
          840 67 Jämtland, Sweden</p>
    </div>
    <div class="footer-padding">
        <i class="footerIcon fa-solid fa-phone"></i>
        <p>+46-390428181</p>
    </div>
    <div class="footer-padding">
        <i class="footerIcon fa-solid fa-envelope"></i>
        <p><a href="mailto:support@placeholder">ebutik@epostadress.com</a></p>
    </div>
    <p class="footer-links">
        <a href="/wpmywebsite/ebutik/">Hem</a> |
        <a href="/wpmywebsite/ebutik/produkter/">Produkter</a> |
        <a href="/wpmywebsite/ebutik/medlemskonto/">Konto</a> |
        <a href="/wpmywebsite/ebutik/kontakt/">Kontakt</a>
    </p>
</div>
<div class="footer-right">
<div class="toggle">
      <input type="checkbox" id="theme" class="toggle-input" checked>
      <label for="theme" class="toggle-label">
      <img width='28' height='28' src="<?php echo get_bloginfo('template_directory'); ?>/img/moon.png" alt="Dark mode" class="toggle-icon">
      </label>
    </div>
    <!-- login/logut button -->
    <?php userButtonFooter(); ?>
    <p class="footer-company-about">
        <br><span>Om oss</span>
        Vi är en e-butik som säljer produkter.<br>
    <a href="/wpmywebsite/ebutik/administration_login/">Administration</a>
    </p>
</div>
</footer>

<?php 
?>
<?php wp_footer(); ?>

</body>
</html>