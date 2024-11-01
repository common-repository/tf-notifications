=== TF Notifications ===
Contributors: timfitt
Donate link: https://paypal.me/timfitt
Tags: notifications
Requires at least: 3.0.1
Tested up to: 6.2
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Keep your visitors up to date with notifications across your organisation.

== Description ==

Keep your visitors up to date with notifications across your organisation.

**Shortcodes**

[tf_important_notification speed=4000]

The above shortcode will display your notifications that have been flagged as "Featured".

This example waits 4 seconds before fading out and then in to the next notification.

[tf_notification_table count=3]

This shortcode displays a table of all current and past notifications.

The example above will only show the latest 3 current notifications, and the last 3 past notifications.

== Installation ==

1. Unzip and upload `tf-notifications` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Where can I find more information? =

https://timfitt.com/wordpress/plugins/tf-notifications

== Screenshots ==

1. Click "Notifications" in the WordPress administration navigation (1).
Click "Add New" (2).
2. Enter a title (3).
Enter the notification main content (4).
If using the lightbox feature, enter the content to be displayed in the lightbox to the Excerpt (5).
Check "Featured" (6) to include the notification in the featured shortcode.
Check "Display in lightbox" (7) to include the notification in a lightbox.
Select a start date (8) to show when the notification begins.
Select an end date (9)  to show when the notification ends.
If you would like to show the notification outside of the start/end dates, select a "Display Date/Time" (10).
When the notification is finished, select "Complete" (11).
Enter or select a reason for the notification (12).
Enter or select who will be affected by the notification (13).
3. Notification archive page.
4. "Featured" shortcode - fading between notifications.
5. Show notifications in a table using table shortcode.
6. "Show in lightbox".

== Changelog ==

= 1.1.1 =
* Added tf_notification_table shortcode
* Tested in Wordpress 6.2

= 1.1.0 =
* Rewrite entire plugin to use PHP classes.
* Remove page templates.

= 1.0.1 =
* Check that plugin works in WP 6.1.1.

= 1.0 =
* Creation of plugin.

== Upgrade Notice ==

= 1.1.1 =
Tested for Wordpress 6.2 compatibility.

= 1.1.0 =
Total rewrite of plugin to meet modern standards.

= 1.0 =
Creation of plugin.