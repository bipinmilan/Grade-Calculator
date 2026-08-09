<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Grade_Calculator
 */

?>

<div class="card archive-empty">
	<div class="how-panel-stamp" style="margin:0 auto 18px; border-color:var(--ink-faint); outline-color:var(--ink-faint); color:var(--ink-faint);">
		<i class="fa-solid fa-magnifying-glass"></i>
	</div>
	<h2><?php esc_html_e( 'Nothing here yet', 'grade-calculator' ); ?></h2>
	<p><?php esc_html_e( "We couldn't find any posts in this section. Try browsing the full blog instead.", 'grade-calculator' ); ?></p>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary" style="width:auto; display:inline-flex; padding-left:24px; padding-right:24px; margin-top:6px;">
		<i class="fa-solid fa-house"></i> <?php esc_html_e( 'Back to home', 'grade-calculator' ); ?>
	</a>
</div>