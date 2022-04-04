<?php

// For `add_action()`.
require_once ABSPATH . 'wp-includes/plugin.php';

/**
 * PHP tries to SMTP with `sendmail` by default, but it is not installed.
 * So here we configuring the `PHPMailer`.
 *
 * Alternative is installing a SMTP client (e.g. `msmtp`) and setting the
 * `sendmail_path` in `/usr/local/etc/php/php.ini.production`. But I still
 * avoid rebuilding an official Docker images.
 */
function mail_smtp($phpmailer) {
    $domain = getenv('EMAIL_DOMAIN');
    $admin_name = getenv('ADMIN_NAME');
    $admin_email = "$admin_name@$domain";

    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp';
    $phpmailer->Port = getenv('SMTP_PORT');
    $phpmailer->From = $admin_email;
    $phpmailer->FromName = $admin_name;

    // Email services use SASL for auth.
    // @see `README.md#webmail`
    $phpmailer->SMTPAuth = true;
    $phpmailer->AuthType = 'PLAIN';
    $phpmailer->Username = $admin_email;
    $phpmailer->Password = getenv('ADMIN_PASSWORD');
    $phpmailer->SMTPSecure = 'none';
    $phpmailer->SMTPAutoTLS = false;

    // Use 0..4 int to set the debug level.
    // I'm too lazy to include one more file, but pretend it's made for
    // polymorphism and I avoid depending on a concrete class.
    // @see https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting#enabling-debug-output
    $phpmailer->SMTPDebug = 4;

    $phpmailer->Debugoutput = function($str) {
        static $logging = true;
        if ($logging === false && strpos($str, 'SERVER -> CLIENT') !== false) {
            $logging = true;
        }
        if ($logging) {
            error_log("SMTP $str");
        }
        if (strpos($str, 'SERVER -> CLIENT: 354') !== false) {
            $logging = false;
        }
    };
}

add_action('phpmailer_init', 'mail_smtp');
