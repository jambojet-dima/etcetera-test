<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


if ( ! function_exists( 'is_acf_activated' ) ) {
	/**
	 * Check if ACF is activated
	 */
	function is_acf_activated() {
		return ( class_exists('ACF') ) ? true : false;
	}
}



if ( ! function_exists( 'np_estate_meta_item' ) ) {
	/** 
	 * Estate Meta Item
	 */
	function np_estate_meta_item( string $label = '', string $value, string $before = '<div>', string $after = '</div>' ) : ?string
	{
		if (!$value) {
			return null;
		}
		
		// Output
		$html = '<dt>'. $label .'</dt>';
		$html .= '<dd>'. $value .'</dd>';
		
		return $before . $html . $after;
	}
}



if ( ! function_exists( 'np_building_meta_full' ) ) {
	/**
	 * Estate Full meta list
	 */
	function np_building_meta_full() : ?string
	{
		
		if ( !is_acf_activated() ) {
			return null;
		}
		
		// Vars
		$name = get_field('name'); // input
		$location = get_field('location_coordinates'); // input
		$floors_qty = get_field('floors_qty'); // select
		$building_type = get_field('building_type'); // radio
		$environmental_friendliness = get_field('environmental_friendliness'); // select
		
		
		// Output HTML
		$html = '<dl class="mt-4 d-flex flex-column gap-2">';
		
		// Name Info
		if ($name) {
			$html .= np_estate_meta_item( __('Name', 'understrap-child'), $name, '<div class="border-bottom">', '</div>' );
		}
		
		// Location Info
		if ($location) {
			$html .= np_estate_meta_item( __('Location coordinates', 'understrap-child'), $location, '<div class="border-bottom">', '</div>' );
		}
		
		// Floors Info
		if ($floors_qty) {
			$field = get_field_object( 'floors_qty' );
			$value = $field['value'];
			$label = $field['choices'][ $value ];
			$html .= np_estate_meta_item( __('Floors qty', 'understrap-child'), $label, '<div class="border-bottom">', '</div>' );
		}
		
		// Building Type
		if ($building_type) {
			$field = get_field_object( 'building_type' );
			$value = $field['value'];
			$label = $field['choices'][ $value ];
			$html .= np_estate_meta_item( __('Building type', 'understrap-child'), $label, '<div class="border-bottom">', '</div>' );
		}
		
		// environmental
		if ($environmental_friendliness) {
			$field = get_field_object( 'environmental_friendliness' );
			$value = $field['value'];
			$label = $field['choices'][ $value ];
			$html .= np_estate_meta_item( __('Environmental friendliness', 'understrap-child'), $label, '<div class="border-bottom">', '</div>' );
		}
		
		$html .= '</dl>';
		
		// get the result
		return $html;		
	}
}






if ( ! function_exists( 'np_accomodations_list' ) ) {
	/**
	 * Accomodation Meta Info
	 */
	function np_accomodations_list(string $before = '', string $after = '') : ?string
	{
		if ( !is_acf_activated() ) {
			return null;
		}
		
		
		if( !have_rows('appartments') ) {
			return null;
		}
		
		// Output
		$html = '<h3>'. __('Appartments', 'understrap-child') .'</h3>';
		$html .= '<ul class="row g-3 list-unstyled">';
		
		// Loop through rows.
		while( have_rows('appartments') ) : the_row();

			// Load sub field value.
			$area = get_sub_field('area'); // text
			$rooms_qty = get_sub_field('rooms_qty'); // Select
			$balcony = get_sub_field('balcony'); // Radio
			$bathroom = get_sub_field('bathroom'); // Radio
			$image = get_sub_field('image'); // image ID
			
			// Do something...
			$html .= '<li class="col-lg-4 col-md-6">';
			$html .= '<div class="card">';
			
			// Image
			if ($image) {
				$html .= wp_get_attachment_image( $image, 'full', false, array('class' => 'card-img-top') );
			}
			
			
			$html .= '<div class="card-body">';			
			$html .= '<dl class="fs-6 m-0 d-flex flex-column gap-2">';
			
			if ($area) {
				$html .= '<div class="d-flex flex-wrap gap-3 border-bottom">
					<dt class="fw-normal" style="min-width: 120px">'. __('Area: ', 'understrap-child') .'</dt>
					<dd>'. $area .'</dd>
				</div>';
			}
			
			if ($rooms_qty) {
				$field = get_sub_field_object( 'rooms_qty' );
				$value = $field['value'];
				$label = $field['choices'][ $value ];
				$html .= '<div class="d-flex flex-wrap gap-3 border-bottom">
					<dt class="fw-normal" style="min-width: 120px">'. __('Rooms qty: ', 'understrap-child') .'</dt>
					<dd>'. $label .'</dd>
				</div>';
			}
			
			if ($balcony) {
				$field = get_sub_field_object( 'balcony' );
				$value = $field['value'];
				$label = $field['choices'][ $value ];
				
				$html .= '<div class="d-flex flex-wrap gap-3 border-bottom">
					<dt class="fw-normal" style="min-width: 120px">'. __('Balcony: ', 'understrap-child') .'</dt>
					<dd>'. $label .'</dd>
				</div>';
			}
			
			
			if ($bathroom) {
				$field = get_sub_field_object( 'bathroom' );
				$value = $field['value'];
				$label = $field['choices'][ $value ];
				
				$html .= '<div class="d-flex flex-wrap gap-3">
					<dt class="fw-normal" style="min-width: 120px">'. __('Bathroom: ', 'understrap-child') .'</dt>
					<dd>'. $label .'</dd>
				</div>';
			}
			
			$html .= '</dl>';			
			$html .= '</div>';
			
			$html .= '</div>';
			$html .= '</li>';

		// End loop.
		endwhile;
		
		
		$html .= '</ul>';
		
		return $before . $html . $after;
	}
}






if ( ! function_exists( 'np_building_district' ) ) {
	/** 
	 * Show Building District in loop 
	 */
	function np_building_district(string $before = '', string $after = '') : ?string
	{
		$terms = get_the_terms( get_the_ID(), 'district' );
		if ( !$terms || is_wp_error( $terms ) ) {
			return null;
		}
		
		$districts_arr = array(); 
		foreach ( $terms as $term ) {
			$districts_arr[] = $term->name;
		}
		$districts = join( ", ", $districts_arr );
		
		$content = sprintf( __( 'District: <span>%s</span>', 'understrap-child' ), esc_html( $districts ) );
		return $before . $content . $after;
	}
}