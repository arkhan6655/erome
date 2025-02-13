<?php
/**
 * VideoShare functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package videoshare
 */
// Register shortcode to fetch and display iframes from posts
// 
function fetch_related_posts($atts) {
    // Set up the shortcode attributes
    $atts = shortcode_atts(
        array(
            'posts_per_page' => 6, // Number of related posts per page
        ),
        $atts,
        'fetch_related_posts'
    );

    // Get current post ID and categories
    $current_post_id = get_the_ID();
    $categories = get_the_category($current_post_id);
    
    if (empty($categories)) {
        return '<p>No related posts found.</p>';
    }

    // Get category IDs
    $category_ids = wp_list_pluck($categories, 'term_id');

    // Get current page number for pagination
    $paged = (get_query_var('paged')) ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);

    // Query Arguments
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $atts['posts_per_page'],
        'paged' => $paged,
        'post__not_in' => array($current_post_id),
        'category__in' => $category_ids,
        'orderby' => 'rand',
    );

    $query = new WP_Query($args);
    if (!$query->have_posts()) {
        return '<p>No related posts found.</p>';
    }

    // Start Output
    $output = '<div class="related-posts-grid">';

    while ($query->have_posts()) : $query->the_post();
        $post_content = get_the_content();
        preg_match('/<iframe.*?src="(.*?)".*?<\/iframe>/s', $post_content, $iframe_match);
        $iframe = !empty($iframe_match) ? $iframe_match[0] : '<div class="iframe-placeholder"><p>' . get_the_title() . '</p></div>';

        $post_link = get_permalink();
        $post_title = get_the_title();

        // Fetch Post Views
        $post_views = function_exists('pvc_get_post_views') ? pvc_get_post_views(get_the_ID()) : 0;

        // Fetch "Time Ago" Format
        $post_time = get_the_time('U');
        $time_ago = human_time_diff($post_time, current_time('timestamp')) . ' ago';

        // Fetch Categories (Clickable)
        $categories = get_the_category();
        $category_links = [];
        if ($categories) {
            foreach ($categories as $category) {
                $category_links[] = '<a href="' . get_category_link($category->term_id) . '" class="related-category">' . esc_html($category->name) . '</a>';
            }
        }

        $output .= '<div class="related-post">
                        <div class="iframe-container">
                            <a href="' . esc_url($post_link) . '" class="iframe-overlay"></a>
                            ' . $iframe . '
                        </div>
                        <div class="related-title">
                            <a href="' . esc_url($post_link) . '">' . esc_html($post_title) . '</a>
                        </div>
                        <div class="related-meta">
                            <div class="related-meta-item">' . implode(', ', $category_links) . '</div>
                            <div class="related-meta-item">' . esc_html($time_ago) . '</div>
                            <div class="related-meta-item"><i class="far fa-eye"></i> ' . number_format($post_views) . ' views</div>
                        </div>
                    </div>';
    endwhile;

    wp_reset_postdata();
    $output .= '</div>'; // Closing .related-posts-grid

    // Pagination Fix
    $big = 999999999; // Large number to avoid conflicts
    $pagination = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, $paged),
        'total' => $query->max_num_pages,
        'prev_text' => __('« Prev'),
        'next_text' => __('Next »'),
        'type' => 'array', // Returns an array for better styling
    ));

    if ($pagination) {
        $output .= '<div class="related-pagination">';
        foreach ($pagination as $page_link) {
            $output .= '<span class="pagination-item">' . $page_link . '</span>';
        }
        $output .= '</div>';
    }

    return $output;
}

add_shortcode('fetch_related_posts', 'fetch_related_posts');







