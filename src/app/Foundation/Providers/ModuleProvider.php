<?php declare(strict_types=1);

namespace Goat\Foundation\Providers;

use \Goat\Interfaces\Provider;
use \Goat\Managers\ModuleActivityManager;
use \Goat\Managers\ModuleDataManager;
use \Goat\Managers\ModuleLoaderManager;
use \Goat\Persistences\DataPersistence;
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
        'Configs',
        'Modules'
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
    public function registerConfigs(): void
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
    }

    /**
     * It launches the modules faithfully to the appropriate side.
     * 
     * @return void 
     */
    public function registerModules(): void
    {
        if (!is_array($this->modules) || empty($this->modules)) {
            return;
        }

        $ModuleDataManager  = new ModuleDataManager(new DataPersistence);
        $modules            = array_map(function (array $module) use ($ModuleDataManager) {
            /** 
             * @hook The activity status of a module can be overridden.
             */
            $module['active'] = apply_filters(
                'turbo_goat_module_activity_status', 
                ModuleActivityManager::getModuleActivityStatus($module['key']), 
                $module
            );

            if (!$module['active']) {
                return false;
            }

            $module['data'] = $ModuleDataManager->getDataByKey($module['key']);

            return $module;
        }, $this->modules);

        goat()->Container->set('modules', new ModuleLoaderManager($modules));
    }
}
