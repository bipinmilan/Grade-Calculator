<?php
/**
 * Grade Calculator functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Grade_Calculator
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function grade_calculator_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Grade Calculator, use a find and replace
		* to change 'grade-calculator' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'grade-calculator', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	add_action('after_setup_theme', function() {
    register_nav_menus([
        'primary' => __('Primary Menu', 'scorebook'),
    	]);
	});
	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'grade_calculator_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'grade_calculator_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function grade_calculator_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'grade_calculator_content_width', 640 );
}
add_action( 'after_setup_theme', 'grade_calculator_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function grade_calculator_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'grade-calculator' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'grade-calculator' ),
			'before_widget' => '<section id="%1$s" class="widget sidebar-card %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title"><span class="widget-title-icon"><i class="fa-solid ' . grade_calculator_widget_icon() . '"></i></span>',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar( array(
		'name'          => __( 'Footer — About', 'grade-calculator' ),
		'id'            => 'footer-about',
		'description'   => __( 'Logo, tagline, and any content for the first footer column.', 'grade-calculator' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer — Column 2', 'grade-calculator' ),
		'id'            => 'footer-col-2',
		'description'   => __( 'Second footer column — e.g. Tools links.', 'grade-calculator' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer — Column 3', 'grade-calculator' ),
		'id'            => 'footer-col-3',
		'description'   => __( 'Third footer column — e.g. Site links.', 'grade-calculator' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer — Column 4', 'grade-calculator' ),
		'id'            => 'footer-col-4',
		'description'   => __( 'Third footer column — e.g. Site links.', 'grade-calculator' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'grade_calculator_widgets_init' );

/**
 * Returns a Font Awesome icon class based on the widget currently being rendered.
 * WordPress doesn't pass the widget type into before_title, so we track it via
 * the dynamic_sidebar_before/after hooks and a small lookup table.
 */

function grade_calculator_widget_icon() {
	global $wp_registered_widgets, $sidebars_widgets;

	$icon_map = array(
		'search'          => 'fa-magnifying-glass',
		'recent-posts'    => 'fa-clock-rotate-left',
		'recent-comments' => 'fa-comments',
		'archives'        => 'fa-box-archive',
		'categories'      => 'fa-tags',
		'meta'            => 'fa-gear',
		'tag_cloud'       => 'fa-hashtag',
		'calendar'        => 'fa-calendar-days',
		'rss'             => 'fa-rss',
		'nav_menu'        => 'fa-list',
		'text'            => 'fa-note-sticky',
		'custom_html'     => 'fa-code',
	);

	$current_id = grade_calculator_current_widget_id();
	foreach ( $icon_map as $key => $icon ) {
		if ( $current_id && false !== strpos( $current_id, $key ) ) {
			return $icon;
		}
	}
	return 'fa-star'; // fallback icon for unrecognized/plugin widgets
}

function grade_calculator_current_widget_id() {
	global $wp_current_widget_id;
	return isset( $wp_current_widget_id ) ? $wp_current_widget_id : '';
}
add_action( 'dynamic_sidebar', function( $widget ) {
	global $wp_current_widget_id;
	$wp_current_widget_id = isset( $widget['id'] ) ? $widget['id'] : '';
} );


function grade_calculator_show_tools_card() {
	return true; // flip to false if you'd rather the sidebar only show dashboard widgets
}

/**
 * Breadcrumb trail: Home > [Post's Category] > Post Title
 * Also outputs BreadcrumbList JSON-LD for SEO rich results.
 */
