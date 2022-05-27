<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://
 * @since      1.0.0
 *
 * @package    Estate_Cpt
 * @subpackage Estate_Cpt/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Estate_Cpt
 * @subpackage Estate_Cpt/includes
 * @author     Dmytro Bronfain <jambojet2@gmail.com>
 */
class Estate_Cpt_i18n {
	
	/**
	 * The domain specified for this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$domain    The domain identifier for this plugin.
	 */
	private $domain;


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			$this->domain,
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
	
	
	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @since 		1.0.0
	 * @param 		string 			$domain    The domain that represents the locale of this plugin.
	 */
	public function set_domain( $domain ) {
		$this->domain = $domain;
	}
	
}
