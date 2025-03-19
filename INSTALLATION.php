<?php
/**
 * WhoIsMailingMe Plugin Installation Instructions
 */
?>

=== INSTALLATION INSTRUCTIONS ===

1. Upload the entire 'whoismailingme' folder to the '/wp-content/plugins/' directory in your WordPress installation
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Once activated, you'll be automatically redirected to the settings page
4. Configure your email signature preferences
5. Your settings will be automatically applied to emails sent by your selected form plugins

=== CONFIGURATION ===

1. General Settings:
   - Customize your signature text (you can use {site_name} and {site_url} as placeholders)
   - Choose whether to include your website URL and/or date/time
   - Select where the signature appears (top or bottom of emails)

2. Form Support:
   - Enable or disable the plugin for specific form plugins
   - Gravity Forms and Contact Form 7 are supported by default
   - WordPress Mail integration is optional (use with caution)

3. Advanced Settings:
   - Add custom CSS to style HTML email signatures

=== TROUBLESHOOTING ===

- If the plugin doesn't add signatures to your emails, verify that the appropriate form plugin integration is enabled in settings
- For WordPress Mail integration, some system emails are intentionally excluded
- If using custom CSS, make sure it's valid and doesn't contain any errors
- Verify that your form plugin is sending emails correctly without the plugin before troubleshooting

=== SUPPORT ===

For support or questions, please contact the developer at support@matsio.com

--
WhoIsMailingMe Plugin Version 1.0.0
