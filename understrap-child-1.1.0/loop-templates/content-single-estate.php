<?php
/**
 * Single Estate partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header mb-4">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php echo np_building_district('<div class="text-muted">', '</div>'); ?>

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">
		<?php echo np_building_meta_full(); ?>
		<?php echo np_accomodations_list('<div class="mt-5">', '</div>'); ?>
		
		<?php
		// understrap_link_pages();
		?>

	</div><!-- .entry-content -->

</article><!-- #post-## -->