function fetch_iframes_from_posts($atts) {
    // Set up the shortcode attributes
    $atts = shortcode_atts(
        array(
            'posts_per_page' => 20, // Number of posts to display per page
            'category' => '',
        ),
        $atts,
        'fetch_iframes_from_posts'
    );

    // Get current page
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // WP_Query to get the latest posts
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $atts['posts_per_page'],
        'paged' => $paged, // Add pagination parameter
    );

    if (!empty($atts['category'])) {
        $args['category_name'] = $atts['category'];
    }

    $query = new WP_Query($args);
    $output = '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; max-width: 1200px; margin: auto;">';

    while ($query->have_posts()) : $query->the_post();
        $post_content = get_the_content();
        preg_match('/<iframe.*?src="(.*?)".*?<\/iframe>/s', $post_content, $iframe_match);

        $iframe = !empty($iframe_match) ? $iframe_match[0] : '<div style="position: relative; width: 100%; padding-bottom: 56.25%; background-color: #ddd; text-align: center;">
                        <p style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 16px; color: #333;">' 
                        . get_the_title() . '</p>
                    </div>';

        $post_link = get_permalink();
        $post_title = get_the_title();

        // Fetch Post Views
        $post_views = function_exists('pvc_get_post_views') ? pvc_get_post_views(get_the_ID()) : 0;

        // Fetch "Time Ago" Format
        $post_time = get_the_time('U');
        $time_ago = human_time_diff($post_time, current_time('timestamp')) . ' ago';

        // Fetch Categories (Clickable)
        $categories = get_the_category();
        $category_link = !empty($categories) ? get_category_link($categories[0]->term_id) : '#';
        $category_name = !empty($categories) ? esc_html($categories[0]->name) : 'Uncategorized';

        $output .= '<div style="border: 1px solid #ddd; padding: 5px; background: #fff; text-align: center; position: relative; border-radius: 8px; overflow: hidden;">
                        <div style="position: relative;">
                            <!-- Clickable overlay on iframe only -->
                            <a href="' . esc_url($post_link) . '" style="display: block; position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 2;"></a>
                            ' . $iframe . '
                        </div>
                        <div style="margin-top: 3px; font-size: 13px; color: #333; font-weight: bold;">
                            <!-- Make the post title clickable and color it black -->
                            <a href="' . esc_url($post_link) . '" style="color: #000; text-decoration: none; font-weight: bold;">' . esc_html($post_title) . '</a>
                        </div>
                        <div style="font-size: 12px; color: #777; margin-top: 3px; display: flex; justify-content: space-between; padding: 0 5px; align-items: center;">
                            <div style="flex: 1; text-align: left;">
                                <a href="' . esc_url($category_link) . '" style="color: #0073aa; text-decoration: none; font-weight: bold; font-size: 12px;">' . $category_name . '</a>
                            </div>
                            <div style="flex: 1; text-align: center;">
                                <span>' . esc_html($time_ago) . '</span>
                            </div>
                            <div style="flex: 1; text-align: right;">
                                <span><i class="far fa-eye"></i> ' . number_format($post_views) . ' views</span>
                            </div>
                        </div>
                    </div>';

    endwhile;

    // Add pagination
    $big = 999999999; // Need an unlikely integer
    $pagination = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $query->max_num_pages,
        'prev_text' => __('« Prev'),
        'next_text' => __('Next »'),
    ));

    $output .= '</div>';

    if ($pagination) {
        $output .= '<div class="pagination" style="text-align: center; margin-top: 20px;">' . $pagination . '</div>';
    }

    wp_reset_postdata();
    return $output;
}

add_shortcode('fetch_iframes_from_posts', 'fetch_iframes_from_posts');





if ( ! function_exists( 'videoshare_setup' ) ) :

function videoshare_setup() {

	load_theme_textdomain( 'videoshare', get_template_directory() . '/languages' );

	add_theme_support( "wp-block-styles" );
	add_theme_support( "responsive-embeds" );
	add_theme_support( "align-wide" );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	// Add theme support for Custom Logo.
	// Custom logo.
	$logo_width  = 300;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if ( get_theme_mod( 'retina_logo', false ) ) {
		$logo_width  = floor( $logo_width * 2 );
		$logo_height = floor( $logo_height * 2 );
	}

	$args = array(
		'height'      => $logo_height,
		'width'       => $logo_width,
		'flex-height' => true,
		'flex-width'  => true,
	);

	add_theme_support('custom-logo', $args);

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'videoshare' ),
		'footer' => esc_html__( 'Footer Menu', 'videoshare' ),	
		'mobile' => esc_html__( 'Mobile Menu', 'videoshare' ),						
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'videoshare_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	$editor_stylesheet_path = './assets/css/editor-style.css';

	// Enqueue editor styles.
	add_editor_style( $editor_stylesheet_path );  

}
endif;

