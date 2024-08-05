<?php
// login/logout footer button
function logoutFooter(){ session_destroy(); echo "<meta http-equiv='refresh' content='0'>"; exit(); }
if (!function_exists('connect')) { function connect() {/*empty function*/}}
function userButtonFooter(){
  if(isset($_SESSION['userid']) || isset($_SESSION['admin'])){
    echo "<form method='POST'>
    <button class='loggaUt' name='logoutBtn' value='logoutBtn'>Logga ut</button></form>";
    if(array_key_exists('logoutBtn', $_POST)) {logoutFooter();}
	} else {
    echo "<form action='/wpmywebsite/ebutik/logga-in/'>
    <button class='loggaUt' name='loginBtn' value='loginBtn'>Logga in</button></form>";}} ?>
<!DOCTYPE html>
<!-- header of the wordpress site -->
<!-- the header includes more that just the code inside the <head> tag, it also includes the
   navigation bar in the <body> because it an element available on every page. -->
<html lang="sv">
    <head>
      <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="E-butik för varor, med medlemserbjudanden">
        <title><?php echo get_the_title(); ?></title>
        <!-- main css -->
        <!--<link rel="icon" sizes="16x16 32x32 64x64" href="<?php echo get_bloginfo('template_directory'); ?>/style.css">-->
        <!-- favicons -->
        <link rel="shortcut icon" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon.ico">
	      <link rel="icon" sizes="16x16 32x32 64x64" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon.ico">
	      <link rel="icon" type="image/png" sizes="196x196" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-192.png">
        <link rel="icon" type="image/png" sizes="160x160" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-160.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-96.png">
        <link rel="icon" type="image/png" sizes="64x64" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-64.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-16.png">
        <link rel="apple-touch-icon" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-57.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-114.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-72.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-144.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-60.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-120.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-76.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-180.png">
        <meta name="msapplication-TileColor" content="#FFFFFF">
        <meta name="msapplication-TileImage" content="<?php echo get_bloginfo('template_directory'); ?>/faviconit/favicon-144.png">
        <meta name="msapplication-config" content="<?php echo get_bloginfo('template_directory'); ?>/faviconit/browserconfig.xml">

      <!-- links the css and javascript files, and adds the wordpress admin header to the web page -->
      <?php $wp_styles = wp_styles(); ?>
      <!-- Wordpress header -->
      <?php wp_head(); ?>
      </head>
      <!-- body that links to the says what light mode is used by default -->
      <body class="page light">
      <header class="header">
                <!--<navbar>-->
                  <nav class="main-nav">
                <!-- Logo -->
                  <div class="logodiv">
                    <a href="/php-webshop/wpmywebsite/ebutik/" class="logo">
                    <img src="<?php echo get_bloginfo('template_directory'); ?>/img/headerImg.png"
                    width="61" height="61" class="logoimg" alt="Home logo icon">
                    <p class="logoh1">Hem</p></a></div>
                    <!-- Hamburger icon -->
                        <input class="menu-btn" type="checkbox" id="menu-btn">
                        <label class="menu-icon" for="menu-btn"><span class="nav-icon"></span></label>
                    <!-- Navigationmenu with excluded pages-->
                        <ul class="menu">
                  <?php
                    $exclude = [];
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/productinfo.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/tack.php',]) as $page) { $exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/integritetspolicy.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/forgot-password.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'tackmeddelande.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/administration.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/administration_login.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_accounts.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_categories.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_orders.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_memberoffers.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_offers.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_products.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_new_product.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_new_offer.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_new_memberoffer.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_new_category.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_new_.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_edit_product_info.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_edit_category.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_edit_memberoffer.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_edit_offer.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/edit_account.php',]) as $page) {$exclude[] = $page->post_id;}
                    foreach (get_pages(['meta_key' => '_wp_page_template','meta_value' => 'eshop/admin_json-converter.php',]) as $page) {$exclude[] = $page->post_id;}

                      $args = array(
                          'exclude'      => implode(",", $exclude),
                          'depth'        => 2,
                          'title_li'     => '',
                          'sort_column'  => 'menu_order, post_title',
                          'post_type'    => 'page',
                          'post_status'  => 'publish');

                    wp_list_pages($args);?>
                        </ul></nav></header>