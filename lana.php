<?php
/** 
 * Plugin Name: WooCommerce Order Last Modification
 * Description: TODO
 * Version: 1.0.0
 * Author: Pihedy
 * Text Domain: lana
 */

/* No direct access. */
defined('ABSPATH') or die;

/* Plugin directory root. */
define('LANA_ROOT', __DIR__);

/* Plugin file path. */
define('LANA_FILE', __FILE__);

/* SRC directory root. */
define('LANA_SRC_ROOT', LANA_ROOT . DIRECTORY_SEPARATOR . 'src');

/* Load bootstrap file. */
if (!file_exists(LANA_SRC_ROOT . DIRECTORY_SEPARATOR . 'bootstrap.php')) {
    wp_die(
        __('Bootstrap file not found!', 'lana')
    );
}

require_once LANA_SRC_ROOT . DIRECTORY_SEPARATOR . 'bootstrap.php';
