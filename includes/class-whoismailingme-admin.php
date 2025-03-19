<?php
/**
 * WhoIsMailingMe Admin Class
 *
 * @package WhoIsMailingMe
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin functionality for WhoIsMailingMe
 */
class WhoIsMailingMe_Admin {

    /**
     * Settings array
     *
     * @var array
     */
    private $settings;

    /**
     * Constructor
     *
     * @param array $settings Plugin settings
     */
    public function __construct($settings) {
        $this->settings = $settings;

        // Register admin scripts and styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));

        // Add settings page
        add_action('admin_menu', array($this, 'add_settings_page'));
        
        // Register settings
        add_action('admin_init', array($this, 'register_settings'));

        // Add plugin action links
        add_filter('plugin_action_links_' . WIMM_PLUGIN_BASENAME, array($this, 'add_plugin_action_links'));
    }

    /**
     * Enqueue admin scripts and styles
     *
     * @param string $hook Current admin page
     */
    public function enqueue_admin_assets($hook) {
        // Only load on our settings page
        if ('settings_page_whoismailingme' !== $hook) {
            return;
        }

        // Enqueue our admin CSS
        wp_enqueue_style(
            'whoismailingme-admin',
            WIMM_PLUGIN_URL . 'assets/css/admin-style.css',
            array(),
            WIMM_VERSION
        );

        // Enqueue our admin JS
        wp_enqueue_script(
            'whoismailingme-admin',
            WIMM_PLUGIN_URL . 'assets/js/admin-script.js',
            array('jquery'),
            WIMM_VERSION,
            true
        );

        // Localize script with data
        wp_localize_script(
            'whoismailingme-admin',
            'whoismailingme_data',
            array(
                'site_name' => get_bloginfo('name'),
                'site_url' => get_bloginfo('url'),
                'current_date' => date_i18n(get_option('date_format') . ' ' . get_option('time_format'), current_time('timestamp')),
            )
        );
    }

