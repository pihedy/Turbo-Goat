<?php declare(strict_types=1);

namespace Goat\Foundation\Providers;

use \Goat\Interfaces\Provider;
use \Goat\Traits\ProviderTrait;
use \Goat\Foundation\Messages;

/** 
 * Register messages to Goat.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
class MessageProvider implements Provider
{
    use ProviderTrait;

    /**
     * Registration keys.
     * 
     * @var array
     */
    protected $registers = [
        'Messags',
    ];

    /**
     * The folder that contains the messages.
     * 
     * @var string
     */
    protected $directory;

    /**
     * return void
     */
    public function __construct()
    {
        /** 
         * @hook Here you can override the base folder where the message files are.
         */
        $this->directory = apply_filters(
            'turbo_goat_message_core_directory',
            GOAT_ROOT . DIRECTORY_SEPARATOR . 'lang'
        );
    }

    /**
     * It registers the files and passes them to the message manager.
     * 
     * @return void 
     */
    public function registerMessags(): void
    {
        /** 
         * @hook The filter can be used to expand the language container.
         */
        $directories = array_merge(
            [
                $this->directory
            ],
            apply_filters('turbo_goat_message_directories', [])
        );

        $messages = [];

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                continue;
            }

            $DirectoryIterator = new \DirectoryIterator($directory);
            
            foreach ($DirectoryIterator as $Content) {
                if ($Content->isDot() || $Content->isDir()) {
                    continue;
                }

                if ($Content->getExtension() != 'php') {
                    continue;
                }

                $fileContent = include($Content->getPathname());

                if (!is_array($fileContent) || empty($fileContent)) {
                    continue;
                }

                $messages = array_merge($messages, [
                    $Content->getBasename('.php') => $fileContent
                ]);
            }
        }

        goat()->Container->set('messages', new Messages($messages));
    }
}
