<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class('card shadow-sm'); ?> id="post-<?php the_ID(); ?>">

	<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
		<?php echo get_the_post_thumbnail( $post->ID, 'large', array('class' => 'card-img-top') ); ?>
	</a>
	
	<div class="card-body">
	
		<header class="entry-header">

			<?php
			the_title(
				sprintf( '<h2 class="entry-title"><a class="text-reset" href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
				'</a></h2>'
			);
			?>

			<?php if ( 'post' === get_post_type() ) : ?>

				<div class="entry-meta text-muted">
					<?php understrap_posted_on(); ?>
				</div><!-- .entry-meta -->

			<?php endif; ?>

		</header><!-- .entry-header -->	

		<div class="entry-content mt-2">

			<?php
			the_excerpt();
			understrap_link_pages();
			?>

		</div><!-- .entry-content -->

		<footer class="entry-footer">

			<?php //understrap_entry_footer(); ?>

		</footer><!-- .entry-footer -->
		
	</div>
</article><!-- #post-## -->
