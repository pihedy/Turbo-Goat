<?php

namespace Goat\Managers;

class ModuleActivityManager
{
    public static function getModuleActivityStatus(string $moduleKey): bool
    {
        return get_option($moduleKey);
    }
}
