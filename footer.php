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
        <ul>
          <li><a href="calculator.html#basic">Grade Calculator</a></li>
          <li><a href="calculator.html#cgpa">Multi-Subject CGPA</a></li>
          <li><a href="calculator.html#target">Target Grade Finder</a></li>
        </ul>
      </div>
      <div class="foot-col">
        <h4>Site</h4>
        <ul>
          <li><a href="#tools">Tools</a></li>
          <li><a href="#how">How it works</a></li>
          <li><a href="#top">Back to top</a></li>
        </ul>
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
