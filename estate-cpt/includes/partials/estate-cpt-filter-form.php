<?php
/**
 * Filter form Template
 */
?>
<form class="estate-filter__form | js-estate-filter__form" method="post" enctype="application/x-www-form-urlencoded">
	<h4 class="h5 mt-0 mb-3"><?php echo esc_html__('Buildings filter', 'estate-cpt'); ?></h4>
	
	<div class="estate-filter__form-wrap">
		
		<div class="row">
			<div class="col-12 col-md-6">
			<?php
			
				/* Generate Taxonomy Filters */
				$taxonomy = 'district';
				$terms = get_terms( array(
					'taxonomy' => 'district',
					'hide_empty' => true,
				));
				
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {					
					echo '<div class="estate-filter__item | js-estate-filter__item" data-filter="'. $taxonomy .'>">';
						echo '<span class="d-block mb-1 fw-bold">'. __('District', 'estate-cpt') .'</span>';
						
						echo '<select id="estateDistrict" name="estate_district" >';
						echo '<option value="all" selected>'. __('All', 'estate-cpt') .'</option>';
						foreach($terms as $term) {
							echo '<option value="'. esc_attr($term->term_id) .'">'. $term->name .'</option>';
						}
						echo '</select>';
					echo '</div>';
				}
			
				
				/* Generate ACF Fields Filters */
			
				// array of filters (field key => field name)
				$GLOBALS['buildings_query_filters'] = array( 
					'field_628f87c3f753e'	=> 'floors_qty', 
					'field_628f88c3f753f'	=> 'building_type',
					'field_628f8924f7540'	=> 'environmental_friendliness'
				);
				
				foreach( $GLOBALS['buildings_query_filters'] as $key => $name ) :
					
					// get the field's settings without attempting to load a value
					$field = get_field_object($key, false, false);

					// create filter
					echo '<div class="estate-filter__item | js-estate-filter__item" data-filter="'. $name .'>">';
						echo '<span class="d-block mb-1 fw-bold">'. $field['label'] .'</span>';
						create_field( $field );
					echo '</div>';
					
				endforeach;
				
			?>
			</div> <!-- /.col -->
			
			
			<div class="col-12 col-md-6">			
				
				<div class="estate-filter__item">
					<label>
						<input type="checkbox" id="showFiltersByAppartments" name="show_appartments" class="js-appFiltersTrigger">
						<?php echo __('Filter by appartments', 'estate-cpt'); ?>
					</label>
				</div>
				
				
				<div class="estate-filter__item | js-appartments-filters" hidden>
					<?php
						$GLOBALS['appartment_query_filters'] = array(
							'field_628f8a13f7544' => 'rooms_qty',
							'field_628f8a81f7545' => 'balcony',
							'field_628f8acbf7546' => 'bathroom'
						);
						
						
						foreach( $GLOBALS['appartment_query_filters'] as $key => $name ) :
					
							// get the field's settings without attempting to load a value
							$field = get_field_object($key, false, false);

							// create filter
							echo '<div class="estate-filter__item | js-estate-filter__item" data-filter="'. $name .'>">';
								echo '<span class="d-block mb-1 fw-bold">'. $field['label'] .'</span>';
								create_field( $field );
							echo '</div>';
							
						endforeach;
					?>
				</div> <!-- /. appartment filters -->
				
			</div> <!-- /.col -->
		</div> <!-- /.row -->
		<div class="d-grid gap-2 mt-4">
			<button 
				class="btn btn-primary btn-block btn-lg | js-estate-filter__submit" 
				type="submit"><?php echo esc_html__('Filter', 'estate-cpt'); ?></button>
		</div>
	</div>
</form>