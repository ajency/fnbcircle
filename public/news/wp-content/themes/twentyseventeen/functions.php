<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */



/* REMOVE EXTRA SLASHES ADDED IN REQUEDT RESPONSE:-*/
//if ( get_magic_quotes_gpc() ) {
    $_POST      = array_map( 'stripslashes_deep', $_POST );
    $_GET       = array_map( 'stripslashes_deep', $_GET );
    $_COOKIE    = array_map( 'stripslashes_deep', $_COOKIE );
    $_REQUEST   = array_map( 'stripslashes_deep', $_REQUEST );
//}
    

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyseventeen' );

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

	add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );

	add_image_size( 'twentyseventeen-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'twentyseventeen' ),
		'social' => __( 'Social Links Menu', 'twentyseventeen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', twentyseventeen_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name' => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	/**
	 * Filters Twenty Seventeen array of starter content.
	 *
	 * @since Twenty Seventeen 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'twentyseventeen_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'twentyseventeen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( twentyseventeen_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );
}
add_action( 'template_redirect', 'twentyseventeen_content_width', 0 );

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'twentyseventeen' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentyseventeen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'twentyseventeen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'twentyseventeen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'twentyseventeen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyseventeen_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link"  target ="_blank"  >%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentyseventeen_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyseventeen_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'twentyseventeen_pingback_header' );

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo twentyseventeen_custom_colors_css(); ?>
	</style>
<?php }
add_action( 'wp_head', 'twentyseventeen_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'twentyseventeen-style' ), '1.0' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'twentyseventeen-style' ), '1.0' );
		wp_style_add_data( 'twentyseventeen-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentyseventeen-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'twentyseventeen-style' ), '1.0' );
	wp_style_add_data( 'twentyseventeen-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentyseventeen-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$twentyseventeen_l10n = array(
		'quote'          => twentyseventeen_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'twentyseventeen-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
		$twentyseventeen_l10n['expand']         = __( 'Expand child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['collapse']       = __( 'Collapse child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['icon']           = twentyseventeen_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'twentyseventeen-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentyseventeen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'twentyseventeen_front_page_template' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

function get_breadcrumb() {
    echo '<a href="'.home_url().'" rel="nofollow">Home</a>';
    if(is_author()){

    	$auth_link = custom_author_post_link("","'s Posts");
    	 echo "&nbsp;&nbsp;/&nbsp;&nbsp;";
        /*the_author_posts_link();
        echo"'s Posts";*/
        echo $auth_link;
           

    }
    else if(is_archive()){


    	$category = get_queried_object();

    	$category_link = get_category_link( $category->cat_ID );
    	echo "&nbsp;&nbsp;/&nbsp;&nbsp; ";
    	echo "<a href='".$category_link."'>News in ".$category->name."</a>";

        //the_category(' &bull; ');
           

    }
    else if (is_category() || is_single()) {
        /* //commented on client request the category display 
        echo "&nbsp;&nbsp;/&nbsp;&nbsp;";
        the_category(' &bull; ');*/
            if (is_single()) {
                echo " &nbsp;&nbsp;/&nbsp;&nbsp; ";
                the_title();
            }
    } elseif (is_page()) {
        echo "&nbsp;&nbsp;/;&nbsp;&nbsp;";
        echo the_title();
    } elseif (is_search()) {
        echo "&nbsp;&nbsp;/;&nbsp;&nbsp;Search Results for... ";
        echo '"<em>';
        echo the_search_query();
        echo '</em>"';
    }
}


function custom_excerpt_length( $length ) {
        return 20;
    }
    add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

 
 


function fnbcircleWpScripts(){

	global $post;
 

	$queried_object = get_queried_object();
	 
	$category_slug = "pune";

	if(isset($queried_object->taxonomy)){

		if($queried_object->taxonomy=="category"){
			$category_slug = $queried_object->slug;
		}
	}



	/*echo "<pre>";
	print_r($queried_object);

	die();*/
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), null );	
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(),null);
	// wp_enqueue_style('lara-styles', get_template_directory_uri() . '/assets/css/lara-styles.css', array(),null);


	wp_enqueue_script('wpnews', get_template_directory_uri() . '/assets/js/news.js', array('jquery'), true, true);
	wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), true, true);	
	wp_localize_script('wpnews', 'LARAURL', get_laravel_site_url());
	wp_localize_script('wpnews', 'page_category', $category_slug);
	wp_localize_script('wpnews', 'ajax_url', admin_url( 'admin-ajax.php' ));
	wp_localize_script('wpnews', 'SITEURL', esc_url( home_url( '/' ) ));


	/* Load More Scripts*/
	global $wp_query;
	wp_register_script( 'my_loadmore', get_template_directory_uri() . '/assets/js/myloadmore.js', array('jquery') );	 
	// now the most interesting part
	// we have to pass parameters to myloadmore.js script but we can get the parameters values only in PHP
	// you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
	$cust_load_more_args = array(	'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
									'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
									'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
									'max_page' => $wp_query->max_num_pages
								);
	$cust_load_more_args['featurednews'] ='no';
 
 	if(isset($post)){
 		if($post->post_name=="featured-news"){
			$cust_load_more_args['featurednews'] ='yes';
		}	
 	}
	

	wp_localize_script( 'my_loadmore', 'aj_loadmore_params', $cust_load_more_args ); 
 	wp_enqueue_script( 'my_loadmore' );


 	

	
}
add_action('wp_enqueue_scripts', 'fnbcircleWpScripts', 100);


