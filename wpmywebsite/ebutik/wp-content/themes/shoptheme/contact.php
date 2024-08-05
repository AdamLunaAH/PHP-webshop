<?php /* Template Name: Contact form */ ?>
<!-- contact form -->
<?php get_header(); ?>
<main>
  <div class="col-12 col-s-12">
<div class="contain">
  <div class="wrapper">
    <!-- form that will send you to a another page but it will not send a message -->
    <div class="form">
    <h1>Kontakt</h1>
      <h2 class="form-headline">Meddela oss</h2>
      <form id="submit-form" method="POST" action="/wpmywebsite/ebutik/tack/"  enctype="application/x-www-form-urlencoded">
        <p>
          <input id="contactName" class="form-input" type="text" name="KontaktNamn" placeholder="Namn*" required>
          <small class="name-error"></small></p>
        <p><input id="contactEmail" class="form-input" type="email" name="kontaktEpost" placeholder="E-post*" required>
          <small class="name-error"></small></p>
        <p class="full-width"><input id="company-name" class="form-input" type="text" name="foretag" placeholder="Företag"></p>
        <p class="full-width">
          <textarea minlength="20" id="message" cols="30" rows="7" name="meddelande" placeholder="Meddelande*" required></textarea></p>
        <p class="full-width">
        <input type="submit" class="submit-btn" value="submit" >
        <button type="reset" class="reset-btn">Reset</button></p>
      </form></div>
    <div class="contacts contact-wrapper">
      <ul>
        <li>Skicka gärna ett meddelande om ni vill ha mer information eller har några frågor.
        </li>
      </ul>
        <ul class="highlight-contact-info">
          <li class="email-info"><i class="fa-solid fa-envelope" aria-hidden="true"></i> ebutik@epostadress.com </li>
          <li><i class="fa-solid fa-phone"></i> +46-390428181</li>
          <li><a href="https://twitter.com"><i class="fab fa-twitter" aria-hidden="true"></i> Twitter</a></li>
          <li><a href="https://facebook.com"><i class="fa-brands fa-facebook" aria-hidden="true"></i> Facebook</a></li>
          <li><a href="https://instagram.com"><i class="fa-brands fa-instagram" aria-hidden="true"></i> Instagram</a></li>
         </ul>
    </div></div></div></div>
</main>
<?php get_footer(); ?>