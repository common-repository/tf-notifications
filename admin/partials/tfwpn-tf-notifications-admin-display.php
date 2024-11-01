<?php

/**
 * Provide an admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://timfitt.com
 * @since      1.1.1    Escape echo data
 * @since      1.1.0
 *
 * @package    TFWPN_TF_Notifications
 * @subpackage TFWPN_TF_Notifications/admin/partials
 */

global $post;
?>
<table>
    <tr>
        <th class="metabox_label_column"><label for="tf_featured">Featured</th>
        <?php
        $checked = @get_post_meta($post->ID, 'tf_featured', true) ? ' checked="checked"' : '';
        ?>
        <td><input type="checkbox" name="tf_featured" id="tf_featured" value="1"<?php echo esc_html($checked);?>></td>
    </tr>
    <tr>
        <th class="metabox_label_column"><label for="tf_lightbox">Display in lightbox</th>
        <?php
        $checked = @get_post_meta($post->ID, 'tf_lightbox', true) ? ' checked="checked"' : '';
        ?>
        <td><input type="checkbox" name="tf_lightbox" id="tf_lightbox" value="1"<?php echo esc_html($checked);?>></td>
    </tr>
    <tr>
        <th class="metabox_label_column"><label for="tf_start_date">Start Date/Time</label></th>
        <td><input class="showDateTime startdate" type="text" name="tf_start_date" id="tf_start_date" value="<?php echo esc_html(@get_post_meta($post->ID, 'tf_start_date', true));?>"></td>
    </tr>
    <tr>
        <th class="metabox_label_column"><label for="tf_end_date">End Date/Time</label></th>
        <td><input class="showDateTime enddate" type="text" name="tf_end_date" id="tf_end_date" value="<?php echo esc_html(@get_post_meta($post->ID, 'tf_end_date', true));?>"></td>
    </tr>
    <tr>
        <th class="metabox_label_column"><label for="tf_display_date">Display Date/Time</label></th>
        <?php $disabled = @get_post_meta($post->ID, 'tf_display_date', true) == "" ? ' disabled="disabled"' : "";?>
        <td><input class="showDateTime displaydate" type="text" name="tf_display_date" id="tf_display_date" value="<?php echo esc_html(@get_post_meta($post->ID, 'tf_display_date', true));?>"<?php echo esc_html($disabled); ?>></td>
    </tr>
    <tr>
        <th class="metabox_label_column"><label for="tf_complete">Complete</th>
        <?php
        $checked = @get_post_meta($post->ID, 'tf_complete', true) ? ' checked="checked"' : '';
        ?>
        <td><input type="checkbox" name="tf_complete" id="tf_complete" value="1"<?php echo esc_html($checked);?>></td>
    </tr>
</table>