function misha_loadmore_ajax_handler(){
 
	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
	$args['show_pagination'] = false;
	$addtitional_args['featured'] = $_POST['featured'];
 

 
 	$html = get_recent_news_by_city($args,$addtitional_args);
			echo $html;
	/*
	// it is always better to use WP_Query but not here
	query_posts( $args );	
 
	if( have_posts() ) :
 
		// run the loop
		while( have_posts() ): the_post();
 
			// look into your theme code how the posts are inserted, but you can use your own HTML of course
			// do you remember? - my example is adapted for Twenty Seventeen theme
			/*get_template_part( 'template-parts/post/content', get_post_format() );* /
			
			// for the test purposes comment the line above and uncomment the below one
			// the_title();
 
 
		endwhile;
 
	endif;*/
	die; // here we exit the script and even no wp_reset_query() required!
}
 
 
 
add_action('wp_ajax_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'misha_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}


 
function wpdocs_after_setup_theme() {
    add_theme_support( 'html5', array( 'search-form' ) );
}
add_action( 'after_setup_theme', 'wpdocs_after_setup_theme' );
 





require_once("inc/laravel/lara-libs.php");

function search_by_cat(){
    global $wp_query;
    if (is_search()) {
    	if(isset($_GET['cat'])){
    		$cat = intval($_GET['cat']);
    		$cat = ($cat > 0) ? $cat : '';
    		$wp_query->query_vars['cat'] = $cat;	
    	}
        
    }
}
add_action('pre_get_posts', 'search_by_cat');


 



function remove_page_from_query_string($query_string){ 

	if(isset($query_string['name'])){
		if ($query_string['name'] == 'page' && isset($query_string['page'])) {
		    unset($query_string['name']);
		    // 'page' in the query_string looks like '/2', so i'm spliting it out
		    //list($delim, $page_index) = explode('/', $query_string['page']);        
		    $query_string['paged'] = $query_string['page'];
		}    	
	}
    
    
    return $query_string;
}
add_filter('request', 'remove_page_from_query_string');

// following are code adapted from Custom Post Type Category Pagination Fix by jdantzer
function fix_category_pagination($qs){
	if(isset($qs['category_name']) && isset($qs['paged'])){
		$qs['post_type'] = get_post_types($args = array(
			'public'   => true,
			'_builtin' => false
		));
		array_push($qs['post_type'],'post');
	}
	return $qs;
}
add_filter('request', 'fix_category_pagination');
 



/**
 * Limit number of posts per page
 *
 * @param      <type>  $query  The query
 */
function my_post_queries( $query ) {
  // do not alter the query on wp-admin pages and only alter it if it's the main query
  if (!is_admin() && $query->is_main_query()){

    // alter the query for the home and category pages 

    if(is_home()){
      $query->set('posts_per_page', 3);
    }

    if(is_category()){
      $query->set('posts_per_page', 3);
    }

  }
}
//add_action( 'pre_get_posts', 'my_post_queries' );



