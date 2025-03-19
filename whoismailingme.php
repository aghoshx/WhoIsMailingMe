<?php
/**
 * Plugin Name: WhoIsMailingMe
 * Plugin URI: https://lawpunditsglobal.com
 * Description: Add customizable email signatures to outgoing form emails to identify your website as the sender. Works with Gravity Forms, Contact Form 7, and more.
 * Author: Matsio
 * Author URI: https://matsio.com/whoismailingme
 * Text Domain: whoismailingme
 * Domain Path: /languages
 * Version: 1.0.0
 *
 * @package WhoIsMailingMe
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WIMM_VERSION', '1.0.0');
define('WIMM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WIMM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WIMM_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Include main plugin class
require_once WIMM_PLUGIN_DIR . 'includes/class-whoismailingme.php';

/**
 * Initialize plugin
 *
 * @return WhoIsMailingMe Main plugin instance
 */
function whoismailingme_init() {
    return WhoIsMailingMe::get_instance();
}

// Initialize plugin
add_action('plugins_loaded', 'whoismailingme_init');

// Register activation hook
register_activation_hook(__FILE__, 'whoismailingme_activate');

/**
 * Plugin activation
 */
function whoismailingme_activate() {
    // Add default settings if they don't exist
    if (!get_option('whoismailingme_settings')) {
        $default_settings = array(
            'signature_text' => sprintf('-- Message sent from %s', get_bloginfo('name')),
            'include_url' => 'yes',
            'include_date' => 'no',
            'enable_gravity_forms' => 'yes',
            'enable_contact_form_7' => 'yes',
            'enable_wp_mail' => 'no',
            'signature_position' => 'bottom',
            'custom_css' => ''
        );
        update_option('whoismailingme_settings', $default_settings);
    }

    // Create a transient to redirect to settings page
    set_transient('whoismailingme_activation_redirect', true, 30);
}

// Redirect to settings page after activation
add_action('admin_init', 'whoismailingme_activation_redirect');

/**
 * Redirect to settings page after activation
 */
function whoismailingme_activation_redirect() {
    // Check if we should redirect
    if (get_transient('whoismailingme_activation_redirect')) {
        // Delete the transient
        delete_transient('whoismailingme_activation_redirect');

        // Make sure it's the correct page
        if (isset($_GET['activate-multi']) || !current_user_can('manage_options')) {
            return;
        }

        // Redirect to settings page
        wp_safe_redirect(admin_url('options-general.php?page=whoismailingme'));
        exit;
    }
}
