<?php declare(strict_types=1);

namespace Goat\Providers;

use \Illuminate\Support\Collection;

/**
 * This provides the class with the module data to the Goat.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
final class ModuleProvider
{
    /**
     * A collection of modules found in the folder.
     * 
     * @var \Illuminate\Support\Collection
     */
    private $Modules;

    /**
     * When loaded, it searches for all modules in the specified folder.
     * 
     * @return self 
     */
    public static function boot(): self
    {
        $modulesFolder = apply_filters(
            'turbo_goat_modules_folder', 
            GOAT_ROOT . DIRECTORY_SEPARATOR . 'modules'
        );

        if (!is_dir($modulesFolder)) {
            throw new \Exception(
                __('Does not point to a folder!', 'goat')
            );
        }

        $directories = array_filter(array_map(function ($directory) {
            if (!is_dir($directory)) {
                return null;
            } else if (!file_exists($directory . DIRECTORY_SEPARATOR . 'config.json')) {
                return null;
            }

            $moduleContent  = file_get_contents($directory . DIRECTORY_SEPARATOR . 'config.json');
            $data           = json_decode($moduleContent, true);

            if (!in_array('start', $data)) {
                return null;
            }

            $data['path'] = $directory;

            return $data;
        }, glob($modulesFolder . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR)));

        $self           = new static;
        $self->Modules  = collect($directories);

        return $self;
    }

    /**
     * Returns the related modules in a collection based on a side name.
     * If no key is specified, it returns with all modules.
     * 
     * @param null|string $sideName The name of the Side by which the search can go.
     * 
     * @return \Illuminate\Support\Collection 
     */
    public function getModulesData(?string $sideName = null): Collection
    {
        $Data = null;

        if (!is_null($sideName)) {
            $Data = $this->Modules->where('side', $sideName);
        } else {
            $Data = $this->Modules;
        }

        return $Data;
    }
}
