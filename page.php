<?php
/**
 * The template for displaying all pages.
 *
 *
 * @package One_starter
 * @since One_starter 1.1
 */
get_header(); ?>			
			
			<?php if ( have_posts() ) : ?>
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', 'page' );
					?>

				<?php endwhile; ?>

			<?php else : ?>
				<p><?php _e( 'Error message: no posts found...', 'oneltd' ); ?></p>
			<?php endif; ?>
			
	<?php get_sidebar(); ?>		
<?php get_footer(); ?>