add_action( 'after_setup_theme', 'videoshare_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 */
// Set content-width.
global $content_width;

if ( ! isset( $content_width ) ) {
	$content_width = 858;
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function videoshare_sidebar_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'videoshare' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'videoshare' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Home Content', 'videoshare' ),
		'id'            => 'home',
		'description'   => esc_html__( 'Only add the "Home Content", "Image" and "Custom HTML" widgets here.', 'videoshare' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );	

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Columns', 'videoshare' ),
		'id'            => 'footer',
		'description'   => esc_html__( '4 Columns widget area.', 'videoshare' ),
		'before_widget' => '<div id="%1$s" class="widget footer-column ht_grid_1_4 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	

}
add_action( 'widgets_init', 'videoshare_sidebar_init' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * SVG Icons.
 */
require get_template_directory() . '/inc/classes/class-videoshare-svg-icons.php';

/**
 * Menu Walker.
 */
require get_template_directory() . '/inc/classes/class-videoshare-walker-page.php';

// Block Patterns.
require get_template_directory() . '/inc/block-patterns.php';

// Block Styles.
require get_template_directory() . '/inc/block-styles.php';

/**
 * Load about page.
 */
require get_template_directory() . '/inc/about.php';

/**
 * Webfonts Loader.
 */
require get_template_directory() . '/inc/wptt-webfont-loader.php';

/**
 * Enqueues scripts and styles.
 */
function videoshare_scripts() {

    // load jquery if it isn't

    wp_enqueue_script('jquery');

	//  Enqueues Javascripts
	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/assets/js/superfish.js', array(), '', true );
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/assets/js/html5.js', array(), '', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.js', array(), '', true ); 
    wp_enqueue_script( 'videoshare-index', get_template_directory_uri() . '/assets/js/index.js', array(), '20220611', true );     
	wp_enqueue_script( 'videoshare-custom', get_template_directory_uri() . '/assets/js/jquery.custom.js', array(), '20220611', true );	

    // Enqueues CSS styles
    wp_enqueue_style( 'roboto', wptt_get_webfont_url( 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap' ), array(), '1.0' );
    wp_enqueue_style( 'videoshare-style', get_stylesheet_uri(), array(), '20220611' );   
	wp_enqueue_style( 'font-awesome-style',   get_template_directory_uri() . '/assets/css/font-awesome.css', array(), '20230701' );       	    
	wp_enqueue_style( 'videoshare-responsive-style',   get_template_directory_uri() . '/responsive.css', array(), '20220611' );       
    wp_enqueue_style( 'genericons-style',   get_template_directory_uri() . '/genericons/genericons.css' );
	
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }    
}
add_action( 'wp_enqueue_scripts', 'videoshare_scripts' );

/**
 * Post Thumbnails.
 */
if ( function_exists( 'add_theme_support' ) ) { 
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 300, 300, true ); // default Post Thumbnail dimensions (cropped)
    add_image_size( 'videoshare_post_thumb', 480, 270, true );
}

/**
 * Registers custom widgets.
 */
function videoshare_widgets_init() {

	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-popular.php';
	register_widget( 'VideoShare_Most_Commented_Widget' );		

	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-recent.php';
	register_widget( 'VideoShare_Recent_Widget' );		

	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-random.php';
	register_widget( 'VideoShare_Random_Widget' );			

	require trailingslashit( get_template_directory() ) . 'inc/widgets/widget-home-content.php';
	register_widget( 'VideoShare_Home_Content_Widget' );	
																			
}
add_action( 'widgets_init', 'videoshare_widgets_init' );