function grade_calculator_breadcrumbs() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$home_url  = home_url( '/' );
	$home_name = __( 'Home', 'grade-calculator' );

	// Get the post's primary category (first assigned category, or the one
	// marked primary if Yoast/RankMath's primary-category field is in use).
	$categories  = get_the_category();
	$category    = ! empty( $categories ) ? $categories[0] : null;

	// Prefer an SEO plugin's "primary category" if one is set, since a post
	// can belong to multiple categories and editors often pick one as primary.
	if ( class_exists( 'WPSEO_Primary_Term' ) ) {
		$primary_term = new WPSEO_Primary_Term( 'category', get_the_ID() );
		$primary_id   = $primary_term->get_primary_term();
		if ( $primary_id ) {
			$primary_cat = get_term( $primary_id, 'category' );
			if ( $primary_cat && ! is_wp_error( $primary_cat ) ) {
				$category = $primary_cat;
			}
		}
	}

	$cat_url  = $category ? get_category_link( $category->term_id ) : '';
	$cat_name = $category ? $category->name : __( 'Blog', 'grade-calculator' );

	$post_title = get_the_title();

	$schema_items = array(
		array(
			'@type'    => 'ListItem',
			'position' => 1,
			'name'     => $home_name,
			'item'     => $home_url,
		),
	);

	if ( $category ) {
		$schema_items[] = array(
			'@type'    => 'ListItem',
			'position' => 2,
			'name'     => $cat_name,
			'item'     => $cat_url,
		);
	}

	$schema_items[] = array(
		'@type'    => 'ListItem',
		'position' => $category ? 3 : 2,
		'name'     => $post_title,
	);

	echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'grade-calculator' ) . '">';
	echo '<a href="' . esc_url( $home_url ) . '">' . esc_html( $home_name ) . '</a>';
	echo '<i class="fa-solid fa-chevron-right breadcrumb-sep" aria-hidden="true"></i>';

	if ( $category ) {
		echo '<a href="' . esc_url( $cat_url ) . '">' . esc_html( $cat_name ) . '</a>';
		echo '<i class="fa-solid fa-chevron-right breadcrumb-sep" aria-hidden="true"></i>';
	}

	echo '<span class="breadcrumb-current" aria-current="page">' . esc_html( $post_title ) . '</span>';
	echo '</nav>';

	echo '<script type="application/ld+json">' . wp_json_encode( array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $schema_items,
	) ) . '</script>';
}

	/**
 * Outputs a horizontal carousel of recent posts (excluding the current one).
 * Called at the end of single post content.
 */
function grade_calculator_recent_posts_carousel() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$recent_posts = new WP_Query( array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 8,
		'post__not_in'   => array( get_the_ID() ),
		'orderby'        => 'date',
		'order'          => 'DESC',
		'no_found_rows'  => true,
	) );

	if ( ! $recent_posts->have_posts() ) {
		return;
	}
	?>

	<section class="carousel-section" aria-label="<?php esc_attr_e( 'More from the blog', 'grade-calculator' ); ?>">
		<div class="carousel-head">
			<h2><i class="fa-solid fa-layer-group"></i> <?php esc_html_e( 'More from the blog', 'grade-calculator' ); ?></h2>
			<div class="carousel-controls">
				<button type="button" class="carousel-btn carousel-prev" aria-label="<?php esc_attr_e( 'Previous posts', 'grade-calculator' ); ?>">
					<i class="fa-solid fa-chevron-left"></i>
				</button>
				<button type="button" class="carousel-btn carousel-next" aria-label="<?php esc_attr_e( 'Next posts', 'grade-calculator' ); ?>">
					<i class="fa-solid fa-chevron-right"></i>
				</button>
			</div>
		</div>

		<div class="carousel-track" tabindex="0">
			<?php
			while ( $recent_posts->have_posts() ) :
				$recent_posts->the_post();
				?>
				<a href="<?php the_permalink(); ?>" class="carousel-card">
					<div class="carousel-thumb-wrap">
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'medium_large', array( 'class' => 'carousel-thumb', 'loading' => 'lazy' ) ); ?>
						<?php else : ?>
							<div class="carousel-thumb carousel-thumb-fallback">
								<i class="fa-solid fa-newspaper"></i>
							</div>
						<?php endif; ?>
					</div>
					<div class="carousel-card-body">
						<span class="carousel-date"><?php echo esc_html( get_the_date() ); ?></span>
						<h3 class="carousel-title"><?php the_title(); ?></h3>
					</div>
				</a>
				<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</section>

	<?php
}

/**
 * Register Custom Navigation Walker
 */
function register_navwalker(){
	require_once get_template_directory() . '/inc/class-scorebook-walker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );
/**
 * Enqueue scripts and styles.
 */
function grade_calculator_scripts() {
	wp_enqueue_style( 'grade-calculator-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'grade-calculator-style', 'rtl', 'replace' );
	wp_enqueue_script( 'grade_calculator_scripts', get_template_directory_uri() . '/js/script.js', ['jquery'], array(), '1.0.0', true );
	wp_enqueue_script( 'grade-calculator-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'grade_calculator_scripts' );

//footer widgets
function register_tools_menu() {
    register_nav_menus(array(
        'tools-menu' => __('Tools Menu', 'Grade Calculator'),
    ));
}
add_action('after_setup_theme', 'register_tools_menu');

function register_footerpage_menu() {
    register_nav_menus(array(
        'footerpage-menu' => __('Footer Pages Menu', 'Grade Calculator'),
    ));
}
add_action('after_setup_theme', 'register_footerpage_menu');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

