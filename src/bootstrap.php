<?php declare(strict_types=1);

/** 
 * The Turbo Goat starts here.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */

/** 
 * App directory root.
 */
define('GOAT_APP_ROOT', GOAT_SRC_ROOT . DIRECTORY_SEPARATOR . 'app');

/** 
 * Vendor directory root.
 */
define('GOAT_VENDOR_ROOT', GOAT_APP_ROOT . DIRECTORY_SEPARATOR . 'Vendor');

/** 
 * If composer autoload not found then die.
 */
if (!file_exists(GOAT_VENDOR_ROOT . DIRECTORY_SEPARATOR . 'autoload.php')) {
    wp_die(msg('error.install_composer'));
}

/** 
 * Include autoload file.
 */
require_once GOAT_VENDOR_ROOT . DIRECTORY_SEPARATOR . 'autoload.php';

try {
    if (wp_doing_ajax()) {
        /* TODO: Egyenlőre return null, de később call! */
        return null;
    }
    
    if (wp_doing_cron()) {
        /* TODO: Egyenlőre return null, de később call! */
        return null;
    }
    
    /** 
     * Goat App Instance.
     */
    $Goat = \Goat\App::getInstance();

    /** 
     * List of providers.
     * 
     * @hook If another provider is required to run.
     */
    $providers = array_merge(
        [
            'modules' => \Goat\Foundation\Providers\ModuleProvider::class
        ],
        apply_filters('turbo_goat_extend_providers', [])
    );
    
    /** 
     * The party starts! ;)
     */
    $Goat->setContainer([
        'providers' => $providers
    ])->init()->run();
} catch (\Exception $e) {
    /* TODO: Error handler! */
}
