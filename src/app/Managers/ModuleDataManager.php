<?php

namespace Goat\Managers;

use \Goat\Interfaces\Persistence;

class ModuleDataManager
{
    protected $Persistence;

    public function __construct(Persistence $Persistence)
    {
        $this->Persistence = $Persistence;
    }

    public function getDataByKey(string $moduleKey): array
    {
        return $this->Persistence->retrieve($moduleKey);
    }
}
