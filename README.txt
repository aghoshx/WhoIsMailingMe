=== WhoIsMailingMe ===
Contributors: Matsio
Tags: email, forms, gravity forms, contact form 7, signature, email signature
Requires at least: 4.7
Tested up to: 6.5
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add customizable email signatures to outgoing form emails to identify your website as the sender. Works with Gravity Forms, Contact Form 7, and more.

== Description ==

WhoIsMailingMe is a powerful yet easy-to-use plugin that adds customizable signatures to emails sent from your WordPress site. It helps recipients identify which website sent the form submission, enhancing brand recognition and professionalism in your communications.

= Key Features =

* **Multiple Form Support** - Works with Gravity Forms, Contact Form 7, and optionally all WordPress emails
* **Customizable Signature** - Create your own signature text with support for placeholders
* **HTML & Plain Text** - Automatically formats signatures appropriately for both HTML and plain text emails
* **Signature Position** - Choose to place the signature at the top or bottom of emails
* **Optional URL** - Include or exclude your website URL in the signature
* **Date & Time** - Optionally include the date and time when the email was sent
* **Custom CSS** - Add your own styling to HTML email signatures
* **Translation Ready** - Fully translatable into any language

== Installation ==

1. Upload the `whoismailingme` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > WhoIsMailingMe to configure your email signature preferences
4. The plugin will automatically apply your settings to emails sent through enabled form plugins

== Frequently Asked Questions ==

= Which form plugins are supported? =

The plugin currently supports Gravity Forms and Contact Form 7. You can also enable it for all WordPress emails, but this should be used with caution as it will affect system emails as well.

= Can I customize the signature message? =

Yes! You can fully customize your signature text from the Settings page. You can use placeholders like {site_name} and {site_url} in your signature. You can also control whether to include your website URL and the date/time when the email was sent.

= Can I position the signature at the top of the email instead of the bottom? =

Yes, you can choose whether the signature appears at the top or bottom of emails from the Settings page.

= Does this work with HTML emails? =

Yes, the plugin automatically detects whether an email is HTML or plain text and formats the signature accordingly. For HTML emails, you can even add custom CSS to style your signature.

= Will this affect my password reset and other system emails? =

By default, no. The WP Mail integration is disabled by default, and even when enabled, the plugin tries to exclude common system emails like password resets and user notifications.

== Changelog ==

= 1.0.0 =
* Complete redesign with new features
* Added settings page for customizing signatures
* Added support for Contact Form 7
* Added optional WordPress Mail integration
* Added HTML email support with custom CSS
* Added signature position options (top/bottom)
* Added date/time stamping option
* Added placeholder support in signature text
* Added translation support

= 0.1.0 =
* Initial basic release with Gravity Forms support only
