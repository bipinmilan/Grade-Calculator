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
      <div class="footer-col footer-col-about">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
            <?php if ( has_custom_logo() ) : ?>
                  <?php the_custom_logo(); ?>
            <?php else : ?>
            <span class="mark">A+</span>
            <?php endif; ?>
            <?php bloginfo( 'name' ); ?>
        </a>    
          <?php if ( is_active_sidebar( 'footer-about' ) ) : ?>
              <?php dynamic_sidebar( 'footer-about' ); ?>
          <?php else : ?>
      <!-- Fallback shown only if no widget has been added yet -->
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
        <span class="mark">A+</span> <?php bloginfo( 'name' ); ?>
      </a>
      <p><?php esc_html_e( 'Add a widget to the "Footer — About" area to customize this section.', 'grade-calculator' ); ?></p>
          <?php endif; ?>
      </div>
      <div class="footer-col footer-col-2">
        <?php
          dynamic_sidebar( 'footer-col-2' );
        ?>
      </div>
      <div class="footer-col footer-col-3">
        <?php dynamic_sidebar( 'footer-col-3' ); ?>
      </div>
      <div class="footer-col footer-col-4">
        <?php dynamic_sidebar( 'footer-col-4' ); ?>
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
