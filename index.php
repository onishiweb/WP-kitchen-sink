<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package One_starter
 * @since One_starter 1.1
 */
get_header(); ?>

			<?php if ( have_posts() ) : ?>
				
				<h1>HELLO</h1>
				<?php oneltd_content_nav( 'nav-above' ); ?>
			
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content' );
					?>

				<?php endwhile; ?>
				
				<?php oneltd_content_nav( 'nav-below' ); ?>				

			<?php else : ?>
				<p><?php _e( 'Error message: no posts found...', 'oneltd' ); ?></p>
			<?php endif; ?>
			
	<?php get_sidebar(); ?>			
<?php get_footer(); ?>