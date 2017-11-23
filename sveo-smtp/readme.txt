=== Socialveo SMTP ===
Contributors: socialveo
Website: https://socialveo.com/
Tags: smtp, wp_mail, mailer, phpmailer, socialveo
Requires at least: 2.7
Tested up to: 4.9
Stable tag: 0.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Socialveo SMTP allows you to configure and send all outgoing emails via a SMTP server.

== Description ==

Socialveo SMTP allows you to configure and send all outgoing emails via a SMTP server. 

You can set the following options:

* Set the from name and email address for outgoing email
* Set the reply to email address
* Set an SMTP host
* Set an SMTP port
* Set SSL / TLS encryption
* Set to use SMTP authentication
* Set an SMTP username and password

Works with any email sending service that offers SMTP.

= Why use SMTP? =

This plugin will prevent your emails from going into the junk/spam folder of the recipients.
Email sent by WordPress use PHP mail() function, and often the email go in the spam folder or get completely rejected by popular email providers.
SMTP (Simple Mail Transfer Protocol) is the industry standard for sending emails. 
This plugin helps you use proper authentication which increases email deliverability.

= Why use this SMTP plugin? =

There are many WP plugins for SMTP, but this one aim to be simple by using lightweight code (single file less than 4KB), without storing anything on database, but doing configuration only via wp-config.php. Also there is not complete override of wp_mail() function like other plugins, but it's used only hook for add additional functionality; this allow easy upgrade to future version of WP.

= Credits =

It is maintained by the team behind <a href="https://socialveo.com/" rel="friend">Socialveo</a>.

= What's Next =

Add HTML email templates to all wordpress emails.

== Installation ==

1. Install plugin, see instructions on <a href="http://www.wpbeginner.com/beginners-guide/step-by-step-guide-to-install-a-wordpress-plugin-for-beginners/" rel="friend">how to install a WordPress plugin</a>.
2. Activate 
3. Open your wp-config.php and add below setting:

define('SVEO_SMTP_ENABLE', true); // Enable/disable SMTP
define('SVEO_SMTP_FROM_MAIL', 'noreply@my-domain.com'); // Set From email
define('SVEO_SMTP_FROM_NAME', 'My Sitename'); // Set From name
define('SVEO_SMTP_REPLY_TO_MAIL', 'reply@my-domain.com'); // Optionally set different reply to
define('SVEO_SMTP_REPLY_TO_NAME', 'My Sitename'); // Optionally set different reply to
define('SVEO_SMTP_HOST', 'localhost'); // The SMTP mail host
define('SVEO_SMTP_PORT', 25); // The SMTP server port number, defaults to 465 if encryption is ssl and 25 otherwise
define('SVEO_SMTP_ENCRYPTION', ''); // 'ssl', 'tls' or ''
define('SVEO_SMTP_AUTH', true); // Enable/disable SMTP authentication
define('SVEO_SMTP_USER', 'username'); // SMTP authentication username - used when SVEO_SMTP_AUTH is true
define('SVEO_SMTP_PASS', 'password'); // SMTP authentication password - used when SVEO_SMTP_AUTH is true

== Frequently Asked Questions ==

= My plugin still sends mail via the mail() function =

If other plugins you're using are not coded to use the wp_mail() function but instead call PHP's mail() function directly, they will bypass the settings of this plugin.

= More questions? =

You can get in touch with us via: <a href="https://github.com/socialveo/socialveo-wp/issues" rel="friend">github.com/socialveo/socialveo-wp/issues</a>

== Changelog ==

= [0.0.1] - 2017-11-20 =
* First release
