<?php

/*Plugin Name: KidsPay
 * Description: Plugin Wordpress para integração com a plataforma KidsPay
 * Version: 1.0
 * License: GPLv2 or Later.
*/
define ('KPPATH','/wp-content/plugins/KidsPay');
define ('KP_DIR', __DIR__ );
define ('KP_VENDOR_DIR', __DIR__ . '/vendor/');

if ( ! defined( 'KP_PLUGIN_FILE' ) ) {
	define( 'KP_PLUGIN_FILE', plugin_dir_url(__FILE__) );
}

require __DIR__ . '/src/kp-vars.php';
require __DIR__ . '/src/class-kp-plugin.php';
require __DIR__ . '/functions.php';
require KP_VENDOR_DIR . 'autoload.php';
