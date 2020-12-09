<?php declare(strict_types=1);

/** 
 * Simple array with translatable texts.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */

return [
    'error' => [
        'bootstrap_not_found'   => __('Bootstrap file not found!', 'goat'),
        'install_composer'      => __('Before install composer!', 'goat'),
        'providers_not_found'   => __('The providers array cannot be empty!', 'goat'),
        'invalid_container'     => __('Container incorrectly specified.', 'goat'),
        'singleton_problem'     => __('Cannot unserialize a singleton.', 'goat')
    ]
];
