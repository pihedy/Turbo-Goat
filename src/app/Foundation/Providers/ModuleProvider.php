<?php declare(strict_types=1);

namespace Goat\Foundation\Providers;

use \Goat\Interfaces\Provider;
use \Goat\Managers\ModuleActivityManager;
use \Goat\Managers\ModuleDataManager;
use \Goat\Managers\ModuleLoaderManager;
use \Goat\Persistences\DataPersistence;
use Goat\Repositories\DataRepository;
use \Goat\Traits\ProviderTrait;

/**
 * This provides the class with the module data to the Goat.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
class ModuleProvider implements Provider
{
    use ProviderTrait;

    /**
     * Registration keys.
     * 
     * @var array
     */
    protected $registers = [
        'FindModules'
    ];

    /**
     * Location of the modules folder.
     * 
     * @var string
     */
    protected $directory;

    /**
     * List of created and found modules.
     * 
     * @var array
     */
    protected $modules;

    /**
     * @return mixed 
     */
    public function __construct()
    {
        /** 
         * @hook To change the position of the modules.
         */
        $this->directory = apply_filters(
            'turbo_goat_modules_folder', 
            GOAT_ROOT . DIRECTORY_SEPARATOR . 'modules'
        );
    }

    /**
     * Register the modules in the class.
     * 
     * @return void 
     */
    protected function registerFindModules(): void
    {
        $DirectoryIterator = new \DirectoryIterator($this->directory);

        foreach ($DirectoryIterator as $Element) {
            if ($Element->isDot() || !$Element->isDir()) {
                continue;
            }

            $path = $Element->getPathname();

            if (!file_exists($path . DIRECTORY_SEPARATOR . 'config.php')) {
                continue;
            }

            $config             = include $path . DIRECTORY_SEPARATOR . 'config.php';
            $config['path']     = $path;
            $this->modules[]    = $config;
        }

        goat()->Container->set('modules', collect($this->modules));
    }
}