    /**
     * Add settings page to admin menu
     */
    public function add_settings_page() {
        add_options_page(
            __('WhoIsMailingMe Settings', 'whoismailingme'),
            __('WhoIsMailingMe', 'whoismailingme'),
            'manage_options',
            'whoismailingme',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting(
            'whoismailingme_settings',
            'whoismailingme_settings',
            array($this, 'validate_settings')
        );

        // General Settings Section
        add_settings_section(
            'whoismailingme_general_section',
            __('General Settings', 'whoismailingme'),
            array($this, 'render_general_section'),
            'whoismailingme'
        );

        // Signature Settings
        add_settings_field(
            'signature_text',
            __('Signature Text', 'whoismailingme'),
            array($this, 'render_signature_text_field'),
            'whoismailingme',
            'whoismailingme_general_section'
        );

        add_settings_field(
            'include_url',
            __('Include Website URL', 'whoismailingme'),
            array($this, 'render_include_url_field'),
            'whoismailingme',
            'whoismailingme_general_section'
        );

        add_settings_field(
            'include_date',
            __('Include Date & Time', 'whoismailingme'),
            array($this, 'render_include_date_field'),
            'whoismailingme',
            'whoismailingme_general_section'
        );

        add_settings_field(
            'signature_position',
            __('Signature Position', 'whoismailingme'),
            array($this, 'render_signature_position_field'),
            'whoismailingme',
            'whoismailingme_general_section'
        );

        // Form Support Section
        add_settings_section(
            'whoismailingme_form_support_section',
            __('Form Support', 'whoismailingme'),
            array($this, 'render_form_support_section'),
            'whoismailingme'
        );

        add_settings_field(
            'enable_gravity_forms',
            __('Gravity Forms', 'whoismailingme'),
            array($this, 'render_enable_gravity_forms_field'),
            'whoismailingme',
            'whoismailingme_form_support_section'
        );

        add_settings_field(
            'enable_contact_form_7',
            __('Contact Form 7', 'whoismailingme'),
            array($this, 'render_enable_contact_form_7_field'),
            'whoismailingme',
            'whoismailingme_form_support_section'
        );

        add_settings_field(
            'enable_wp_mail',
            __('WordPress Mail', 'whoismailingme'),
            array($this, 'render_enable_wp_mail_field'),
            'whoismailingme',
            'whoismailingme_form_support_section'
        );

        // Advanced Section
        add_settings_section(
            'whoismailingme_advanced_section',
            __('Advanced Settings', 'whoismailingme'),
            array($this, 'render_advanced_section'),
            'whoismailingme'
        );

        add_settings_field(
            'custom_css',
            __('Custom CSS', 'whoismailingme'),
            array($this, 'render_custom_css_field'),
            'whoismailingme',
            'whoismailingme_advanced_section'
        );
    }

    /**
     * Render general section
     */
    public function render_general_section() {
        echo '<p>' . __('Configure how your email signature will appear.', 'whoismailingme') . '</p>';
    }

    /**
     * Render form support section
     */
    public function render_form_support_section() {
        echo '<p>' . __('Choose which form plugins should include your signature.', 'whoismailingme') . '</p>';
    }

    /**
     * Render advanced section
     */
    public function render_advanced_section() {
        echo '<p>' . __('Advanced customization options.', 'whoismailingme') . '</p>';
    }

    /**
     * Render signature text field
     */
    public function render_signature_text_field() {
        $signature_text = isset($this->settings['signature_text']) ? $this->settings['signature_text'] : '';
        echo '<textarea name="whoismailingme_settings[signature_text]" rows="3" cols="50">' . esc_textarea($signature_text) . '</textarea>';
        echo '<p class="description">' . __('The text that will appear in your email signature. Use {site_name} for your site name and {site_url} for your site URL.', 'whoismailingme') . '</p>';
    }

    /**
     * Render include URL field
     */
    public function render_include_url_field() {
        $include_url = isset($this->settings['include_url']) ? $this->settings['include_url'] : 'yes';
        echo '<label><input type="checkbox" name="whoismailingme_settings[include_url]" value="yes" ' . checked('yes', $include_url, false) . ' /> ' . __('Include website URL in signature', 'whoismailingme') . '</label>';
    }

    /**
     * Render include date field
     */
    public function render_include_date_field() {
        $include_date = isset($this->settings['include_date']) ? $this->settings['include_date'] : 'no';
        echo '<label><input type="checkbox" name="whoismailingme_settings[include_date]" value="yes" ' . checked('yes', $include_date, false) . ' /> ' . __('Include date and time when email was sent', 'whoismailingme') . '</label>';
    }

    /**
     * Render signature position field
     */
    public function render_signature_position_field() {
        $signature_position = isset($this->settings['signature_position']) ? $this->settings['signature_position'] : 'bottom';
        echo '<select name="whoismailingme_settings[signature_position]">';
        echo '<option value="bottom" ' . selected('bottom', $signature_position, false) . '>' . __('Bottom of email (after message)', 'whoismailingme') . '</option>';
        echo '<option value="top" ' . selected('top', $signature_position, false) . '>' . __('Top of email (before message)', 'whoismailingme') . '</option>';
        echo '</select>';
    }

    /**
     * Render Gravity Forms field
     */
    public function render_enable_gravity_forms_field() {
        $enable_gravity_forms = isset($this->settings['enable_gravity_forms']) ? $this->settings['enable_gravity_forms'] : 'yes';
        echo '<label><input type="checkbox" name="whoismailingme_settings[enable_gravity_forms]" value="yes" ' . checked('yes', $enable_gravity_forms, false) . ' /> ' . __('Enable for Gravity Forms emails', 'whoismailingme') . '</label>';
        
        if (!class_exists('GFCommon')) {
            echo '<p class="description" style="color: #d63638;">' . __('Gravity Forms is not active on this site.', 'whoismailingme') . '</p>';
        }
    }

    /**
     * Render Contact Form 7 field
     */
    public function render_enable_contact_form_7_field() {
        $enable_contact_form_7 = isset($this->settings['enable_contact_form_7']) ? $this->settings['enable_contact_form_7'] : 'yes';
        echo '<label><input type="checkbox" name="whoismailingme_settings[enable_contact_form_7]" value="yes" ' . checked('yes', $enable_contact_form_7, false) . ' /> ' . __('Enable for Contact Form 7 emails', 'whoismailingme') . '</label>';
        
        if (!class_exists('WPCF7')) {
            echo '<p class="description" style="color: #d63638;">' . __('Contact Form 7 is not active on this site.', 'whoismailingme') . '</p>';
        }
    }

    /**
     * Render WordPress Mail field
     */
    public function render_enable_wp_mail_field() {
        $enable_wp_mail = isset($this->settings['enable_wp_mail']) ? $this->settings['enable_wp_mail'] : 'no';
        echo '<label><input type="checkbox" name="whoismailingme_settings[enable_wp_mail]" value="yes" ' . checked('yes', $enable_wp_mail, false) . ' /> ' . __('Enable for all WordPress emails (use with caution)', 'whoismailingme') . '</label>';
        echo '<p class="description" style="color: #856404; background-color: #fff3cd; padding: 10px; border-left: 4px solid #ffeeba;">' . __('This will add your signature to ALL emails sent by WordPress, including password resets, notifications, etc. Use with caution and test thoroughly.', 'whoismailingme') . '</p>';
    }

    /**
     * Render custom CSS field
     */
    public function render_custom_css_field() {
        $custom_css = isset($this->settings['custom_css']) ? $this->settings['custom_css'] : '';
        echo '<textarea name="whoismailingme_settings[custom_css]" rows="5" cols="50" class="large-text code custom-css">' . esc_textarea($custom_css) . '</textarea>';
        echo '<p class="description">' . __('Add custom CSS for HTML email signatures. Only applies to HTML emails.', 'whoismailingme') . '</p>';
    }

    /**
     * Validate settings
     *
     * @param array $input Input settings
     * @return array Validated settings
     */
    public function validate_settings($input) {
        $validated_input = array();

        // Validate signature text
        $validated_input['signature_text'] = isset($input['signature_text']) ? wp_kses_post(trim($input['signature_text'])) : '';

        // Validate checkboxes
        $checkboxes = array('include_url', 'include_date', 'enable_gravity_forms', 'enable_contact_form_7', 'enable_wp_mail');
        foreach ($checkboxes as $checkbox) {
            $validated_input[$checkbox] = isset($input[$checkbox]) && 'yes' === $input[$checkbox] ? 'yes' : 'no';
        }

        // Validate signature position
        $validated_input['signature_position'] = isset($input['signature_position']) && in_array($input['signature_position'], array('top', 'bottom'), true) ? $input['signature_position'] : 'bottom';

        // Validate custom CSS
        $validated_input['custom_css'] = isset($input['custom_css']) ? sanitize_textarea_field($input['custom_css']) : '';

        return $validated_input;
    }

    /**
     * Render settings page
     */
    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }

