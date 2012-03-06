<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package One_starter
 * @since One_starter 1.1
 */

get_header(); ?>

			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'oneltd' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'oneltd' ); ?></p>

					<?php get_search_form(); ?>

					
				</div><!-- .entry-content -->

			</article><!-- #post-0 -->

	<?php get_sidebar(); ?>
<?php get_footer(); ?>