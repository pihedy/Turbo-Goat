<?php declare(strict_types=1);

namespace Goat\Providers;

final class ModuleProvider
{
    private $modules;

    public static function boot()
    {
        $modulesFolder = apply_filters(
            'trubo_goat_modules_folder', 
            GOAT_SRC_ROOT . DIRECTORY_SEPARATOR . 'modules'
        );

        if (!is_dir($modulesFolder)) {
            throw new \Exception(
                __('Does not point to a folder!', 'goat')
            );
        }

        $directories = array_filter(
            glob($modulesFolder . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR),
            'is_dir'
        );

        $directories = array_filter(array_map(function ($directory) {
            if (!file_exists($directory . DIRECTORY_SEPARATOR . 'config.json')) {
                return null;
            }

            $Data = collect(
                json_decode(
                    file_get_contents(
                        $directory . DIRECTORY_SEPARATOR . 'config.json'), 
                        true
                )
            );

            if (!$Data->has(['name', 'start'])) {
                return null;
            }

            $Data->put('path', $directory);

            return $Data;
        }, $directories));

        $self           = new static;
        $self->modules  = $directories;

        return $self;
    }
}
