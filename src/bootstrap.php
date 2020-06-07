<?php

/** 
 * The Lana starts here.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */

/* App directory root. */
define('LANA_APP_ROOT', LANA_SRC_ROOT . DIRECTORY_SEPARATOR . 'app');

/* Vendor directory root. */
define('LANA_VENDOR_ROOT', LANA_APP_ROOT . DIRECTORY_SEPARATOR . 'Vendor');

/* If composer autoload not found then die. */
if (file_exists(LANA_VENDOR_ROOT . DIRECTORY_SEPARATOR . 'autoload.php')) {
    wp_die(
        __('Before install composer!', 'lana')
    );
}

/* Include autoload file. */
require_once LANA_VENDOR_ROOT . DIRECTORY_SEPARATOR . 'autoload.php';


