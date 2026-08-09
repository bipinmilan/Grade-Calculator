<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Grade_Calculator
 */

get_header();
?>
<main id="primary" class="site-main single-post-main">

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<div class="wrap breadcrumb-wrap">
			<?php grade_calculator_breadcrumbs(); ?>
		</div>

		<div class="wrap single-layout">

			<div class="single-main">

				<?php get_template_part( 'template-parts/content', get_post_type() ); ?>

				<div class="post-content-card comments-wrap">
					<?php
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>
				</div>

				<?php
				/*the_post_navigation( array(
					'prev_text' => '<span class="post-nav-label"><i class="fa-solid fa-arrow-left"></i> ' . esc_html__( 'Previous', 'grade-calculator' ) . '</span><span class="post-nav-title">%title</span>',
					'next_text' => '<span class="post-nav-label">' . esc_html__( 'Next', 'grade-calculator' ) . ' <i class="fa-solid fa-arrow-right"></i></span><span class="post-nav-title">%title</span>',
				) );*/
				?>

			</div><!-- .single-main -->

			<?php get_sidebar(); ?>

		</div><!-- .single-layout -->

	<?php endwhile; ?>

</main><!-- #main -->

<?php
get_footer();