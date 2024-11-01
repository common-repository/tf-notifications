<?php
/**
 * The notification post type functionality of the plugin.
 *
 * @link       https://timfitt.com
 * @since      1.1.0
 *
 * @package    TFWPN_TF_Notifications
 * @subpackage TFWPN_TF_Notifications/public
 */

/**
 * The notification post type functionality of the plugin.
 *
 * This class defines all code necessary to handle the notifications
 * custom post type.
 *
 * @package    TFWPN_TF_Notifications
 * @subpackage TFWPN_TF_Notifications/public
 * @author     Tim Fitt <developer@timfitt.com>
 */

class TFWPN_TF_PT_Notifications {
    const POST_TYPE = "tf_notification";

    /**
     * The Constructor
     */
    public function __construct() {
        add_action( 'save_post', [$this, 'tfwpn_tf_notifications_save_post'] );
    } // END public function __construct()

    /**
     * Create the post type
     */
    public function tfwpn_tf_notifications_create_post_type() {
        register_post_type(self::POST_TYPE,
            array(
                'labels' => array(
                    'name' => "Notifications",
                    'singular_name' => __(ucwords(str_replace("_", " ", self::POST_TYPE)))
                ),
                'public' => true,
                'has_archive' => true,
                'description' => __(""),
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'show_ui' => true,
                'show_in_nav_menus' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'notifications'),
                'capability_type' => 'post',
                'hierarchical' => false,
                'supports' => array(
                    'title',
                    'editor',
                    'author',
                    'thumbnail',
                    'excerpt',
                    'comments'
                ),
                'taxonomies' => array('notification-reason', 'notification-affected')
            )
        );
    }

    /**
     * Create custom taxonomies for custom post type
     */
    public function tfwpn_tf_notifications_create_taxonomies() {
        register_taxonomy(
            self::POST_TYPE.'_reason',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
            self::POST_TYPE,        //post type name
            array(
                'hierarchical' => false,
                'label' => 'Notification Reason',  //Display name
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'notification-reason', // This controls the base slug that will display before each term
                    'with_front' => false // Don't display the category base before
                )
            )
        );

        register_taxonomy(
            self::POST_TYPE.'_affected',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
            self::POST_TYPE,        //post type name
            array(
                'hierarchical' => false,
                'label' => 'Who is Affected',  //Display name
                'query_var' => true,
                'rewrite' => array(
                    'slug' => 'notification-affected', // This controls the base slug that will display before each term
                    'with_front' => false // Don't display the category base before
                )
            )
        );
    }

    /**
     * Hook into WP's add_meta_boxes action hook
     */
    public function tfwpn_tf_notifications_add_meta_boxes() {
        // Add this metabox to every selected post
        add_meta_box(
            sprintf('wp_plugin_template_%s_section', self::POST_TYPE),
            sprintf('Options', ucwords(str_replace("_", " ", self::POST_TYPE))),
            array(&$this, 'tfwpn_tf_notifications_add_meta_box_template'),
            self::POST_TYPE
        );
    } // END public function add_meta_boxes()

    /**
     * Called off of the add meta box
     *
     * @param unknown $post
     */
    public function tfwpn_tf_notifications_add_meta_box_template($post) {
        // Render the job order metabox
        include(sprintf("%s/../admin/partials/tfwpn-tf-notifications-admin-display.php", dirname(__FILE__)));
    } // END public function add_inner_meta_boxes($post)

    /**
     * Save the metaboxes for this custom post type
     */
    public function tfwpn_tf_notifications_save_post($post_id) {
        global $wpdb;
        // verify if this is an auto save routine.
        // If it is our form has not been submitted, so we dont want to do anything
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
            return;
        }
        if(isset($_POST['post_type']) && $_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id)) {

            $tf_featured = isset($_POST['tf_featured']) && $_POST['tf_featured'] == 1 ? 1 : 0;
            $tf_lightbox = isset($_POST['tf_lightbox']) && $_POST['tf_lightbox'] == 1 ? 1 : 0;

            // Sanitize text fields
            $tf_start_date = sanitize_text_field($_POST['tf_start_date']);
            $tf_end_date = sanitize_text_field($_POST['tf_end_date']);
            $tf_display_date = sanitize_text_field($_POST['tf_display_date']);

            // Validate data
            $pattern = '/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/';
            $check_tf_start_date = preg_match($pattern, $tf_start_date) == 1 ? $tf_start_date : null;
            $check_tf_end_date = preg_match($pattern, $tf_end_date) == 1 ? $tf_end_date : null;
            $check_tf_display_date = preg_match($pattern, $tf_display_date) == 1 ? $tf_display_date : null;
            $tf_complete = isset($_POST['tf_complete']) && $_POST['tf_complete'] == 1 ? 1 : 0;

            // Escape data
            update_post_meta($post_id, 'tf_featured', $tf_featured);
            update_post_meta($post_id, 'tf_lightbox', $tf_lightbox);
            update_post_meta($post_id, 'tf_start_date', $check_tf_start_date);
            update_post_meta($post_id, 'tf_end_date', $check_tf_end_date);
            update_post_meta($post_id, 'tf_display_date', $check_tf_display_date);
            update_post_meta($post_id, 'tf_complete', $tf_complete);

        } else {
            return;
        }

        if ( $post_id == null || empty($_POST) )
            return;

        if ( !isset( $_POST['post_type'] ) || $_POST['post_type'] != self::POST_TYPE )
            return;

        if ( wp_is_post_revision( $post_id ) )
            $post_id = wp_is_post_revision( $post_id );

        global $post;
        if ( empty( $post ) )
            $post = get_post($post_id);

        return;
    }

}