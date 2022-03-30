<?php
/**
 * PHP tries to SMTP with `sendmail` by default, but it is not installed.
 * So here we configuring the `PHPMailer`.
 *
 * Alternative is installing a SMTP client (e.g. `msmtp`) and setting the
 * `sendmail_path` in `/usr/local/etc/php/php.ini.production`. But I still
 * avoid rebuilding an official Docker images and use the compose file only.
 */

require_once ABSPATH . 'wp-includes/plugin.php';

function mail_smtp($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = getenv('SMTP_HOSTNAME');
    $phpmailer->Port = getenv('SMTP_PORT');
    $phpmailer->From = getenv('SMTP_FROM');
    $phpmailer->FromName = getenv('SMTP_FROM_NAME');

    // Current SMTP configuration is insecure.
    $phpmailer->SMTPAuth = false;
    //$phpmailer->Username = getenv('SMTP_USER');
    //$phpmailer->Password = getenv('SMTP_PASSWORD');
    //$phpmailer->SMTPSecure = 'tls';
    //$phpmailer->SMTPAutoTLS = true;

    // 0..4
    // @see `SMTPDebug`
    //   at https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting
    $phpmailer->SMTPDebug = 3;

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
