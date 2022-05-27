<?php
/**
 * Estate Card template 
 */
?>
<article class="card">
	<?php echo get_the_post_thumbnail( get_the_ID(), 'full', array('class' => 'card-img-top') ); ?>
	
	<div class="card-body">
		<?php the_title(
			sprintf( '<h5 class="card-title"><a class="text-reset" href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></h5>'
		); ?>
		
		<div class="estate-card-meta mb-3">
			<?php
			// Vars		
			$location = get_field('location_coordinates'); // input
			$floors_qty = get_field('floors_qty'); // select
			$building_type = get_field('building_type'); // radio
			$environmental_friendliness = get_field('environmental_friendliness'); // select
			
			
			// Location Info
			if ($location) {
				echo '<div class="estate-card-meta__item">'. sprintf( __('Location coordinates: %s', 'estate-cpt'), $location) .'</div>';
			}
			
			// floors qty
			if ($floors_qty) {
				$field = get_field_object( 'floors_qty' );
				$value = $field['value'];
				$label = $field['choices'][ $value ];
				echo '<div class="estate-card-meta__item">'. sprintf( __('Floors qty: %s', 'estate-cpt'), $label) .'</div>';
			}
			
			// building type
			if ($building_type) {
				$field = get_field_object( 'building_type' );
				$value = $field['value'];
				$label = $field['choices'][ $value ];
				echo '<div class="estate-card-meta__item">'. sprintf( __('Building type: %s', 'estate-cpt'), $label) .'</div>';
			}
			
			// environmental friendliness
			if ($environmental_friendliness) {
				$field = get_field_object( 'environmental_friendliness' );
				$value = $field['value'];
				$label = $field['choices'][ $value ];
				echo '<div class="estate-card-meta__item">'. sprintf( __('Environmental friendliness: %s', 'estate-cpt'), $label) .'</div>';
			}
			?>
		</div>
		
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-primary"><?php echo esc_html__('Read more', 'estate-cpt') ?></a>
	</div>
</article>