function fix_slash( $string, $type )
{
	global $wp_rewrite;
	if ( $wp_rewrite->use_trailing_slashes == false )
	{
	    if ( $type != 'single' && $type != 'category' )
	        return trailingslashit( $string );

	    if ( $type == 'single' && ( strpos( $string, '.html/' ) !== false ) )
	        return trailingslashit( $string );

	    if ( $type == 'category' && ( strpos( $string, 'category' ) !== false ) )
	    {
	        $aa_g = str_replace( "/category/", "/", $string );
	        return trailingslashit( $aa_g );
	    }
	    if ( $type == 'category' )
	        return trailingslashit( $string );
	}
	return $string;
}

//add_filter( 'user_trailingslashit', 'fix_slash', 55, 2 );




function get_laravel_site_url(){

	if(defined('LARAVELURL') ){
        return LARAVELURL;
    }
    else{
        $laravel_site_url = "http://".$_SERVER['HTTP_HOST'];
        return $laravel_site_url;
    }

}




/* Wp-Admin  CUSTOM */


/* ##############################Add custom menu to Sync tags########################*/
function my_plugin_function(){

	echo '<h1>Import tags from Main site</h1>
		<br/><div id="tab_sync_message" style="display:none" class="updated notice notice-success is-dismissible"><p>Post updated.  </p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div><br/>	';
	echo "	<form>
				<label>Click on button below, to Syn the Jobs & Business listings tags from main site to news </label>
				<br/><br/><input type='button' name='btn_import_tags'  id='btn_import_tags' value ='Sync' class='button button-primary button-large'  />
			</form>   

			<input type='hidden' name='laraurl' id='laraurl' value='".get_laravel_site_url()."' />
			";

}


function tags_import_menu() {
	add_posts_page('Import Tags', 'Import tags', 'read', 'import-tags', 'my_plugin_function');
}
add_action('admin_menu', 'tags_import_menu');




add_action('admin_init', function(){ 
    //if($GLOBALS['pagenow']=='post.php'){
        add_action('admin_print_scripts', 'my_admin_scripts');
        //add_action('admin_print_styles',  'my_admin_styles');
    //}
});

function my_admin_scripts() { 

	wp_enqueue_script('cust_admin_script', get_template_directory_uri() . '/assets/js/custom_admin_script.js', array('jquery'), true, true);
	//wp_enqueue_script('jquery');    wp_enqueue_script('media-upload');   wp_enqueue_script('thickbox'); 
}
/* End Add custom menu to Sync tags*/

/* Modify Tags Display on post edit page*/
function example_wpadmin_show_all_tags( $args ) {
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_POST['action'] ) && $_POST['action'] === 'get-tagcloud' )
        unset( $args['number'] );
        $args['hide_empty'] = 0;
    return $args;
}
add_filter( 'get_terms_args', 'example_wpadmin_show_all_tags' );
function example_wpadmin_custom_css() {
    echo '<script>
        jQuery(window).load(function() {
            jQuery("body.wp-admin #tagsdiv-post_tag #link-post_tag").trigger("click");
            jQuery("body.wp-admin #tagsdiv-post_tag #link-post_tag").hide();
        });
    </script>';
    echo '<style>
        /*body.wp-admin #tagsdiv-post_tag #link-post_tag{visibility:hidden;}*/
       /* body.wp-admin #tagsdiv-post_tag #post_tag .jaxtag{display:none;} //this line hides the manual add tag box - delete if not required */
        body.wp-admin #tagsdiv-post_tag #tagcloud-post_tag a{display:block;} //this line puts each displayed tag on a new line - delete if not required

        body.wp-admin #tagsdiv-post_tag .hide-if-no-js{ overflow:auto; max-height:250px;}
    </style>';
}
add_action('admin_head', 'example_wpadmin_custom_css');
/* End Modify Tags Display on post edit page*/


/* ############################## End Add custom menu to Sync tags########################*/


/* Wp-Admin  CUSTOM */









