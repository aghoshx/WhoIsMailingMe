<?php
/**
 * Main WhoIsMailingMe Plugin Class
 *
 * @package WhoIsMailingMe
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main WhoIsMailingMe Plugin Class
 */
class WhoIsMailingMe
{

    /**
     * Singleton instance
     *
     * @var WhoIsMailingMe
     */
    private static $instance = null;

    /**
     * Plugin settings
     *
     * @var array
     */
    private $settings;

    /**
     * Admin instance
     * 
     * @var WhoIsMailingMe_Admin
     */
    private $admin;

    /**
     * Mail instance
     * 
     * @var WhoIsMailingMe_Mail
     */
    private $mail;

    /**
     * Get singleton instance
     *
     * @return WhoIsMailingMe
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        // Load plugin text domain
        add_action('init', array($this, 'load_textdomain'));

        // Initialize settings
        $this->init_settings();

        // Initialize classes
        $this->init_classes();
    }

    /**
     * Load plugin text domain
     */
    public function load_textdomain() {
        load_plugin_textdomain('whoismailingme', false, dirname(WIMM_PLUGIN_BASENAME) . '/languages');
    }

    /**
     * Initialize plugin settings
     */
    private function init_settings() {
        $default_settings = array(
            'signature_text' => sprintf(__('-- Message sent from %s', 'whoismailingme'), get_bloginfo('name')),
            'include_url' => 'yes',
            'include_date' => 'no',
            'enable_gravity_forms' => 'yes',
            'enable_contact_form_7' => 'yes',
            'enable_wp_mail' => 'no',
            'signature_position' => 'bottom',
            'custom_css' => ''
        );

        $this->settings = get_option('whoismailingme_settings', $default_settings);
    }

    /**
     * Initialize admin and mail classes
     */
    private function init_classes() {
        // Include required files
        require_once WIMM_PLUGIN_DIR . 'includes/class-whoismailingme-admin.php';
        require_once WIMM_PLUGIN_DIR . 'includes/class-whoismailingme-mail.php';

        // Initialize Admin class if we're in admin area
        if (is_admin()) {
            $this->admin = new WhoIsMailingMe_Admin($this->settings);
        }

        // Initialize Mail class
        $this->mail = new WhoIsMailingMe_Mail($this->settings);
    }
}
