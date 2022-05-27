<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://
 * @since      1.0.0
 *
 * @package    Estate_Cpt
 * @subpackage Estate_Cpt/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Estate_Cpt
 * @subpackage Estate_Cpt/public
 * @author     Dmytro Bronfain <jambojet2@gmail.com>
 */
class Estate_Cpt_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	
	
	

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Estate_Cpt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Estate_Cpt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/estate-cpt-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Estate_Cpt_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Estate_Cpt_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/estate-cpt-public.js', array( 'jquery' ), $this->version, false );

	}
	
	
	
	/**
	 * Registers all shortcodes at once
	 *
	 * @return [type] [description]
	 */
	public function register_shortcodes() {

		add_shortcode( 'estate_filter', array( $this, 'estate_filters_shortcode' ) );

	}
	
	
	
	
	
	/**
	 * Processes shortcode estate_filter
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 *
	 * @uses	get_option
	 * @uses	get_layout
	 *
	 * @return	mixed	$output		Output of the buffer
	 */
	public function estate_filters_shortcode( $atts = array() ) {
		
		// Attributes
		$atts = shortcode_atts(
			[
				'title' => '',
			],
			$atts,
			'estate_filter'
		);

		$title = $atts['title'];		
		
		ob_start();
		include plugin_dir_path( dirname( __FILE__ ) ) . 'includes/partials/estate-cpt-filter.php';
		$content = ob_get_contents();
		ob_end_clean();		
		
		
		// Output content
		$html = '<div class="shrtcode-estate">';
		if ( !empty($title) ) {
			$html .= '<h2 class="h3 mb-3 mt-0">'. esc_html($title) .'</h2>';
		}		
		$html .= $content;		
		$html .= '</div>';
		
		// shortcode: [estate_filter title="Some title"]
		return $html;
	}

}