/**
 * Modify the "must_log_in" string of the comment form.
 *
 * @see http://wordpress.stackexchange.com/a/170492/26350
 */
add_filter( 'comment_form_defaults', function( $fields ) {
    $fields['must_log_in'] = sprintf( 
        __( '<p class="must-log-in">
                 You must <a href="#" class="login" data-toggle="modal" data-target="#login-modal">Login</a> to post a comment.</p>' 
        ),
        wp_registration_url(),
        wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )   
    );
    return $fields;
});





/* category and tags archieve page change the title */
function custom_category_tags_title($title)
{
	if( is_category()){
		$title = sprintf( __( 'News in %s' ), single_cat_title( '', false ) );
	}
	else if(is_tag()){
		$title = sprintf( __( 'News in %s' ), single_tag_title( '', false ) );
	}
	

	return $title;
}

add_filter('get_the_archive_title', 'custom_category_tags_title', 10, 1);





function get_featured_news_by_city11($city){

		$city =$_POST['city'];
		$news = array();

	    $args = array(
	        'offset'      => 0,
	        'orderby'     => 'date',
	        'order'       => 'DESC',
	        'post_type'   => 'post',
	        'post_status' => 'publish',
	        'meta_key'   => '_is_ns_featured_post',
	  		'meta_value' => 'yes',
	  		'category_name'=>$city,
	  		'posts_per_page'=>6
	    ); 


		
	     
	    $posts_array = get_posts($args);

	    $html = "";


	    if(count($posts_array)>0){
	    	foreach ($posts_array as $post) {

	    		$permalink = get_permalink($post->ID);

	    		$author_link = get_author_posts_url( $post->post_author );

	    		$author_data = get_user_by( 'ID', $post->post_author );
				// Get user display name
				$author_display_name = $author_data->display_name;



	    		$display_date = date('F jS Y',strtotime($post->post_date) );
	    		$post_excerpt = get_the_excerpt($post->ID);

	    		$excerpt = empty($post->post_excerpt) ? wp_trim_words($post->post_content, 20, '...') : $post->post_excerpt   ;


	    		$category = get_category_by_slug($city);

	    		 

    		    // Get the URL of this category
    		    $category_link = get_category_link( $category->cat_ID );


	    		$html.='<div class="featured-post">
	    			<div class="border-layout">';
	    		$backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );


	    		if($backgroundImg!=false && $backgroundImg!=""){
	    			$style_avatar = 'style="background-image:url('.$backgroundImg[0].')"';

	    		} 
	    		else{
	    			$style_avatar ="";
	    		}
	    		 


	    		$html.='<div class="featured-image"'.$style_avatar.' ></div>
	    		  <div class="featured-content">
	    		    <h5 class="font-weight-bold"><a href="'.$permalink.'"  target ="_blank"  >'.$post->post_title.'</a></h5>'.$excerpt;
	    		    //<?php the_excerpt(6);  
	    		$html.='<div class="featured-meta">
	    		<img src="'.site_url().'/wp-content/themes/twentyseventeen/assets/images/abstract-user.png"/>
	    		By <a href="'.$author_link.'">'.$author_display_name.'</a><br> on '.$display_date.'  ';
	    		/*$html.=' in <a href="'.$category_link.'">'.$category->cat_name.'</a> ';  // commented by client request*/

	    		$html.='</div>   
	    		   </div>
	    		   <div class="clear"></div>
	    		</div>
	    		</div>';

	    		
	    	}

	    	if(count(count($posts_array)>4)){
	    		$html.="<a href='#'>View more</a>";
	    	}
	    }
	    else{
	    	$html =  "<h3>No featured News in the selected city</h3>";
	    }

	    wp_send_json(array('html'=>$html));

	    //echo json_encode(array('html'=>$html));

		die;

}

