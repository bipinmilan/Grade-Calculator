<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Grade_Calculator
 */

if ( ! is_active_sidebar( 'sidebar-1' ) && ! grade_calculator_show_tools_card() ) {
	return;
}
?>
<aside id="secondary" class="widget-area">


	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div class="sidebar-widgets-list">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	<?php endif; ?>

</aside><!-- #secondary -->
