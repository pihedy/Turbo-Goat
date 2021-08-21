<?php declare(strict_types=1);

/** 
 * Plugin Name: Turbo Goat
 * Plugin URI: https://github.com/pihedy/Turbo-Goat
 * Description: The goat is also full, the cabbage is preserved.
 * Version: 1.0.0
 * Author: Pihedy
 * Author URI: https://github.com/pihedy
 * Text Domain: goat
 * Requires PHP: 7.0
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

require GOAT_SRC_ROOT . DIRECTORY_SEPARATOR . 'bootstrap.php';