add_action('wp_ajax_nopriv_get_featured_news_by_city', 'get_featured_news_by_city',10,1);
add_action('wp_ajax_get_featured_news_by_city', 'get_featured_news_by_city',10,1);


 
function get_featured_news_by_city(){


	$custom_query_args = array(
	  'post_type'  => 'post',
	  'meta_key'   => '_is_ns_featured_post',
	  'meta_value' => 'yes'
	  
	  );
	if(isset($_POST['city'])){
		$city =$_POST['city'];
		$custom_query_args['category_name'] = $city;
	}

	

	// Get current page and append to custom query parameters array
	$custom_query_args['paged'] = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$custom_query = new WP_Query( $custom_query_args );  
	 
	

	// Pagination fix
	global $wp_query;
	$temp_query = $wp_query;
	$wp_query   = NULL;
	$wp_query   = $custom_query;
	  if ( $custom_query->have_posts() ) :  

	$html='  <!-- the loop -->';
	  while ( $custom_query->have_posts() ) : $custom_query->the_post();  


	$html.='<div class="featured-post">
		<div class="border-layout">';
	 $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' ); 


	$post_categories = get_the_category();
	$category_display ="";
	$cnt_cat =0;
	foreach ($post_categories as $post_cat) {

		if($post_cat->slug!=="uncategorized"){
			if($cnt_cat>0){
				$category_display.=', ';
			}
			$category_display.='<a href="">'.$post_cat->cat_name.'</a>';
			
			$cnt_cat++;
		}

	}

	 if($backgroundImg!=false && $backgroundImg!=""){
	    			$style_avatar = 'style="background-image:url(\''.$backgroundImg[0].'\')"';

	    		} 
	    		else{
	    			$style_avatar ="";
	    		}
	 
	 


	    
	   	  $current_featured_tags_html =""; 
	   	  $current_featured_tags = [];
	   	  $current_featured_tag_html_items = [];

	   	  $featured_posttags = get_the_tags();	  
	    
	 	  	if($featured_posttags){
	 	    
	 	    foreach($featured_posttags as $tag) {	    	
	 	      	$current_featured_tag_html_items[]= "<span title='".$tag->name."'><i class='fa fa-tag text-lighter' aria-hidden='true'></i>".$tag->name."</span> "; 	   
	 	      	$current_featured_tags[] =   $tag->name;  
	 	    }
	 	    
	 	    $current_featured_post_tags_container_title = implode(',',$current_featured_tags);
	 	    $current_featured_tags_html="<div class='post_tags ellipsis text-color' title='".$current_featured_post_tags_container_title."' >";
	 	    $current_featured_tags_html.= implode('',$current_featured_tag_html_items);
	 	    $current_featured_tags_html.="</div>";
	 	  }
	 


	  


	 $html.=' <div class="featured-image" '.$style_avatar.'></div>
	  <div class="featured-content">
	    <h5 class="font-weight-bold"><a href="'.get_permalink().'">'.get_the_title().'</a></h5>
	    '.get_the_excerpt(6).$current_featured_tags_html.'
	<div class="featured-meta">
	<img src="'.site_url().'/wp-content/themes/twentyseventeen/assets/images/abstract-user.png" />
	By '.get_the_author_posts_link().'<br> on '.get_the_time('F jS, Y').'  ';
	/* $html.=' in '.$category_display; //commented on client request */
	$html.='</div>   
	   </div>
	   <div class="clear"></div>
	</div>
	</div>';

	 
	   endwhile; 
	  $html.='<!-- end of the loop -->

	  <!-- pagination here 
	   
	  // Custom query loop pagination-->'.
	  get_previous_posts_link( 'Older Posts' ).
	  get_next_posts_link( 'Newer Posts', $custom_query->max_num_pages );
	  

	else:  
	  $html= '<span class="no-posts-msg"><i class="fa fa-frown-o" aria-hidden="true"></i> <h6>Sorry, no featured news matched your criteria.</h6></span>';
	endif; 
	wp_send_json(array('html'=>$html));

	     //echo json_encode(array('html'=>$html));

	 	die;
}

