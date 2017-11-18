<?php
/**
 * Plugin Name: Socialveo SMTP
 * Contributors: Socialveo Team
 * Version: 1.0.0
 * Plugin URI: https://github.com/socialveo/socialveo-wp/sveo-smtp/
 * Description: Socialveo SMTP allows you to configure and send all outgoing emails via a SMTP server
 * Author: Socialveo Sagl
 * Author URI: https://socialveo.com/
 */

/****************************************************************************************************************

Configure SMTP via wp-config.php

define('SVEO_SMTP_ENABLE', true); // Enable/disable SMTP
define('SVEO_SMTP_FROM_MAIL', 'noreply@my-domain.com'); // Set From email
define('SVEO_SMTP_FROM_NAME', 'My Sitename'); // Set From name
define('SVEO_SMTP_REPLY_TO_MAIL', 'reply@my-domain.com'); // Optionally set different reply to
define('SVEO_SMTP_REPLY_TO_NAME', 'Reply to Name'); // Optionally set different reply to
define('SVEO_SMTP_HOST', 'localhost'); // The SMTP mail host
define('SVEO_SMTP_PORT', 25); // The SMTP server port number, defaults to 465 if encryption is ssl and 25 otherwise
define('SVEO_SMTP_ENCRYPTION', ''); // 'ssl', 'tls' or ''
define('SVEO_SMTP_AUTH', true); // Enable/disable SMTP authentication
define('SVEO_SMTP_USER', 'username'); // SMTP authentication username - used when SVEO_SMTP_AUTH is true
define('SVEO_SMTP_PASS', 'password'); // SMTP authentication password - used when SVEO_SMTP_AUTH is true

****************************************************************************************************************/

/**
 * Configure phpmailer to use SMTP via hook phpmailer_init
 *
 * @param PHPMailer $phpmailer It's passed by reference, so no need to return anything.
 */
add_action('phpmailer_init', function($phpmailer) {

	/**
	 * If smtp is enabled, configure it
	 */
	if (defined('SVEO_SMTP_ENABLE') && SVEO_SMTP_ENABLE) {

		$phpmailer->Mailer = 'smtp';

		if (defined('SVEO_SMTP_REPLY_TO_MAIL')) {
			$phpmailer->AddReplyTo(SVEO_SMTP_REPLY_TO_MAIL, SVEO_SMTP_REPLY_TO_NAME);
		}

		$phpmailer->SMTPSecure = SVEO_SMTP_ENCRYPTION;
		$phpmailer->Host = SVEO_SMTP_HOST;
		$phpmailer->Port = SVEO_SMTP_PORT;

		if (defined('SVEO_SMTP_AUTH') && SVEO_SMTP_AUTH && defined('SVEO_SMTP_USER') && defined('SVEO_SMTP_PASS')) {
			$phpmailer->SMTPAuth = true;
			$phpmailer->Username = SVEO_SMTP_USER;
			$phpmailer->Password = SVEO_SMTP_PASS;
		}
	} else return;

	/**
	 * Add your own options using below filter, see the phpmailer documentation for more info: http://phpmailer.sourceforge.net/docs/
	 * @noinspection PhpUnusedLocalVariableInspection It's passed by reference.
	 */
	$phpmailer = apply_filters('sveo_smtp_custom_options', $phpmailer);
});

/**
 * Change the default 'wordpress@site-name.com' from email
 *
 * @param string $default
 * @return string
 */
add_filter('wp_mail_from', function($default) {

	// When it's used via CLI we don't have SERVER_NAME, so use host name instead
	$site_domain = ! empty($_SERVER['SERVER_NAME'])? $_SERVER['SERVER_NAME'] : wp_parse_url(get_home_url(get_current_blog_id()), PHP_URL_HOST);

	// Get the site domain and get rid of www.
	if(substr($site_domain, 0, 4) == 'www.') {
		$site_domain = substr($site_domain, 4);
	}

	// If the from email is not the default, return it unchanged.
	if($default != "wordpress@$site_domain") {
		return $default;
	}

	if(defined('SVEO_SMTP_FROM_MAIL')) {

		$from_email = SVEO_SMTP_FROM_MAIL;

	} else {

		// Check if admin email it's of domain name
		$admin_mail = get_bloginfo('admin_email');
		$admin_mail_domain = explode('@', $admin_mail);

		if($site_domain == $admin_mail_domain[1]) 
			$from_email = $admin_mail; // Admin email use the site domain name, then we can use admin email
		else
			$from_email =  "noreply@$site_domain"; // Build from email noreply@site-domain.com
	}

	return $from_email;
});

/**
 * Change the default 'WordPress' from name
 *
 * @param string $default
 * @return string
 */
add_filter('wp_mail_from_name', function($default) {

	// Replace only when is default value
	if (strtolower($default) == 'wordpress' && defined('SVEO_SMTP_FROM_NAME')) {
		return SVEO_SMTP_FROM_NAME;
	}

	return $default;
});

