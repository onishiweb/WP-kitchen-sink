<?php
/**
 * @package One_starter
 * @since One_starter 1.1
 */
?>

			<article id="post-<?php the_ID(); ?>" <?php post_class("list"); ?>>
			
				<header>
					<h1><?php the_title(); ?></h1>
				</header><!-- .entry-header -->
			
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			
			</article><!-- #post-<?php the_ID(); ?> -->