function get_recent_news_by_city($args=array(),$additional_args = array()){ 


 

	$paged = isset($_POST['paged'])?$_POST['paged']:1;
	if(isset($additional_args['paged'])){
		$paged = $additional_args['paged'];
	}
	
	$query = array( 'posts_per_page' => 10, 'order' => 'DESC' , 'paged' =>$paged, 'orderby'=>'date','post_status'      => 'publish'); 

	if(isset($_POST['city'])){
		$city = $_POST['city'];
		$query['category_name']=$city;
	}


	$query = array_merge($query,$args);

	if(isset($additional_args['featured'])){
		if($additional_args['featured']=='yes'){

			 $query['meta_key']   =  '_is_ns_featured_post';			 
			 $query['meta_value']   =  'yes'; 
		}
	}
	 

 
 
	$wp_query = new WP_Query($query);

	 

	if ( $wp_query->have_posts() ) {
		while ( $wp_query->have_posts() ) : $wp_query->the_post();  
	//while ( have_posts() ) : the_post(); 
	$featured_img_id ="";
	 $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' ); 
	  if($backgroundImg!=false && $backgroundImg!=""){
	     			$style_avatar = 'style="background-image:url(\''.$backgroundImg[0].'\')"';
	     			$featured_img_id =' id="featured-img" ';
 		} 
 		else{
 			$style_avatar ="";
 		}  
	$html.='<li>
	    
	      <div class="list-post" '.$featured_img_id.'>';
	  $post_categories = get_the_category();
	  $category_display ="";
	  $cnt_cat =0;
	  foreach ($post_categories as $post_cat) {

  		if($post_cat->slug!=="uncategorized"){
  			if($cnt_cat>0){
  				$category_display.=', ';	
  			}
  			$category_display.='<a href="">'.$post_cat->cat_name.'</a>';	
  			$cnt_cat ++;  	
  		} 
	  }

	 
  	  $current_recent_tags_html =""; 
  	  $current_recent_tags = [];

  	  $recent_posttags = get_the_tags();	  
   
	  	if($recent_posttags){
	    
	    foreach($recent_posttags as $tag) {	    	
	      	$current_recent_tag_html_items[]= "<span title='".$tag->name."'><i class='fa fa-tag text-lighter' aria-hidden='true'></i>".$tag->name."</span> "; 	   
	      	$current_recent_tags[] =   $tag->name;  
	    }
	    
	    $current_recent_post_tags_container_title = implode(',',$current_recent_tags);
	    $current_recent_tags_html="<div class='post_tags ellipsis text-color' title='".$current_recent_post_tags_container_title."' >";
	    $current_recent_tags_html.= implode('',$current_recent_tag_html_items);
	    $current_recent_tags_html.="</div>";
	  }
 





	  $html.='<div class="featured-content">
	  <a href="'.get_permalink().'" title="Link to '.get_the_title().'"  target ="_blank" >  <h5>'.get_the_title().'</h5> </a>
	    '.get_the_excerpt(15).$current_recent_tags_html.'
	<div class="featured-meta">
		<img src="'.site_url().'/wp-content/themes/twentyseventeen/assets/images/abstract-user.png" />';

	 $html.='By '.get_the_author_posts_link().'<br> on '.get_the_time('F jS, Y').'  ';
	 /* $html.='in '.$category_display; //commented on client request   */ 
	$html.='</div>   
	   </div>
	   <div class="featured-image" '.$style_avatar.'></div>
	   <div class="clear"></div>
	</div>
	   
	</li>';  
	endwhile; 
	/*$html.=$wp_query->get_the_posts_pagination( array(
					'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
				) );*/
	/* $html.= paginate_links(array(
     'base' => preg_replace('/\?.* /', '/', get_pagenum_link(1)) . '%_%',
     'current' => max(1, get_query_var('paged')),
     'format' => 'page/%#%',
     'total' => $wp_query->max_num_pages,
     'add_args' => array(
         's' => get_query_var('s'),
         'post_type' => get_query_var('post_type'),
    	 )
 	));*/
 	$show_pagination = true;

 	if(isset($args['show_pagination'])){			
 		$show_pagination = $args['show_pagination'];	
 	}
 	if($show_pagination!=false){
 		$html.=vb_ajax_pager($wp_query,$paged,'home_recent_pagination');	
 	}
 	
 	
 	}// end if ( $wp_query->have_posts() ) {
	else{ 
		$html.='<span class="no-posts-msg"><i class="fa fa-frown-o" aria-hidden="true"></i> <h6>Sorry, no recent news matched your criteria.</h6></span>';
	}
	


	wp_send_json(array('html'=>$html));

	     //echo json_encode(array('html'=>$html));

	 	die;
}
add_action('wp_ajax_nopriv_get_recent_news_by_city', 'get_recent_news_by_city');
add_action('wp_ajax_get_recent_news_by_city', 'get_recent_news_by_city');




