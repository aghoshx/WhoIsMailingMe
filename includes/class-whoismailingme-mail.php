<?php
/**
 * WhoIsMailingMe Mail Class
 *
 * @package WhoIsMailingMe
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Mail functionality for WhoIsMailingMe
 */
class WhoIsMailingMe_Mail
{

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

        // Add hooks for various form plugins
        $this->add_form_hooks();
    }

    /**
     * Add hooks for various form plugins
     */
    private function add_form_hooks() {
        // Gravity Forms
        if (isset($this->settings['enable_gravity_forms']) && 'yes' === $this->settings['enable_gravity_forms']) {
            add_filter('gform_notification', array($this, 'add_signature_to_gravity_forms'), 10, 3);
        }

        // Contact Form 7
        if (isset($this->settings['enable_contact_form_7']) && 'yes' === $this->settings['enable_contact_form_7']) {
            add_filter('wpcf7_mail_components', array($this, 'add_signature_to_contact_form_7'), 10, 3);
        }

        // WordPress Mail
        if (isset($this->settings['enable_wp_mail']) && 'yes' === $this->settings['enable_wp_mail']) {
            add_filter('wp_mail', array($this, 'add_signature_to_wp_mail'));
        }
    }

    /**
     * Get the formatted signature based on settings
     *
     * @param bool $html Whether to format for HTML
     * @return string Formatted signature
     */
    private function get_formatted_signature($html = false) {
        $signature = isset($this->settings['signature_text']) ? $this->settings['signature_text'] : '';

        // Replace placeholders
        $signature = str_replace('{site_name}', get_bloginfo('name'), $signature);
        $signature = str_replace('{site_url}', get_bloginfo('url'), $signature);

        // Add URL if enabled
        if (isset($this->settings['include_url']) && 'yes' === $this->settings['include_url']) {
            if ($html) {
                $signature .= '<br><a href="' . esc_url(get_bloginfo('url')) . '">' . esc_html(get_bloginfo('url')) . '</a>';
            } else {
                $signature .= "" . get_bloginfo('url');
            }
        }

        // Add date if enabled
        if (isset($this->settings['include_date']) && 'yes' === $this->settings['include_date']) {
            $date_format = get_option('date_format') . ' ' . get_option('time_format');
            $current_time = current_time('timestamp');
            if ($html) {
                $signature .= '<br>' . sprintf(__('Sent on: %s', 'whoismailingme'), date_i18n($date_format, $current_time));
            } else {
                $signature .= "" . sprintf(__('Sent on: %s', 'whoismailingme'), date_i18n($date_format, $current_time));
            }
        }

        // Format for HTML if needed
        if ($html) {
            $custom_css = isset($this->settings['custom_css']) ? $this->settings['custom_css'] : '';
            $signature = '<div class="email-signature" style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #ccc;">' . $signature . '</div>';
            if (!empty($custom_css)) {
                $signature = '<style>' . $custom_css . '</style>' . $signature;
            }
        } else {
            $signature = "" . $signature;
        }

        return $signature;
    }

    /**
     * Add signature to Gravity Forms notifications
     *
     * @param array $notification The notification object
     * @param array $form The form object
     * @param array $entry The entry object
     * @return array Modified notification object
     */
    public function add_signature_to_gravity_forms($notification, $form, $entry) {
        $is_html = isset($notification['message_format']) && 'html' === $notification['message_format'];
        $signature = $this->get_formatted_signature($is_html);

        if (isset($this->settings['signature_position']) && 'top' === $this->settings['signature_position']) {
            $notification['message'] = $signature . $notification['message'];
        } else {
            $notification['message'] .= $signature;
        }

        return $notification;
    }

    /**
     * Add signature to Contact Form 7 emails
     *
     * @param array $components Mail components
     * @param object $contact_form Contact form object
     * @param object $mail Mail object
     * @return array Modified mail components
     */
    public function add_signature_to_contact_form_7($components, $contact_form, $mail) {
        $is_html = isset($components['html']) && $components['html'];
        $signature = $this->get_formatted_signature($is_html);

        if (isset($this->settings['signature_position']) && 'top' === $this->settings['signature_position']) {
            $components['body'] = $signature . $components['body'];
        } else {
            $components['body'] .= $signature;
        }

        return $components;
    }

    /**
     * Add signature to WordPress mail
     *
     * @param array $mail Mail data
     * @return array Modified mail data
     */
    public function add_signature_to_wp_mail($mail) {
        // Check if it's a system email we should exclude
        $system_emails = array(
            '[WordPress]',
            'Action: reset_password',
            'Action: welcome_user',
            'Action: welcome_admin',
            'Action: new_user',
            'Password Reset',
            'Your new password',
            '[%s] Password Reset',
            '[%s] Your username and password info'
        );

        foreach ($system_emails as $system_email) {
            if (isset($mail['subject'])) {
                // Check for direct match
                if (false !== strpos($mail['subject'], $system_email)) {
                    return $mail;
                }

                // Check for sprintf formatted strings
                if (false !== strpos($system_email, '%s')) {
                    $site_name = get_bloginfo('name');
                    $formatted_subject = sprintf($system_email, $site_name);
                    if (false !== strpos($mail['subject'], $formatted_subject)) {
                        return $mail;
                    }
                }
            }
        }

        // Determine if the email is HTML
        $is_html = false;
        if (isset($mail['headers'])) {
            if (is_array($mail['headers'])) {
                foreach ($mail['headers'] as $header) {
                    if (false !== strpos($header, 'text/html')) {
                        $is_html = true;
                        break;
                    }
                }
            } elseif (is_string($mail['headers']) && false !== strpos($mail['headers'], 'text/html')) {
                $is_html = true;
            }
        }

        $signature = $this->get_formatted_signature($is_html);

        if (isset($this->settings['signature_position']) && 'top' === $this->settings['signature_position']) {
            $mail['message'] = $signature . $mail['message'];
        } else {
            $mail['message'] .= $signature;
        }

        return $mail;
    }
}
