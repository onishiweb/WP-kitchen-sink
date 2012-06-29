<?php
/**
 * One_starter functions and definitions
 *
 * @package One_starter
 * @since One_starter 1.1
 */

if ( ! function_exists( 'oneltd_setup' ) ):

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 */
	function oneltd_setup() {

		/**
		 * Custom template tags for this theme.
		 */
		require( get_template_directory() . '/inc/template-tags.php' );

		/**
		 * Custom Theme Options (to appear in wordpress backend if needed)
		 */
		// require( get_template_directory() . '/inc/theme-options.php' );


		/**
		 * Theme supports: Feed links in head, post formats (aside/image/gallery), post thumbnails...
		 */
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery' ) );
		add_theme_support( 'post-thumbnails' );

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'primary' => __( 'Main Navigation', 'oneltd' ),
		) );

		/**
		 * Include category IDs in body_class and post_class
		 */
		function category_id_class($classes) {
			global $post;
			foreach((get_the_category($post->ID)) as $category)
				$classes [] = 'cat-' . $category->cat_ID . '-id';
				return $classes;
		}

		add_filter('post_class', 'category_id_class');
		add_filter('body_class', 'category_id_class');


		/**
		 * New excerpt length and custom after excerpt!

		function new_excerpt_length($length) {
			return 60;
		}
		add_filter('excerpt_length', 'new_excerpt_length');
		// ... after excerpt
		function custom_excerpt_more( $more ) {
			return '...';
		}
		add_filter( 'excerpt_more', 'custom_excerpt_more' );
		 */

		/**
		 * Remove the crap from the wp_head() function
		 */
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'index_rel_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'start_post_rel_link', 10, 0);
		remove_action('wp_head', 'parent_post_rel_link', 10, 0);
		remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);


		/** WP in the back-end **/

		/**
		 * Disable the Admin bar (courtesy of Paul Davis - Slim Starkers)
		 */
	    add_filter('show_admin_bar', '__return_false');

		/**
		 * Remove any unwanted menus from the wordpress sidebar
		 */
		function remove_menus ()
		{
			global $menu;
			// remove the Links and Comments menu items as default
			$restricted = array( __('Links'), __('Comments') );
			end ($menu);
			while (prev($menu))
			{
				$value = explode(' ',$menu[key($menu)][0]);
				if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
			}
		}
		add_action('admin_menu', 'remove_menus');

		/**
		 * Remove any unwanted wordpress dashboard boxes
		 */
		function disable_default_dashboard_widgets() {

			// remove_meta_box('dashboard_right_now', 'dashboard', 'core');
			remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
			remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
			remove_meta_box('dashboard_plugins', 'dashboard', 'core');
			// AO: This one could be useful though...
			// remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
			// remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
			// remove_meta_box('dashboard_primary', 'dashboard', 'core');
			// remove_meta_box('dashboard_secondary', 'dashboard', 'core');
		}
		add_action('admin_menu', 'disable_default_dashboard_widgets');

		/**
		 * Hide the upgrade notices in Wordpress (especially handy for people like Career Innovation etc etc
		 */
		if (!current_user_can('edit_users')) {
			add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
			add_filter('pre_option_update_core', create_function('$a', "return null;"));
		}

		/**
		 * Prevent users from being able to use the full content editor in WP, allow only the code view
		 * - handy when you need to add in custom html to the post (which actually shouldn't be done)
		add_filter ( 'user_can_richedit' , create_function ( '$a' , 'return false;' ) , 50 );
		*/

		/** Add featured image to feeds
	     * http://app.kodery.com/s/1314 (courtesy of Paul Davis)
	    */
	    function insertThumbnailRSS($content) {
	        global $post;
	        if ( has_post_thumbnail( $post->ID ) ){
	            $content = '' . get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'alt' => get_the_title(), 'title' => get_the_title(), 'style' => 'float:right;' ) ) . '' . $content;
	        }
	        return $content;
	    }
	    add_filter('the_excerpt_rss', 'insertThumbnailRSS');
	    add_filter('the_content_feed', 'insertThumbnailRSS');

	}

endif; // oneltd_setup
/**
 * Tell WordPress to run toolbox_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'oneltd_setup' );

/*
 * AO: Is template - check whether the current page is using a certain template or retreive the template name
 *
 */
function oneltd_is_template( $name = false ) {
	global $post;

	$template_file = get_post_meta($post->ID,'_wp_page_template',TRUE);

	// check for a template type
	if( $name ):
		if ($template_file == $name ):
			return true;
		else:
			return false;
		endif;
	else:
		return $template_file;
	endif;
}

/*
 * AO: Search form - simple search form which can be overwritten (include for it is commented by default.
 *
 */
function oneltd_search_form( $form ) {

    $form = '<form role="search" method="get" action="/">
				<label for="search">Search</label>
				<input type="text" id="search" name="s" />
				<input type="submit" id="search-sub" value="Search" />
			</form>';
	return $form;
}
add_filter( 'get_search_form', 'oneltd_search_form' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since oneltd 1.0
 */
function oneltd_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'oneltd' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'oneltd_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function oneltd_scripts() {
	global $post;

	/**
	 * Better jQuery inclusion
	 */
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false);
		wp_enqueue_script('jquery');
	}


	// work out if there is a codekit concatenated/minified version. If so, include that, otherwise, include core.js. If no javascript, don't include anything!
	$javascript_file = (file_exists(get_stylesheet_directory() . '/javascript/core-ck.js')) ? 'core-ck.js'
				: ((file_exists(get_stylesheet_directory() . '/javascript/core.js')) ? 'core.js' : false);

	if ($javascript_file)
	{
		// get modified time for smart caching
		$modified_time = filemtime(get_stylesheet_directory()."/javascript/$javascript_file");
		wp_enqueue_script( 'core', get_template_directory_uri() . "/javascript/$javascript_file?" . $modified_time, 'jquery', '1', true );
	}


	// Can query for different types of pages/templates (using oneltd_is_template('TEMPLATE_NAME'); ) and include scripts when needed...
	// Especially handy for scrolling banners on the homepage etc
	/*
	if ( is_front_page() ) {
		// enqueue jCarousel or similar!
	}
	*/
}
add_action( 'wp_enqueue_scripts', 'oneltd_scripts' );

?>