function vb_ajax_pager( $query = null, $paged = 1, $custom_pagination_container_class='' ) {
    if (!$query)
        return;
    $paginate = paginate_links([
        'base'      => '%_%',
        'type'      => 'array',
        'total'     => $query->max_num_pages,
        'format'    => '#page=%#%',
        'current'   => max( 1, $paged ),
        'prev_text' => 'Prev',
        'next_text' => 'Next'
    ]);

    $html ='';
    if ($query->max_num_pages > 1) : 
        $html.='<ul class="pagination '.$custom_pagination_container_class.'">';
            foreach ( $paginate as $page ) :
                $html.='<li>'.$page.'</li>';
            endforeach;
        $html.='</ul>';
     endif;

     return $html;
}

function get_recent_news_by_city11($city){


	$city =$_POST['city'];
	$news = array();

	$args = array(
		'numberposts' => 10,
		'offset' => 0,		 
		'orderby' => 'post_date',
		'order' => 'DESC',		
		'post_type' => 'post',
		'post_status' => 'publish',
		'suppress_filters' => true,
		'category_name'=>$city,
	  	'posts_per_page'=>6
	);

	$recent_posts = wp_get_recent_posts( $args );

	$html ="";



	if(count($recent_posts)>0){


		foreach ($recent_posts as $post) {

		 
var_dump($post);

    		$permalink = get_permalink($post->ID);

    		$author_link = get_author_posts_url( $post->post_author );

    		$author_data = get_user_by( 'ID', $post->post_author );
			// Get user display name
			$author_display_name = $author_data->display_name;



    		$display_date = date('F jS Y',strtotime($post->post_date) );

    		$excerpt = empty($post->post_excerpt) ? wp_trim_words($post->post_content, 25, '...') : $post->post_excerpt   ;


    		$category = get_category_by_slug($city);

    		 

		    // Get the URL of this category
		    $category_link = get_category_link( $category->cat_ID );



			$html.='<li>
			    
					      <div class="list-post">';
			$backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); 

			if($backgroundImg!=false && $backgroundImg!=""){
	    			$style_avatar = 'style="background-image:url('.$backgroundImg[0].')"';

	    		} 
	    		else{
	    			$style_avatar ="";
	    		}
	    		 


					          
					  
			$html.='<div class="featured-content">
					  <a href="'.$permalink.'" title="Link to '.$post->post_title.'"  target ="_blank" >  <h5>'.$post->post_title.'</h5> </a>
					    '.$excerpt.'
					<div class="featured-meta">
						<img src="'.site_url().'./wp-content/themes/twentyseventeen/assets/images/abstract-user.png" />

					By <a href="'.$author_link.'">'.$author_display_name.'</a><br> on '.$display_date.'  in  <a href="'.$category_link.'">'.$category->cat_name.'</a> 
					</div>   
					   </div>
					   <div class="featured-image" '.$style_avatar.'></div>
					   <div class="clear"></div>
					</div>
					   
					</li>';
		}
		
	}
	else{
		$html="<span class='no-posts-msg'><h3>No recent posts for the selected city</h3></span>";
	}

	     wp_send_json(array('html'=>$html));

	     //echo json_encode(array('html'=>$html));

	 	die;
 
}




 
function post_tag_permalink($permalink, $post_id, $leavename) {
    //if (strpos($permalink, '%rating%') === FALSE) return $permalink;
     
        // Get post
        $post = get_post($post_id);
        if (!$post) return $permalink;
 
        // Get taxonomy terms
        $terms = wp_get_object_terms($post->ID, 'post_tag');   
        if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0])) {
        	$taxonomy_slug = $terms[0]->slug;
        }
        else {
        	//$taxonomy_slug = 'not-rated';
        	return $permalink;
        }
 
    return str_replace('%rating%', $taxonomy_slug, $permalink);
}   
/*add_filter('post_link', 'post_tag_permalink', 10, 3);
add_filter('post_type_link', 'post_tag_permalink', 10, 3);*/


 
 /* End Rmove &#8211; from title*/
