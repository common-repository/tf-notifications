<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.1.1 Update version number
 * @since             1.1.0
 * @package           TFWPN_TF_Notifications
 *
 * @wordpress-plugin
 * Plugin Name:       TF Notifications
 * Plugin URI:        https://timfitt.com/wordpress/plugins/tf-notifications/
 * Description:       Keep your visitors up to date with notifications across your organisation.
 * Version:           1.1.1
 * Author:            Tim Fitt
 * Author URI:        https://timfitt.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tfwpn-tf-notifications
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define( 'TFWPN_TF_NOTIFICATIONS_VERSION', '1.1.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tfwpn-tf-notifications-activator.php
 */
function activate_tfwpn_tf_notifications() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tfwpn-tf-notifications-activator.php';
	TFWPN_TF_Notifications_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tfwpn-tf-notifications-deactivator.php
 */
function deactivate_tfwpn_tf_notifications() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tfwpn-tf-notifications-deactivator.php';
	TFWPN_TF_Notifications_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tfwpn_tf_notifications' );
register_deactivation_hook( __FILE__, 'deactivate_tfwpn_tf_notifications' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tfwpn-tf-notifications.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.1.0
 */
function run_tfwpn_tf_notifications() {

	$plugin = new TFWPN_TF_Notifications();
	$plugin->tfwpn_tf_notifications_run();

}
run_tfwpn_tf_notifications();
