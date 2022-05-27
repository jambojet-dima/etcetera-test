<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://
 * @since      1.0.0
 *
 * @package    Estate_Cpt
 * @subpackage Estate_Cpt/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Estate_Cpt
 * @subpackage Estate_Cpt/admin
 * @author     Dmytro Bronfain <jambojet2@gmail.com>
 */
class Estate_Cpt_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	
	
	
	/**
	 * Creates a new custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_post_type()
	 */
	public static function new_cpt() {

		$cap_type 	= 'post';
		$plural 	= _x( 'Real estates', 'Post Type General Name', 'estate' );
		$single 	= _x( 'Real estate', 'Post Type Singular Name', 'estate' );
		$name 		= __( 'Real estate', 'estate' );
		$description = __( 'Short description', 'estate' );
		$cpt_name 	= 'estate';
		
		
		$labels = array(
			'name'                  => $plural,
			'singular_name'         => $single,
			'menu_name'             => $name,
			'name_admin_bar'        => $name,
			'archives'              => $name,
		);
		$rewrite = [
			'slug' => $cpt_name,
			'with_front' => false
		];
		$args = array(
			'label'                 => $name,
			'description'           => $description,
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail' ),
			//'taxonomies'            => array( 'district'),
			'hierarchical'          => false,
			'rewrite'				=> $rewrite,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 20,
			'menu_icon'             => 'dashicons-building',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'show_in_rest'          => false,
		);

		register_post_type( strtolower( $cpt_name ), $args );

	}
	
	
	

	/**
	 * Creates a new taxonomy for a custom post type
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public static function new_taxonomy() {
		
		$plural 	= _x( 'Districts', 'Taxonomy General Name', 'estate' );
		$single 	= _x( 'District', 'Taxonomy Singular Name', 'estate' );
		$name 		= __( 'District', 'estate' );
		$tax_name 	= 'district';
		
		$labels = [
			'name'                       => $plural,
			'singular_name'              => $single,
			'menu_name'                  => $name,
		];
		$rewrite = array(
			'slug'                       => $tax_name,
			'with_front'                 => false,
			'hierarchical'               => false,
		);
		$args = [
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'rewrite'                    => $rewrite,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,		
			'show_tagcloud'              => false,
			'show_in_rest'               => false,
		];

		register_taxonomy( $tax_name, ['estate'], $args );

	}
	
	

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/estate-cpt-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/estate-cpt-admin.js', array( 'jquery' ), $this->version, false );

	}

}
