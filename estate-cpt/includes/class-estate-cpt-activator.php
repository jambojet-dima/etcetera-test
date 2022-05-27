<?php

/**
 * Fired during plugin activation
 *
 * @link       https://
 * @since      1.0.0
 *
 * @package    Estate_Cpt
 * @subpackage Estate_Cpt/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Estate_Cpt
 * @subpackage Estate_Cpt/includes
 * @author     Dmytro Bronfain <jambojet2@gmail.com>
 */
class Estate_Cpt_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-estate-cpt-admin.php';
		
		Estate_Cpt_Admin::new_cpt();
		Estate_Cpt_Admin::new_taxonomy();

		flush_rewrite_rules();

	}

}
