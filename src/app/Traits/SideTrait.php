<?php declare(strict_types=1);

namespace Goat\Traits;

use \Goat\Persistences\DataPersistence;
use \Goat\Repositories\DataRepository;
use Goat\Structures\Module;

/** 
 * A function collector between sides.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
trait SideTrait
{
    /** 
     * Starting section.
     */
    public function run(): void
    {
        $this->registerProviders();
        $this->initModules();
    }

    /**
     * Initializes the modules to the appropriate side.
     * 
     * @return void 
     */
    public function initModules(): void
    {
        $DataRepository = new DataRepository(new DataPersistence);
        $ActiveModules  = $DataRepository->findByKey("active_{$this->side}_modules");
        
        $this->Container->get('modules')
        ->where('side', $this->side)
        ->each(function (array $moduleConfig) use ($DataRepository, $ActiveModules) {
            $active = false;

            if ($ActiveModules->search($moduleConfig['key'])) {
                $active = true;
            }

            /** 
             * @hook The activity status of a module can be overridden.
             */
            $moduleConfig['active'] = apply_filters(
                "turbo_goat_{$moduleConfig['key']}_module_activity_status", 
                $active, 
                $moduleConfig
            );

            /* if (!$moduleConfig['active']) {
                return true;
            } */

            $Data = $DataRepository->findByKey($moduleConfig['key'])
            ->merge(['config' => $moduleConfig]);

            Module::init($Data)->load();
        });
    }
}
