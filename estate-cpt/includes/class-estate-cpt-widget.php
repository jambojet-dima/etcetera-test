<?php

/**
 * The widget functionality of the plugin.
 *
 * @link 		http://
 * @since 		1.0.0
 *
 * @package 	Estate_Cpt
 * @subpackage 	Estate_Cpt/includes
 */

/**
 * The widget functionality of the plugin.
 *
 * @package 	Estate_Cpt
 * @subpackage 	Estate_Cpt/includes
 * @author 		Dmytro Bronfain <jambojet2@gmail.com>
 */
class Estate_Cpt_Widget extends WP_Widget {

	/**
	 * The ID of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {

		$this->plugin_name 			= 'estate-cpt';

		$name 					= esc_html__( 'Estate CPT', 'estate-cpt' );
		$opts['classname'] 		= '';
		$opts['description'] 	= esc_html__( 'Display real estates with filters', 'estate-cpt' );
		$control				= array( 'width' => '', 'height' => '' );

		parent::__construct( false, $name, $opts, $control );

	} // __construct()

	/**
	 * Back-end widget form.
	 *
	 * @see		WP_Widget::form()
	 *
	 * @uses	wp_parse_args
	 * @uses	esc_attr
	 * @uses	get_field_id
	 * @uses	get_field_name
	 * @uses	checked
	 *
	 * @param	array	$instance	Previously saved values from database.
	 */
	function form( $instance ) {

		$defaults['title'] = '';
		$instance = wp_parse_args( (array) $instance, $defaults );

		$field_text = 'title'; // This is the name of the textfield
		$id 		= $this->get_field_id( $field_text );
		$name 		= $this->get_field_name( $field_text );
		$value 		= esc_attr( $instance[$field_text] );

		echo '<p>
			<label for="' . $id . '">' . esc_html__( ucwords( $field_text ) ) . ': 
			<input class="widefat" id="' . $id . '" name="' . $name . '" type="text" value="' . $value . '" />
			</label>
		</p>';
		
		
		echo '<p>'. __('This widget shows filter form for CPT Estate: buildings and accommodations', 'estate-cpt') .'</p>';

	}
	
	
	

	/**
	 * Front-end display of widget.
	 *
	 * @see		WP_Widget::widget()
	 *
	 * @uses	apply_filters
	 * @uses	get_widget_layout
	 *
	 * @param	array	$args		Widget arguments.
	 * @param 	array	$instance	Saved values from database.
	 */
	function widget( $args, $instance ) {
		
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-estate-cpt-widget-ajax-handler.php';
		//Estate_Cpt_Widget_Ajax_Handler::register();

		$cache = wp_cache_get( $this->plugin_name, 'widget' );

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset ( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->plugin_name;
		}

		if ( isset ( $cache[ $args['widget_id'] ] ) ) {
			return print $cache[ $args['widget_id'] ];
		}

		extract( $args, EXTR_SKIP );

		$widget_string = $before_widget;

		// Manipulate widget's values based on their input fields here

		ob_start();

		include( plugin_dir_path( __FILE__ ) . 'partials/estate-cpt-display-widget.php' );

		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;

		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->plugin_name, $cache, 'widget' );

		echo $widget_string;
	} 
	
	
	

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see		WP_Widget::update()
	 *
	 * @param	array	$new_instance	Values just sent to be saved.
	 * @param	array	$old_instance	Previously saved values from database.
	 *
	 * @return 	array	$instance		Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		return $instance;

	}

}