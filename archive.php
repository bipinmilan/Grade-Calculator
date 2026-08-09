<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Grade_Calculator
 */

get_header();
?>

	<main id="primary" class="site-main">
	<div class="wrap">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div class="archive-layout">

				<div class="archive-main">
					<div class="post-list">
						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content', get_post_type() );
						endwhile;
						the_posts_navigation();
						?>
					</div><!-- .post-list -->
				</div><!-- .archive-main -->

				<?php get_sidebar(); ?>

			</div><!-- .archive-layout -->

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

	</div><!-- .wrap -->
</main><!-- #main -->
<?php

get_footer();
