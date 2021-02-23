<?php

/**
 * Prikr Nofollow Links
 *
 * Plugin Name:       Prikr Nofollow Links
 * Plugin URI:        https://prikr.io/wordpress-plugins
 * Description:       Automaticly adds rel="no-follow" to content and navigation links in widgets
 * Version:           1.2
 * Requires at least: 5.6
 * Requires PHP:      7.2
 * Author:            Jasper van Doorn
 * Author URI:        https://prikr.io/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       prikr
 */

defined('ABSPATH') || exit;

/**
 * Update all navigation menus by importing a Custom Walker and active it
 */
function prikr_add_nofollow_links()
{
  // Import functions
  require plugin_dir_path(__FILE__) . '/functions.php';
}
add_action('init', 'prikr_add_nofollow_links');


/**
 * Activate the plugin.
 */
function prikr_activate()
{
  prikr_add_nofollow_links();

  flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'prikr_activate');

/**
 * Deactivation hook.
 */
function prikr_deactivate()
{
  flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'prikr_deactivate');
