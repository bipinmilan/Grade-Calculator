<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Grade_Calculator
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Scorebook — Grade, CGPA & Target Score Calculators</title>
<meta name="description" content="Free tools to calculate your exam grade, weighted CGPA across subjects, and the score you need on your final. Instant, private, no sign-up.">
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📝</text></svg>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700;9..144,900&family=IBM+Plex+Sans:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<?php wp_head(); ?>
</head>
<body>
<header class="site">
  <nav class="bar">
    <a href="#top" class="logo"><span class="mark">A+</span> Scorebook</a>
    <ul class="nav-links" id="navLinks">
      <!--li><a href="#tools">Tools</a></li>
      <li><a href="#how">How it works</a></li>
      <li><a href="calculator.html#basic">Grade Calculator</a></li>
      <li><a href="calculator.html#cgpa">CGPA</a></li>
      <li><a href="calculator.html" class="nav-cta">Open Calculator</a></li-->
    <!--/ul-->
    <?php
            wp_nav_menu(array(
                'theme_location' => 'main-menu',
                'container' => false,
                'menu_class' => 'navbar-nav ms-auto gap-3',
                'fallback_cb' => '__return_false',
                'items_wrap' => '<ul id="%1$s" class="navbar-nav me-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
                'depth' => 2,
                'walker' => new bootstrap_5_wp_nav_menu_walker()
            ));
            ?>
          </ul>
    <button class="burger" id="burger" aria-label="Toggle menu"><i class="fa-solid fa-bars"></i></button>
  </nav>
</header>
