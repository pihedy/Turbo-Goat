<?php declare(strict_types=1);

namespace Goat\Repositories;

use \Goat\Interfaces\Persistence;

final class DataRepository
{
    private $Persistence;

    public function __construct(Persistence $Persistence)
    {
        $this->Persistence = $Persistence;
    }

    public function findByKey(string $key)
    {
        return collect($this->Persistence->retrieve($key));
    }

    public function save(string $key, array $data)
    {
        $this->Persistence->persist($key, $data);
    }
}
