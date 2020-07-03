<?php declare(strict_types=1);

/** 
 * The Turbo Goat starts here.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */

/* App directory root. */
define('GOAT_APP_ROOT', GOAT_SRC_ROOT . DIRECTORY_SEPARATOR . 'app');

/* Vendor directory root. */
define('GOAT_VENDOR_ROOT', GOAT_APP_ROOT . DIRECTORY_SEPARATOR . 'Vendor');

/* If composer autoload not found then die. */
if (!file_exists(GOAT_VENDOR_ROOT . DIRECTORY_SEPARATOR . 'autoload.php')) {
    wp_die(
        __('Before install composer!', 'goat')
    );
}

/* Include autoload file. */
require_once GOAT_VENDOR_ROOT . DIRECTORY_SEPARATOR . 'autoload.php';

if (wp_doing_ajax()) {
    /* TODO: Egyenlőre return null, de később call! */
    return null;
}

if (wp_doing_cron()) {
    /* TODO: Egyenlőre return null, de később call! */
    return null;
}

/* Goat App Instance */
$Goat = \Goat\App::getInstance();

/* The party starts! ;) */
$Goat->setContainer([
    'modules' => Goat\Providers\ModuleProvider::boot()
])->run();
