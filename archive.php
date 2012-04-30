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


		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<?php
			/* 
			 * Taken from TwentyTen theme (Amazing what you can learn from base themes!)
			 * Queue the first post, that way we know
			 * what date we're dealing with (if that is the case).
			 *
			 * We reset this later so we can run the loop
			 * properly with a call to rewind_posts().
			 */
			if ( have_posts() )
				the_post();
			?>

				<header>	
					<h1>
						<?php if ( is_day() ) : ?>
										<?php printf( __( 'Daily Archives: <span>%s</span>', 'twentyten' ), get_the_date() ); ?>
						<?php elseif ( is_month() ) : ?>
										<?php printf( __( 'Monthly Archives: <span>%s</span>', 'twentyten' ), get_the_date( 'F Y' ) ); ?>
						<?php elseif ( is_year() ) : ?>
										<?php printf( __( 'Yearly Archives: <span>%s</span>', 'twentyten' ), get_the_date( 'Y' ) ); ?>
						<?php else : ?>
										<?php _e( 'Blog Archives', 'twentyten' ); ?>
						<?php endif; ?>
					</h1>
				</header>

				<?php
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();

				/* Run the loop for the archives page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-archive.php and that will be used instead.
				 */	
				?>
				<div class="entry-content">
					
					<?php oneltd_content_nav( 'nav-above' ); ?>
				
					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to overload this in a child theme then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', 'list' );
						?>

					<?php endwhile; ?>
					
					<?php oneltd_content_nav( 'nav-below' ); ?>				

				</div><!-- .entry-content -->

			<?php else : ?>
				<p><?php _e( 'Error message: no posts found...', 'oneltd' ); ?></p>
			<?php endif; ?>

		</article><!-- #post-<?php the_ID(); ?> -->
			
	<?php get_sidebar(); ?>			
<?php get_footer(); ?>