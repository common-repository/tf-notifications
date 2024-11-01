<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://timfitt.com
 * @since      1.1.0
 *
 * @package    TFWPN_TF_Notifications
 * @subpackage TFWPN_TF_Notifications/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    TFWPN_TF_Notifications
 * @subpackage TFWPN_TF_Notifications/public
 * @author     Tim Fitt <developer@timfitt.com>
 */
class TFWPN_TF_Notifications_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.1.0
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
	 * @since    1.1.0
	 */
	public function tfwpn_tf_notifications_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TFWPN_TF_Notifications_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TFWPN_TF_Notifications_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_style( 'tfwpn-tf-notifications-jquery-bxslider-public-css', plugin_dir_url( __FILE__ ) . 'css/tfwpn-tf-notifications-jquery.bxslider.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'tfwpn-tf-notifications-colorbox-public-css', plugin_dir_url( __FILE__ ) . 'css/tfwpn-tf-notifications-colorbox.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-public-css', plugin_dir_url( __FILE__ ) . 'css/tfwpn-tf-notifications-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.1.0
	 */
	public function tfwpn_tf_notifications_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in TFWPN_TF_Notifications_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The TFWPN_TF_Notifications_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

        wp_enqueue_script( 'tfwpn-tf-notifications-jquery-bxslider-public-js', plugin_dir_url( __FILE__ ) . 'js/tfwpn-tf-notifications-jquery.bxslider.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( 'tfwpn-tf-notifications-colorbox-public-js', plugin_dir_url( __FILE__ ) . 'js/tfwpn-tf-notifications-jquery.colorbox.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-public-js', plugin_dir_url( __FILE__ ) . 'js/tfwpn-tf-notifications-public.js', array( 'jquery' ), $this->version, false );

	}

}
