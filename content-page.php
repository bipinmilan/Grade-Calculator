<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Grade_Calculator
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'scorebook-page' ); ?>>

	<div class="page-head">
		<div class="wrap">
			<span class="eyebrow">Page</span>
			<?php the_title( '<h1>', '</h1>' ); ?>
		</div>
	</div>

	<main>
		<div class="wrap">

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="page-thumb">
					<?php the_post_thumbnail( 'large' ); ?>
				</div>
			<?php endif; ?>

			<section class="card entry-content-card">
				<div class="entry-content">
					<?php
					the_content();
					wp_link_pages(
						array(
							'before'      => '<nav class="page-links" aria-label="' . esc_attr__( 'Page navigation', 'grade-calculator' ) . '"><span class="page-links-label">' . esc_html__( 'Pages:', 'grade-calculator' ) . '</span>',
							'after'       => '</nav>',
							'link_before' => '<span class="page-link-chip">',
							'link_after'  => '</span>',
						)
					);
					?>
				</div><!-- .entry-content -->

				<?php if ( get_edit_post_link() ) : ?>
					<footer class="entry-footer">
						<?php
						edit_post_link(
							sprintf(
								wp_kses(
									/* translators: %s: Name of current post. Only visible to screen readers */
									__( 'Edit <span class="screen-reader-text">%s</span>', 'grade-calculator' ),
									array(
										'span' => array(
											'class' => array(),
										),
									)
								),
								wp_kses_post( get_the_title() )
							),
							'<span class="edit-link">',
							'</span>'
						);
						?>
					</footer><!-- .entry-footer -->
				<?php endif; ?>
			</section>

		</div>
	</main>

</article><!-- #post-<?php the_ID(); ?> -->