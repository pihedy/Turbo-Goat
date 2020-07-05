<?php declare(strict_types=1);

namespace Goat\Interfaces;

/**
 * The main type and function of the persistence class.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
interface Persistence
{
    /**
     * The input function used to save data.
     * 
     * @param string    $key
     * @param array     $data 
     * 
     * @return void 
     */
    public function persist(string $key, array $data): void;

    /**
     * The export function that can be used to request data.
     * 
     * @param string $key Identifier to search for data.
     * 
     * @return array All data for id is in an array.
     */
    public function retrieve(string $key): array;

    /**
     * Delete data by ID.
     * 
     * @param int $id 
     * 
     * @return void 
     */
    public function delete(string $key): void;
}
