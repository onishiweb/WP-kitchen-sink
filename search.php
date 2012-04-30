<?php
/**
 * The search template file.
 *
 *
 * @package WordPress
 * @subpackage One Ltd
 */
get_header(); ?>			


			<?php if ( have_posts() ) : ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<header>
						<h1><?php the_title(); ?></h1>

								<?php
						global $wp_query;
						$total_results = $wp_query->found_posts;
						?>
						<p id="search-term" class="alignright">Showing search results for <span><?php echo get_search_query(); ?></span> - <span><?php echo $total_results; ?></span> article<?php if( $total_results != 1) echo "s"; ?>.</p>
					</header><!-- .entry-header -->
				

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

					<div class="search-pagination">
						<p class="alignleft"><?php previous_posts_link('&laquo; previous'); ?></p>
						
						<p class="alignright"><?php next_posts_link('next &raquo;'); ?></p>
					</div>			
				</article><!-- #post-<?php the_ID(); ?> -->

			<?php else : ?>
				<p><?php _e( 'Error message: no posts found...', 'oneltd' ); ?></p>
			<?php endif; ?>	
			
			<?php get_sidebar(); ?>
			
<?php get_footer(); ?>