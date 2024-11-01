<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://timfitt.com
 * @since      1.1.0
 *
 * @package    TFWPN_TF_Notifications
 * @subpackage TFWPN_TF_Notifications/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.1.0
 * @package    TFWPN_TF_Notifications
 * @subpackage TFWPN_TF_Notifications/includes
 * @author     Tim Fitt <developer@timfitt.com>
 */
class TFWPN_TF_Notifications {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.1.0
	 * @access   protected
	 * @var      TFWPN_TF_Notifications_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

    protected $pt_notification;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.1.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.1.0
	 */
	public function __construct() {
		if ( defined( 'TFWPN_TF_NOTIFICATIONS_VERSION' ) ) {
			$this->version = TFWPN_TF_NOTIFICATIONS_VERSION;
		} else {
			$this->version = '1.1.0';
		}
		$this->plugin_name = 'tfwpn-tf-notifications';

		$this->tfwpn_tf_notifications_load_dependencies();
		$this->tfwpn_tf_notifications_set_locale();
		$this->tfwpn_tf_notifications_define_admin_hooks();
		$this->tfwpn_tf_notifications_define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - TFWPN_TF_Notifications_Loader. Orchestrates the hooks of the plugin.
	 * - TFWPN_TF_Notifications_i18n. Defines internationalization functionality.
	 * - TFWPN_TF_Notifications_Admin. Defines all hooks for the admin area.
	 * - TFWPN_TF_Notifications_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	private function tfwpn_tf_notifications_load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tfwpn-tf-notifications-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tfwpn-tf-notifications-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tfwpn-tf-notifications-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-tfwpn-tf-notifications-public.php';

        /**
         * The class responsible for defining all the notifications post type.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'post-types/class-tfwpn-tf-notifications-pt-notifications.php';

		$this->loader = new TFWPN_TF_Notifications_Loader();

        $this->pt_notification = new TFWPN_TF_PT_Notifications();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the TFWPN_TF_Notifications_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	private function tfwpn_tf_notifications_set_locale() {

		$plugin_i18n = new TFWPN_TF_Notifications_i18n();

		$this->loader->tfwpn_tf_notifications_add_action( 'plugins_loaded', $plugin_i18n, 'tfwpn_tf_notifications_load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	private function tfwpn_tf_notifications_define_admin_hooks() {

		$plugin_admin = new TFWPN_TF_Notifications_Admin( $this->tfwpn_tf_notifications_get_plugin_name(), $this->tfwpn_tf_notifications_get_version() );

        $this->loader->tfwpn_tf_notifications_add_action( 'init', $plugin_admin, 'tfwpn_tf_notifications_create_post_types' );
        $this->loader->tfwpn_tf_notifications_add_action( 'init', $this, 'tfwpn_tf_notifications_init' );
        $this->loader->tfwpn_tf_notifications_add_action('admin_init', $this->pt_notification, 'tfwpn_tf_notifications_add_meta_boxes');
		$this->loader->tfwpn_tf_notifications_add_action( 'admin_enqueue_scripts', $plugin_admin, 'tfwpn_tf_notifications_enqueue_styles' );
		$this->loader->tfwpn_tf_notifications_add_action( 'admin_enqueue_scripts', $plugin_admin, 'tfwpn_tf_notifications_enqueue_scripts' );

        $this->loader->tfwpn_tf_notifications_add_action( 'wp_footer', $plugin_admin, 'tfwpn_tf_notifications_footer_code' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 */
	private function tfwpn_tf_notifications_define_public_hooks() {

		$plugin_public = new TFWPN_TF_Notifications_Public( $this->tfwpn_tf_notifications_get_plugin_name(), $this->tfwpn_tf_notifications_get_version() );

		$this->loader->tfwpn_tf_notifications_add_action( 'wp_enqueue_scripts', $plugin_public, 'tfwpn_tf_notifications_enqueue_styles' );
		$this->loader->tfwpn_tf_notifications_add_action( 'wp_enqueue_scripts', $plugin_public, 'tfwpn_tf_notifications_enqueue_scripts' );

	}

    /**
     *
     *
     * @since   1.1.0
     * @return void
     */
    public function tfwpn_tf_notifications_init() {
        $this->template_url = apply_filters ( 'tfnotifications_template_url', 'tf-notifications/' );
    }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.1.0
	 */
	public function tfwpn_tf_notifications_run() {
		$this->loader->tfwpn_tf_notifications_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.1.0
	 * @return    string    The name of the plugin.
	 */
	public function tfwpn_tf_notifications_get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.1.0
	 * @return    TFWPN_TF_Notifications_Loader    Orchestrates the hooks of the plugin.
	 */
	public function tfwpn_tf_notifications_get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.1.0
	 * @return    string    The version number of the plugin.
	 */
	public function tfwpn_tf_notifications_get_version() {
		return $this->version;
	}

}
