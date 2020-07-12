<?php declare(strict_types=1);

namespace Goat\Repositories;

use \Goat\Interfaces\Persistence;
use \Illuminate\Support\Collection;

/** 
 * The repository class that returns the data.
 * 
 * Goat Core and Goat Module data are requested from this class, 
 * and are also saved through it.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
final class DataRepository
{
    /**
     * @var \Goat\Interfaces\Persistence
     */
    private $Persistence;

    /**
     * The Persistence class through which the data will be available will be uploaded.
     * 
     * @param \Goat\Interfaces\Persistence $Persistence 
     */
    public function __construct(Persistence $Persistence)
    {
        $this->Persistence = $Persistence;
    }

    /**
     * It searches for data based on a key and returns it in collection form.
     * 
     * @param string $key The key to look for.
     * 
     * @return \Illuminate\Support\Collection 
     */
    public function findByKey(string $key): Collection
    {
        return collect($this->Persistence->retrieve($key));
    }

    /**
     * Provides save.
     * 
     * @param string    $key    The key under which the data is saved.
     * @param array     $data   The data that will be saved.
     * 
     * @return void 
     */
    public function save(string $key, array $data): void
    {
        $this->Persistence->persist($key, $data);
    }
}
