<?php
/** The template for displaying 404 pages (not found) **/
get_header();?>
<main>
<div class="row">
<div class="col-1 col-s-1"></div>
<div class="col-10 col-s-10">
		<h1 class="page-title"><?php esc_html_e( 'Inget här', 'shoptheme' ); ?></h1>
	<!-- 404 error page -->
	<div class="error-404 not-found">
		<div class="page-content">
			<p><?php esc_html_e( 'Det ser ut som om ingenting hittades på den här platsen. Gå tillbaka till startsidan', 'customtheme' ); ?></p>
			<form action="/php-webshop/wpmywebsite/ebutik/" class="errorform">
    		<input class="homebtn" type="submit" value="Gå till startsidan"/>
			</form>
		</div>
	</div>
</div>
</div>
</main>
<?php get_footer(); ?>
