<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Grade_Calculator
 */

?>

<?php
/**
 * Template part for displaying posts — used for both single post view
 * and archive/blog-list loop items (via get_template_part('template-parts/content', get_post_type())).
 *
 * @package Grade_Calculator
 */
?>

<?php if ( is_singular() ) : ?>

	<!-- ============================================================
	     SINGLE POST VIEW
	     ============================================================ -->
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'scorebook-single-post' ); ?>>

		<header class="post-hero">
			<div class="wrap">
				<span class="eyebrow">
					<?php
					$categories = get_the_category();
					echo ! empty( $categories ) ? esc_html( $categories[0]->name ) : esc_html__( 'Blog', 'grade-calculator' );
					?>
				</span>
				<?php the_title( '<h1>', '</h1>' ); ?>

				<div class="post-meta">
					<span><i class="fa-solid fa-calendar"></i> <?php grade_calculator_posted_on(); ?></span>
					<span><i class="fa-solid fa-user"></i> <?php grade_calculator_posted_by(); ?></span>
				</div>
			</div>
		</header><!-- .post-hero -->

		<div class="wrap">

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-thumb">
					<?php grade_calculator_post_thumbnail(); ?>
				</div>
			<?php endif; ?>

			<div class="card post-content-card">
				<div class="entry-content">
					<?php
					the_content(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'grade-calculator' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							wp_kses_post( get_the_title() )
						)
					);
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

				<footer class="entry-footer">
					<?php grade_calculator_entry_footer(); ?>
				</footer><!-- .entry-footer -->
			</div><!-- .post-content-card -->

			<div class="post-back-link">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-outline" style="width:auto; display:inline-flex; padding-left:22px; padding-right:22px;">
					<i class="fa-solid fa-arrow-left"></i> <?php esc_html_e( 'Back to home', 'grade-calculator' ); ?>
				</a>
			</div>

		</div>

	</article><!-- #post-<?php the_ID(); ?> -->

<?php else : ?>

	<!-- ============================================================
	     ARCHIVE / LOOP LIST ITEM — matches homepage blog-card style
	     ============================================================ -->
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-card' ); ?>>

		<a href="<?php the_permalink(); ?>" class="blog-thumb-link" aria-hidden="true" tabindex="-1">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium_large', array( 'class' => 'blog-thumb', 'loading' => 'lazy' ) ); ?>
			<?php else : ?>
				<div class="blog-thumb blog-thumb-fallback">
					<i class="fa-solid fa-newspaper"></i>
				</div>
			<?php endif; ?>
		</a>

		<div class="blog-card-body">
			<?php
			$categories = get_the_category();
			if ( ! empty( $categories ) ) :
			?>
				<span class="blog-tag"><?php echo esc_html( $categories[0]->name ); ?></span>
			<?php endif; ?>

			<header class="entry-header">
				<?php the_title( '<h2 class="blog-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</header><!-- .entry-header -->

			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="blog-meta">
					<span><i class="fa-solid fa-calendar"></i> <?php grade_calculator_posted_on(); ?></span>
					<span><i class="fa-solid fa-user"></i> <?php grade_calculator_posted_by(); ?></span>
				</div><!-- .blog-meta -->
			<?php endif; ?>

			<div class="entry-content blog-excerpt">
				<?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '…' ) ); ?>
			</div><!-- .entry-content -->

			<a href="<?php the_permalink(); ?>" class="blog-readmore">
				<?php esc_html_e( 'Read full post', 'grade-calculator' ); ?> <i class="fa-solid fa-arrow-right"></i>
			</a>

			<footer class="entry-footer blog-card-footer">
				<?php grade_calculator_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</div><!-- .blog-card-body -->

	</article><!-- #post-<?php the_ID(); ?> -->

<?php endif; ?>