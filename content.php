<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Grade_Calculator
 */

if ( is_singular() ) : ?>

	<!-- ============================================================
	     SINGLE POST VIEW — full content, no "Read full post" link
	     ============================================================ -->
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'scorebook-single-post' ); ?>>

		<header class="post-hero-inline">
			
			<?php the_title( '<h1>', '</h1>' ); ?>

			<div class="post-meta">
				<span><i class="fa-solid fa-calendar"></i> <?php grade_calculator_posted_on(); ?></span>
				<span><i class="fa-solid fa-user"></i> <?php grade_calculator_posted_by(); ?></span>
			</div>
		</header><!-- .post-hero-inline -->

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
			<?php //grade_calculator_recent_posts_carousel(); ?>
	</article><!-- #post-<?php the_ID(); ?> -->

<?php else : ?>

	<!-- ============================================================
	     ARCHIVE / LOOP LIST ITEM — title, thumbnail, excerpt,
	     "Read full post" button
	     ============================================================ -->
	<article <?php post_class( 'post-list-item' ); ?>>
		<div class="post-list-body">
			<?php
			$categories = get_the_category();
			if ( ! empty( $categories ) ) :
			?>
				<span class="blog-tag"><?php echo esc_html( $categories[0]->name ); ?></span>
			<?php endif; ?>
			<h2 class="post-list-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
			<div class="blog-meta">
				<span><i class="fa-solid fa-calendar"></i> <?php echo esc_html( get_the_date() ); ?></span>
				<span><i class="fa-solid fa-user"></i> <?php the_author(); ?></span>
			</div>
		</div>
		<a href="<?php the_permalink(); ?>" class="post-list-thumb-link" aria-hidden="true" tabindex="-1">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'large', array( 'class' => 'post-list-thumb', 'loading' => 'lazy' ) ); ?>
			<?php else : ?>
				<div class="post-list-thumb post-list-thumb-fallback">
					<i class="fa-solid fa-newspaper"></i>
				</div>
			<?php endif; ?>
		</a>
		<div class="post-list-body">
			<p class="post-list-excerpt">
				<?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '…' ) ); ?>
			</p>
			<a href="<?php the_permalink(); ?>" class="btn btn-outline post-list-btn">
				<?php esc_html_e( 'Read full post', 'grade-calculator' ); ?> <i class="fa-solid fa-arrow-right"></i>
			</a>
		</div>
	</article>

<?php endif; ?>