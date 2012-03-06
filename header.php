<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package One_starter
 * @since One_starter 1.1
 */
?><!DOCTYPE html> <!-- Lovely HTML5 doctype -->
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> 
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		
		<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
	
		wp_title( '|', true, 'right' );
	
		// Add the blog name.
		bloginfo( 'name' );
	
		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";
	
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'toolbox' ), max( $paged, $page ) );
	
		?></title>
		
		<!-- HTML5 SHIV for IE -->
		<!-- If using Modernizr you can remove this script! -->
		<!--[if lt IE 9]>
			<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<!-- Main stylesheets & fonts etc -->
		<!--[if ! lte IE 6]><!-->
			<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />			
		<!--<![endif]-->
	
		<!-- Standard IE6 Stylesheet courtesy of Andy Clarke -->
		<!--[if lte IE 6]>
			<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/ie6-stylesheet.css" media="screen, projection">
		<![endif]-->
	
		<?php wp_head(); ?>

		<!-- JS Plugins (please check and update often) -->		
		
		<!-- insert analytics here -->
		<script type="text/javascript">
		/*
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		*/
		</script>
	</head>
	
	<body <?php body_class(); ?>>
		
		<!-- Site container -->
		<div id="container">
		
			<!-- Main site header -->
			<header id="site-header">
				<hgroup>
					<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</hgroup>
			</header>
			
			<!-- Main site navigation -->
			<nav id="main-navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav>
			
			<!-- Begin content area -->
			<div id="content">
			