remove_filter( 'the_title' , 'wptexturize' );
remove_filter( 'the_content' , 'wptexturize' );
remove_filter( 'the_excerpt' , 'wptexturize' );
remove_filter( 'comment_text' , 'wptexturize' );
remove_filter( 'list_cats' , 'wptexturize' );
add_filter( 'run_wptexturize', '__return_false' ); //removes globally
/* End Remove &#8211; from title*/  
 



// Replaces the excerpt "Read More" text by a link
function new_excerpt_more($more) {
       global $post;
	return ' <a class="moretag" href="'. get_permalink($post->ID) . '"  target ="_blank"  >read more...</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');



function custom_author_post_link($link_pretext='',$link_posttext=''){
	global $authordata;
	if ( ! is_object( $authordata ) ) {
		return;
	} 
	$author_text = $link_pretext.get_the_author().$link_posttext;

	$link = sprintf( '<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
		/* translators: %s: author's display name */
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ),
		$author_text
	);

	return $link;
}


 
//Exclude pages from WordPress Search
if (!is_admin()) {
	function wpb_search_filter($query) {
	if ($query->is_search) {
	$query->set('post_type', 'post');
	}
	return $query;
	}
	add_filter('pre_get_posts','wpb_search_filter');
}





/*Remove Logged in as admin@ajency.in. Log out? from comment section*/
add_filter( 'comment_form_logged_in', '__return_empty_string' );



if ( ! function_exists( 't5_do_not_ask_for_comment_log_in' ) )
{
    add_filter( 'comment_reply_link', 't5_do_not_ask_for_comment_log_in' );

    /**
     * Replaces the log-in link with an empty string.
     *
     * @param  string $link
     * @return string
     */
    function t5_do_not_ask_for_comment_log_in( $link )
    {
        if ( empty ( $GLOBALS['user_ID'] ) && get_option( 'comment_registration' ) )
        {
            return '<div class="reply"><a rel="nofollow" class="comment-reply-login" href="javascript:void(0);"  data-toggle="modal" data-target="#login-modal" >Log in to Reply</a></div>';
        }

        return $link;
    }
}

/* REmove admin bar from front end */
add_filter('show_admin_bar', '__return_false');

/*Do not allow non-admins to access wordpress dashboard */
function no_mo_dashboard() {
  if (!current_user_can('manage_options') && $_SERVER['DOING_AJAX'] != '/wp-admin/admin-ajax.php') {
  wp_redirect(home_url()); exit;
  }
}
//add_action('admin_init', 'no_mo_dashboard');


//Display tags with link on sigle post page
function tags_after_single_post_content($content) {
  $posttags = get_the_tags();
  if ($posttags) {
    $array = [];
    foreach($posttags as $tag) {
      //$array[] = '<a href="/tag/' . $tag->slug . '/">' . $tag->name . '</a>';
       $array[] =  $tag->name;
    }
    $content .=  implode(', ', $array) . '<br>';
  }

  return $content;
}
//add_filter( 'the_content', 'tags_after_single_post_content' );



function get_tags_markup($posttags,$is_single=false){

	$current_tags_html =""; 
	$current_tags = [];
	$current_tag_html_items = [];

	//$posttags = get_the_tags($post->ID);	  

	if($posttags){

	foreach($posttags as $tag) {	    	
		$current_tag_html_items[]= "<span class='post-tags__child' title='".$tag->name."'><i class='fa fa-tag text-lighter' aria-hidden='true'></i>".$tag->name."</span> "; 	   
		$current_tags[] =   $tag->name;  
	}

	$current_post_tags_container_title = implode(',',$current_tags);
	if($is_single==true){
		$current_tags_html="<div class='post-tags text-color' title='".$current_post_tags_container_title."' >";
	}
	else{
		$current_tags_html="<div class='post-tags text-color' title='".$current_post_tags_container_title."' >";	
	}
	
	$current_tags_html.= implode('',$current_tag_html_items);
	$current_tags_html.="</div>";
	}

	return $current_tags_html;

}