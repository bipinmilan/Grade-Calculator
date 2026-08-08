<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Grade_Calculator
 */

?>

<footer class="site">
  <div class="wrap">
    <div class="foot-top">
      <div class="foot-about">
        <a href="#top" class="logo"><span class="mark">A+</span> Scorebook</a>
        <p>Three small tools for exam percentages, weighted CGPA and target scores — built to be fast, free, and private.</p>
      </div>
      <div class="foot-col">
        <h4>Tools</h4>
        <?php
          wp_nav_menu(array(
            'theme_location' => 'tools-menu',
            'container' => 'ul',
            'menu_class' => 'list-unstyled tools-menu',
            'fallback_cb' => false
          ));
        ?>
      </div>
      <div class="foot-col">
        <h4>Pages</h4>
        <?php
          wp_nav_menu(array(
            'theme_location' => 'footerpage-menu',
            'container' => 'ul',
            'menu_class' => 'list-unstyled footerpage-menu',
            'fallback_cb' => false
          ));
        ?>
      </div>
    </div>
    <div class="foot-bottom">
      <span>© <span id="year"></span> Scorebook. All calculations run in your browser.</span>
      <span>Made with <i class="fa-solid fa-heart"></i> for students</span>
    </div>
  </div>
</footer>

<script>
  
</script>

<?php wp_footer(); ?>

</body>
</html>
