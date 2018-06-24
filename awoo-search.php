<?php

/*
Plugin Name:  Woo Search
Description:  ajax WooCommerce product search.
Version: 0.1
Author: AminSaki
Author URI: https://darkoob.co.ir/
Text Domain: amin
*/

ob_start();
defined( 'ABSPATH' ) || exit;
define('RIG_DIR', plugin_dir_path( __FILE__ ) );
define('RIG_INC_DIR', trailingslashit( RIG_DIR . 'inc' ) );
define('RIG_URL', plugin_dir_url( __FILE__ ) );
define('RIG_JS_URL', trailingslashit( RIG_URL . 'asset/js' ) );
define('RIG_css_URL', trailingslashit( RIG_URL .'asset/css' ) );

include_once  RIG_INC_DIR . '/ajaxs.php';
include_once  RIG_INC_DIR . '/temp.php';
