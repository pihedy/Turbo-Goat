<?php declare(strict_types=1);

namespace Goat\Managers;

use \Illuminate\Support\Collection;

/** 
 * This class was created only to initialize modules.
 * The modules start through it.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
class ModuleLoaderManager
{
    /**
     * Active modules after filtering.
     * 
     * @var array
     */
    protected $modules;

    /**
     * @param array $modules 
     */
    public function __construct(array $modules)
    {
        $this->modules = $modules;
    }

    /**
     * The initialization where the module is loaded.
     * 
     * @param string $siteKey 
     * 
     * @return void 
     */
    public function initModulesBySite(string $siteKey): void
    {
        $this->getModulesBySite($siteKey)->each(function (array $module) {
            if (!$module['active']) {
                return true;
            }

            $starterFile = $module['path'] . DIRECTORY_SEPARATOR . $module['start'];

            do_action('turbo_goat_before_init_module', $module);
            
            include $starterFile;

            do_action('turbo_goat_after_init_module', $module);
        });
    }

    /**
     * Returns modules on a site key basis.
     * 
     * @param string $siteKey 
     * 
     * @return \Illuminate\Support\Collection 
     */
    public function getModulesBySite(string $siteKey): Collection
    {
        return collect($this->modules)->where('side', $siteKey);
    }
}
