<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://timfitt.com
 * @since      1.1.0
 *
 * @package    TFWPN_TF_Notifications
 * @subpackage TFWPN_TF_Notifications/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.1.0
 * @package    TFWPN_TF_Notifications
 * @subpackage TFWPN_TF_Notifications/includes
 * @author     Tim Fitt <developer@timfitt.com>
 */
class TFWPN_TF_Notifications_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.1.0
	 */
	public function tfwpn_tf_notifications_load_plugin_textdomain() {

		load_plugin_textdomain(
			'tfwpn-tf-notifications',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
