<?php

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
		 * Theme supports: Feed links in head, post formats (aside/image/gallery), post thumbnails...
		 */
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery' ) );
		add_theme_support( 'post-thumbnails' );

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'main-navigation' => __( 'Main Navigation', 'oneltd' ),
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
		 * New excerpt length and after excerpt stuff!
		 */
		function new_excerpt_length($length) {
			return 60;
		}
		add_filter('excerpt_length', 'new_excerpt_length');
		
		// ... after excerpt
		function custom_excerpt_more( $more ) {
			return '...';
		}
		add_filter( 'excerpt_more', 'custom_excerpt_more' );
		
	
		/**
		 * Better jQuery inclusion
		 */
		if (!is_admin()) {
			wp_deregister_script('jquery');
			wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false);
			wp_enqueue_script('jquery');
		}
		
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
		 * Remove any unwanted menu's from the wordpress sidebar
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
		  
			remove_meta_box('dashboard_right_now', 'dashboard', 'core');  
			remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');  
			remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  
			remove_meta_box('dashboard_plugins', 'dashboard', 'core');
			// AO: This one could be useful though...
			// remove_meta_box('dashboard_quick_press', 'dashboard', 'core'); 
			remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');  
			remove_meta_box('dashboard_primary', 'dashboard', 'core');  
			remove_meta_box('dashboard_secondary', 'dashboard', 'core');  
		}  
		add_action('admin_menu', 'disable_default_dashboard_widgets');
		
		/**
		 * Hide the upgrade notices in Wordpress (especially handy for people like Career Innovation etc etc
		 */
		if (!current_user_can('edit_users')) {
			add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
			add_filter('pre_option_update_core', create_function('$a', "return null;"));
		}
		
	}

endif; // oneltd_setup

/**
 * Tell WordPress to run toolbox_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'oneltd_setup' );


/*
 * AO: Subnav function which will aim to find the highest parent and provide a subnav from that
 * or can be passed a nav menu name and it will display that... (With containing UL)
 *
 */
function get_subnav($nav_menu = "") 
{

	if($nav_menu == "")
	{
		$ancestors = get_post_ancestors( $post ); 
		$top = get_post(end($ancestors), "OBJECT");
		
		echo "<ul>";
		wp_list_pages('title_li=&link_before=<span></span>&child_of='.$top->ID);
		if( $top->ID == 4116 ):
		?><li><a href="/contact-us"><span></span>Contact us</a></li>
		<?php
		endif;
		echo "</ul>";
	}
	else
	{
		//get the nav menu based on the nav menu name received!
		wp_nav_menu("menu=".$nav_menu."&container=");
	}
}


/*
 * AO: Breadcrumbs function to echo out crumbs in LI's (With #breadcrumbs containing UL).
 *
 */
function get_breadcrumbs()
{
	global $post;

	$ancestors = get_post_ancestors( $post );
	$ancestors = array_reverse($ancestors);
	$ancestors[] = $post->ID;
	echo '<ul id="breadcrumbs">';
	
	if( is_home() ):
		echo '<li><a href="/blog">blog</a></li>';
	else:
	
		foreach($ancestors as $crumb)
		{
			echo '<li><a href="';
			echo get_permalink($crumb);
			echo '">';
			echo get_the_title($crumb);
			echo '</a></li>';
		}	
	endif;
	
	echo '</ul>';
}


/*
 * AO: Search form - simple search form which can be overwritten (include for it is commented by default.
 *
 */
function oneltd_search_form( $form ) {

    $form = '<form role="search" method="get" action="/">
				<label for="search">Search</label>
				<input type="text" id="search" name="s" />
				<input type="submit" id="search-sub" value="" />
			</form>';
	return $form;
}
//add_filter( 'get_search_form', 'oneltd_search_form' );



if ( ! function_exists( 'toolbox_comment' ) ) :
	/**
	 * AO: This funcktion is a direct port from the Toolbox theme, changes can be made as and when required during development.
	 * 
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own toolbox_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Toolbox 0.4
	 */
	function toolbox_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<footer>
					<div class="comment-author vcard">
						<?php echo get_avatar( $comment, 40 ); ?>
						<?php printf( __( '%s <span class="says">says:</span>', 'toolbox' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
					</div><!-- .comment-author .vcard -->
					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em><?php _e( 'Your comment is awaiting moderation.', 'toolbox' ); ?></em>
						<br />
					<?php endif; ?>
	
					<div class="comment-meta commentmetadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
						<?php
							/* translators: 1: date, 2: time */
							printf( __( '%1$s at %2$s', 'toolbox' ), get_comment_date(), get_comment_time() ); ?>
						</time></a>
						<?php edit_comment_link( __( '(Edit)', 'toolbox' ), ' ' );
						?>
					</div><!-- .comment-meta .commentmetadata -->
				</footer>
	
				<div class="comment-content"><?php comment_text(); ?></div>
	
				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
			</article><!-- #comment-## -->
	
		<?php
				break;
			case 'pingback' :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'toolbox' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'toolbox' ), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
endif; // ends check for toolbox_comment()









?>