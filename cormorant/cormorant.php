<?php
/**
 * Plugin Name: Cormorant
 * Description: Flamingo add-on for email confirmation.
 * Version: 1.2.3
 * Author: reksarka
 * Author URI: https://github.com/reksar
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: cormorant
 * Domain Path: /languages
 */

if (! defined('WPINC')) die;
define('CORMORANT', plugin_basename(__FILE__));
define('CORMORANT_DIR', plugin_dir_path(__FILE__));

require_once 'core/cormorant.php';

register_activation_hook(__FILE__, 'cormorant\activate');
register_deactivation_hook(__FILE__, 'cormorant\deactivate');

add_action('init', 'cormorant\init');
