# WhoIsMailingMe 📧

![Version](https://img.shields.io/badge/Version-1.0.0-brightgreen)
![WordPress](https://img.shields.io/badge/WordPress-6.0+-blue)
![PHP](https://img.shields.io/badge/PHP-7.4+-purple)
![License](https://img.shields.io/badge/License-GPL--2.0-orange)

## 🚀 Never Let Recipients Wonder Which Site Sent That Email Again

**WhoIsMailingMe** is a solution for developers managing multiple websites to identify the source of contact form submissions.

## Problem Statement

Managing several websites often leads to uncertainty about the origin of contact form submissions. This tool addresses that issue by:

- Embedding a unique identifier in each contact form.
- Including this identifier in the email subject line upon form submission.
- Allowing you to instantly recognize which site the email originated from.

### ✨ Key Features

- **🎯 Multiple Form Support** - Works seamlessly with Gravity Forms, Contact Form 7, and more
- **📝 Customizable Signatures** - Create your perfect signature with support for placeholders
- **🌐 HTML & Plain Text** - Automatically formats signatures for both HTML and plain text emails
- **📍 Flexible Positioning** - Place signatures at the top or bottom of emails
- **🔗 URL Inclusion** - Choose whether to include your website URL
- **🕒 Date & Time Stamping** - Optionally include when the email was sent
- **🎨 Custom CSS** - Add your own styling to HTML email signatures
- **🌍 Translation Ready** - Fully translatable to any language

## 📋 Table of Contents

- [Installation](#-installation)
- [Configuration](#-configuration)
- [Screenshots](#-screenshots)
- [Frequently Asked Questions](#-frequently-asked-questions)
- [Support](#-support)
- [Contributing](#-contributing)
- [License](#-license)

## 📥 Installation

### Automatic Installation (Recommended)

1. In your WordPress admin, go to **Plugins > Add New**
2. Search for "WhoIsMailingMe"
3. Click "Install Now" and then "Activate"
4. You'll be automatically redirected to the settings page

### Manual Installation

1. Download the plugin ZIP file
2. In your WordPress admin, go to **Plugins > Add New > Upload Plugin**
3. Upload the ZIP file and click "Install Now"
4. Activate the plugin

## ⚙️ Configuration

### General Settings

<p align="center">
  <img src="https://via.placeholder.com/600x350/ffffff/45aaf2?text=General+Settings+Screenshot" alt="General Settings">
</p>

- **Signature Text**: Customize your signature text with support for the following placeholders:
  - `{site_name}` - Your website name
  - `{site_url}` - Your website URL
- **Include Website URL**: Toggle to include or exclude your website URL in the signature
- **Include Date & Time**: Choose to show when the email was sent
- **Signature Position**: Place your signature at the top or bottom of emails

### Form Support

<p align="center">
  <img src="https://via.placeholder.com/600x350/ffffff/45aaf2?text=Form+Support+Screenshot" alt="Form Support">
</p>

- **Gravity Forms**: Enable signatures for all Gravity Forms notifications
- **Contact Form 7**: Add signatures to Contact Form 7 emails
- **WordPress Mail**: Optionally add signatures to all WordPress emails (use with caution)

### Advanced Settings

<p align="center">
  <img src="https://via.placeholder.com/600x350/ffffff/45aaf2?text=Advanced+Settings+Screenshot" alt="Advanced Settings">
</p>

- **Custom CSS**: Add your own CSS to style HTML email signatures

## 📸 Screenshots

### Email Signature Example

<p align="center">
  <img src="https://via.placeholder.com/600x350/ffffff/45aaf2?text=Email+Signature+Example" alt="Email Signature Example">
</p>

### Settings Page

<p align="center">
  <img src="https://via.placeholder.com/600x350/ffffff/45aaf2?text=Settings+Page" alt="Settings Page">
</p>

## ❓ Frequently Asked Questions

### Which form plugins are supported?

The plugin currently supports Gravity Forms and Contact Form 7. You can also enable it for all WordPress emails, but this should be used with caution as it will affect system emails as well.

### Can I customize the signature message?

Yes! You can fully customize your signature text from the Settings page. You can use placeholders like `{site_name}` and `{site_url}` in your signature. You can also control whether to include your website URL and the date/time when the email was sent.

### Can I position the signature at the top of the email instead of the bottom?

Yes, you can choose whether the signature appears at the top or bottom of emails from the Settings page.

### Does this work with HTML emails?

Yes, the plugin automatically detects whether an email is HTML or plain text and formats the signature accordingly. For HTML emails, you can even add custom CSS to style your signature.

### Will this affect my password reset and other system emails?

By default, no. The WP Mail integration is disabled by default, and even when enabled, the plugin tries to exclude common system emails like password resets and user notifications. However, if you enable the WordPress Mail option, we recommend thoroughly testing to ensure it works as expected with your specific setup.

## 🆘 Support

Need help? We're here for you!

- **Email Support**: [hello+whoismailingme@matsio.com](mailto:hello+whoismailingme@matsio.com)

## 🤝 Contributing

We welcome contributions to make WhoIsMailingMe even better!

1. Fork the repository
2. Create your feature branch: `git checkout -b feature/my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin feature/my-new-feature`
5. Submit a pull request

## 📄 License

This project is licensed under the GPL-2.0 License - see the [LICENSE](LICENSE) file for details.

---

<p align="center">
  Made with ❤️ by <a href="https://matsio.com">Matsio</a>
</p>

<p align="center">
  <a href="https://www.instagram.com/matsiodigital/">Instagram</a> •
  <a href="https://in.linkedin.com/company/matsiodigital">LinkedIn</a> •
  <a href="https://x.com/matsiodigital">Twitter</a>
</p>
