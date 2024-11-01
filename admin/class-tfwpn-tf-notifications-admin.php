<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://timfitt.com
 * @since      1.1.1
 * @since      1.1.0
 *
 * @package    TFWPN_TF_Notifications
 * @subpackage TFWPN_TF_Notifications/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    TFWPN_TF_Notifications
 * @subpackage TFWPN_TF_Notifications/admin
 * @author     Tim Fitt <developer@timfitt.com>
 */
class TFWPN_TF_Notifications_Admin {

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
	 * @since    1.1.1  Added tf_notification_table shortcode
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        add_shortcode('tf_important_notification', [$this, 'tfwpn_tf_notifications_notification_shortcode']);
        add_shortcode('tf_notification_table', [$this, 'tfwpn_tf_notifications_notification_table_shortcode']);
	}

    public function tfwpn_tf_notifications_create_post_types() {
        $pt_notification = new TFWPN_TF_PT_Notifications();
        $pt_notification->tfwpn_tf_notifications_create_post_type();
        $pt_notification->tfwpn_tf_notifications_create_taxonomies();
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
     * @since    1.1.1  Don't use external source for CSS files
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

        global $wp_scripts;
        wp_enqueue_style('tfwpn-tf-notifications-jqueryui-admin-css', plugin_dir_url( __FILE__ ) . 'css/tfwpn-tf-notifications-jquery-ui.min.css', array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name.'-admin-css', plugin_dir_url( __FILE__ ) . 'css/tfwpn-tf-notifications-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'jquery-ui-slider' );
        wp_enqueue_script( 'jquery-ui-timepicker-addon-admin-js', plugin_dir_url( __FILE__ ) . 'js/tfwpn-tf-notifications-jquery-ui-timepicker-addon.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name.'-admin-js', plugin_dir_url( __FILE__ ) . 'js/tfwpn-tf-notifications-admin.js', array( 'jquery' ), $this->version, true );

	}

    /**
     * @since    1.1.0
     * @return void
     */
    public function tfwpn_tf_notifications_footer_code() {
        $html_text = "";
        $notifications = $this->tfwpn_tf_notifications_get_lightbox_notifications ();
        if (! isset ( $_SESSION ['tfwpnTFNshowNotificationPopNot'] ) || (isset ( $_SESSION ['tfwpnTFNshowNotificationPopNot'] ) && $_SESSION ['tfwpnTFNshowNotificationPopNot'] != "noshowpop")) {
            if ($notifications != null) {
                $_SESSION ['tfwpnTFNshowNotificationPopNot'] = "noshowpop";

                $html_text = '<div style="display: none;">
                    <style>
                        #tf-notification-pop ul {
                            padding: 0;
                            margin: 0;
                            list-style: none;
                        }

                        #tf-notification-pop h5 {
                            margin: 0;
                        }

                        #tf-notification-pop .news-date {
                            font-style: italic;
                            font-weight: bold;
                        }
                    </style>
                    <div id="tf-notification-pop">
                        <h1>Important News</h1>
                        <ul>';

                            foreach ( $notifications as $notification ) {
                                $html_text .= '<li><h5><a href="'.get_permalink($notification->ID).'">'.$notification->post_title.'</a></h5>';

                                    if (get_post_meta ( $notification->ID, 'tf_start_date', true ))
                                        $html_text .= '<div class="news-date">' . date ( "D j M, Y - g:ia", strtotime ( get_post_meta ( $notification->ID, 'tf_start_date', true ) ) );

                                    if (get_post_meta ( $notification->ID, 'tf_start_date', true ) && get_post_meta ( $notification->ID, 'tf_end_date', true ))
                                        $html_text .= " to " . date ( "D j M, Y - g:ia", strtotime ( get_post_meta ( $notification->ID, 'tf_end_date', true ) ) );

                                    if (get_post_meta ( $notification->ID, 'tf_start_date', true ))
                                        $html_text .= "</div>";

                                    $html_text .= '<p>'.$notification->post_excerpt.'</p>
                                    <p><a href="'.get_permalink($notification->ID).'">Read more...</a></p>
                                </li>';
                            }

                        $html_text .= '</ul></div></div>
                <script>
                    jQuery(document).ready(function($) {
                        $.colorbox({inline:true, href:"#tfwpn-tf-notifications-notification-pop", width:"50%", height:"50%"});
                    });
                </script>';
            }
        }

        echo wp_kses_post($html_text);
    }


    /**
     * Create important notifications shortcode.
     *
     * @param   $atts
     * @since   1.1.0
     * @return  false|string
     */
    public function tfwpn_tf_notifications_notification_shortcode($atts) {

        extract(shortcode_atts(array(
            /*
             * count => Number of posts to display in cycle
             * link => 1 to link to the post, 0 to not include a link
             * trans => Which transition to use between posts: fade / slide
             * speed => Amount of "wait" time between transitions
             */
            "count" => -1,
            "link" => 1,
            "trans" => "fade",
            "speed" => 3000
        ), $atts));

        $notfications = $this->tfwpn_tf_notifications_get_featured_notifications();

        $html_text = "";
        if($notfications != null && sizeof($notfications) > 0) {
            $html_text .= '<div class="tf-notification-sc"><ul class="'.$trans.'" data-speed="'.$speed.'">';
            foreach($notfications as $notification) {
                $html_text .= "<li><h5>";

                if($link == 1) {
                    $html_text .= '<a href="'.get_permalink($notification->ID).'">'.$notification->post_title.'</a>';
                } else {
                    $html_text .= $notification->post_title;
                }
                $html_text .= "</h5>";
                if(get_post_meta($notification->ID, 'tf_start_date', true ))
                    $html_text .= '<div class="news-date">'.date("D j M, Y - g:ia", strtotime(get_post_meta($notification->ID, 'tf_start_date', true )));

                if(get_post_meta($notification->ID, 'tf_start_date', true ) && get_post_meta($notification->ID, 'tf_end_date', true ))
                    $html_text .= " to ".date("D j M, Y - g:ia", strtotime(get_post_meta($notification->ID, 'tf_end_date', true )));

                if(get_post_meta($notification->ID, 'tf_start_date', true ))
                    $html_text .= "</div>";

                $html_text .= "<p>".$notification->post_excerpt."</p>";

                if($link == 1)
                    $html_text .= '<p><a href="'.get_permalink($notification->ID).'">Read more...</a></p>';

                $html_text .= "</li>";
            }
            $html_text .= '</ul></div>';
        }

        echo wp_kses_post($html_text);

    } // END public function notification_shortcode()

    /**
     * Create the notification table shortcode.
     *
     * @param   $atts
     * @since 1.1.0
     * @return  false|string
     */
    public function tfwpn_tf_notifications_notification_table_shortcode($atts) {
        extract(shortcode_atts(array(
                /*
                 * count => Number of posts to display
                 * link => 1 to link to the post, 0 to not include a link
                 */
                "count" => -1,
                "link" => 1
            ), $atts)
        );


        $notifications = $this->tfwpn_tf_notifications_get_grouped_notifications();

        $html_text = "";
        if($notifications != null && sizeof($notifications) > 0) {
            $html_text .= "<table>";
            $html_text .= "<caption>Current and Recent Notifications</caption>";
            $html_text .= "<tr>";
            $html_text .= "<th>Start</th>";
            $html_text .= "<th>Finish</th>";
            $html_text .= "<th>Information</th>";
            $html_text .= "</tr>";

            $current = 0;
            $resolved = 0;
            $c = 1;
            $d = 1;
            foreach($notifications as $notification) {
                if($current == 0 && $notification->is_complete != 1) {
                    $html_text .= '<tr><td colspan="3">Current</td></tr>';
                    $current++;
                }
                if($resolved == 0 && $notification->is_complete == 1) {
                    $html_text .= '<tr><td colspan="3">Resolved</td></tr>';
                    $resolved++;
                }
                if($count > 0) {
                    if($notification->is_complete != 1 && $c <= $count) {
                        $html_text .= "<tr>";
                        $html_text .= "<td>";
                        if($notification->start_date != "") $html_text .= date("D j M, Y - g:ia", strtotime($notification->start_date));
                        $html_text .= "</td>";
                        $html_text .= "<td>";
                        if($notification->end_date != "") $html_text .= date("D j M, Y - g:ia", strtotime($notification->end_date));
                        $html_text .= "</td>";
                        $html_text .= "<td>".$notification->post_title."</td>";
                        $html_text .= "</tr>";

                        $c++;
                    } else if($notification->is_complete == 1 && $d <= $count) {
                        $html_text .= "<tr>";
                        $html_text .= "<td>";
                        if($notification->start_date != "") $html_text .= date("D j M, Y - g:ia", strtotime($notification->start_date));
                        $html_text .= "</td>";
                        $html_text .= "<td>";
                        if($notification->end_date != "") $html_text .= date("D j M, Y - g:ia", strtotime($notification->end_date));
                        $html_text .= "</td>";
                        $html_text .= "<td>".$notification->post_title."</td>";
                        $html_text .= "</tr>";

                        $d++;
                    }
                } else {
                    $html_text .= "<tr>";
                    $html_text .= "<td>";
                    if($notification->start_date != "") $html_text .= date("D j M, Y - g:ia", strtotime($notification->start_date));
                    $html_text .= "</td>";
                    $html_text .= "<td>";
                    if($notification->end_date != "") $html_text .= date("D j M, Y - g:ia", strtotime($notification->end_date));
                    $html_text .= "</td>";
                    $html_text .= "<td>".$notification->post_title."</td>";
                    $html_text .= "</tr>";
                }
            }
            $html_text .= "</table>";
        }

        echo wp_kses_post($html_text);
    }

    /**
     * Return grouped notifications.
     *
     * @since   1.1.0
     * @return  array|object|stdClass[]|null
     */
    public function tfwpn_tf_notifications_get_grouped_notifications() {
        global $wpdb;
        // Get all notifications marked as featured, limit by "count"
        $notifications = $wpdb->get_results(
            $wpdb->prepare(
                "
							SELECT p.*, pm1.meta_value as start_date, pm2.meta_value as end_date, pm3.meta_value as is_complete FROM $wpdb->posts p
							LEFT JOIN $wpdb->postmeta pm1 ON p.ID = pm1.post_id
							LEFT JOIN $wpdb->postmeta pm2 ON pm1.post_id = pm2.post_id
							LEFT JOIN $wpdb->postmeta pm3 ON pm2.post_id = pm3.post_id
							WHERE pm1.meta_key = %s
							AND pm2.meta_key = %s
							AND pm3.meta_key = %s
							AND p.post_type = %s
							ORDER BY pm3.meta_value ASC, UNIX_TIMESTAMP(pm1.meta_value) ASC
							",
                'tf_start_date', 'tf_end_date', 'tf_complete', 'tf_notification'
            )
        );

        return $notifications;
    }

    /**
     * Return featured notifications.
     *
     * @since   1.1.0
     * @return  array|object|stdClass[]|null
     */
    public function tfwpn_tf_notifications_get_featured_notifications() {
        global $wpdb;
        // Get all notifications marked as featured, limit by "count"
        $notifications = $wpdb->get_results(
            $wpdb->prepare(
                "
							SELECT p.* FROM $wpdb->posts p
							LEFT JOIN $wpdb->postmeta pm1 ON p.ID = pm1.post_id
							LEFT JOIN $wpdb->postmeta pm2 ON pm1.post_id = pm2.post_id
							LEFT JOIN $wpdb->postmeta pm3 ON pm2.post_id = pm3.post_id
							LEFT JOIN $wpdb->postmeta pm4 ON pm3.post_id = pm4.post_id
							WHERE pm1.meta_key = %s
							AND pm1.meta_value = %s
							AND pm2.meta_key = %s
							AND (pm2.meta_value = %s OR UNIX_TIMESTAMP(pm2.meta_value) >= UNIX_TIMESTAMP(%s))
							AND pm3.meta_key = %s
							AND pm3.meta_value = %s
							AND pm4.meta_key = %s
							AND UNIX_TIMESTAMP(pm4.meta_value) <= UNIX_TIMESTAMP(%s)
							AND p.post_type = %s
							ORDER BY p.post_modified DESC
							",
                'tf_featured', '1', 'tf_end_date', '', current_time("mysql"), 'tf_complete', 0, 'tf_display_date', current_time("mysql"), 'tf_notification'
            )
        );

        return $notifications;
    }

    /**
     * Return notifications that appear in the lightbox.
     *
     * @since 1.1.0
     * @return array|object|stdClass[]|null
     */
    public function tfwpn_tf_notifications_get_lightbox_notifications() {
        global $wpdb;
        // Get all notifications marked as featured, limit by "count"
        $notifications = $wpdb->get_results(
            $wpdb->prepare(
                "
							SELECT p.* FROM $wpdb->posts p
							LEFT JOIN $wpdb->postmeta pm1 ON p.ID = pm1.post_id
							LEFT JOIN $wpdb->postmeta pm2 ON pm1.post_id = pm2.post_id
							LEFT JOIN $wpdb->postmeta pm3 ON pm2.post_id = pm3.post_id
							WHERE pm1.meta_key = %s
							AND pm1.meta_value = %s
							AND pm2.meta_key = %s
							AND (pm2.meta_value = %s OR UNIX_TIMESTAMP(pm2.meta_value) >= UNIX_TIMESTAMP(%s))
							AND pm3.meta_key = %s
							AND pm3.meta_value = %s
							AND p.post_type = %s
							ORDER BY p.post_modified DESC
							",
                'tf_lightbox', '1', 'tf_end_date', '', current_time("mysql"), 'tf_complete', 0, 'tf_notification'
            )
        );

        return $notifications;
    }

}