        if (isset($_GET['settings-updated'])) {
            add_settings_error('whoismailingme_messages', 'whoismailingme_message', __('Settings Saved', 'whoismailingme'), 'updated');
        }

        settings_errors('whoismailingme_messages');
        ?>
        <div class="wrap whoismailingme-settings-wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <div class="whoismailingme-header">
                <h2><?php _e('Add Professional Email Signatures to Your Forms', 'whoismailingme'); ?></h2>
                <p><?php _e('WhoIsMailingMe lets you add customizable signatures to emails sent by your forms, helping recipients identify your website as the sender.', 'whoismailingme'); ?></p>
            </div>
            
            <form action="options.php" method="post">
                <?php
                settings_fields('whoismailingme_settings');
                do_settings_sections('whoismailingme');
                
                // Add signature preview
                $this->render_signature_preview();
                
                submit_button(__('Save Settings', 'whoismailingme'));
                ?>
            </form>
            
            <div class="whoismailingme-support">
                <h3><?php _e('Support & Feedback', 'whoismailingme'); ?></h3>
                <p><?php _e('If you have any questions or feedback about this plugin, please contact the developer at', 'whoismailingme'); ?> <a href="mailto:support@matsio.com">support@matsio.com</a></p>
            </div>
        </div>
        <?php
    }

    /**
     * Render signature preview
     */
    private function render_signature_preview() {
        ?>
        <div class="whoismailingme-preview">
            <div class="whoismailingme-preview-header">
                <?php _e('Signature Preview:', 'whoismailingme'); ?>
            </div>
            <div class="whoismailingme-preview-content">
                <!-- Preview content will be populated by JavaScript -->
            </div>
            <p class="description"><?php _e('This is a preview of how your signature will appear in HTML emails. Plain text emails will have similar content but without formatting.', 'whoismailingme'); ?></p>
        </div>
        <?php
    }

    /**
     * Add plugin action links
     *
     * @param array $links Existing action links
     * @return array Modified action links
     */
    public function add_plugin_action_links($links) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=whoismailingme') . '">' . __('Settings', 'whoismailingme') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
}
