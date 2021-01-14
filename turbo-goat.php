<?php declare(strict_types=1);

/** 
 * Plugin Name: Turbo Goat
 * Description: TODO
 * Version: 1.0.0
 * Author: Pihedy
 * Text Domain: goat
 */

/** 
 * No direct access.
 */
if (!defined('ABSPATH')) {
    return null;
}

/** 
 * Plugin directory root.
 */
define('GOAT_ROOT', __DIR__);

/** 
 * Plugin file path.
 */
define('GOAT_FILE', __FILE__);

/** 
 * SRC directory root.
 */
define('GOAT_SRC_ROOT', GOAT_ROOT . DIRECTORY_SEPARATOR . 'src');

/** 
 * Load bootstrap file.
 */
if (!file_exists(GOAT_SRC_ROOT . DIRECTORY_SEPARATOR . 'bootstrap.php')) {
    wp_die('Bootstrap file not found!');
}

require_once GOAT_SRC_ROOT . DIRECTORY_SEPARATOR . 'bootstrap.php';
