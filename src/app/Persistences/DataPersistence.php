<?php declare(strict_types=1);

namespace Goat\Persistences;

use \Goat\Interfaces\Persistence;

/**
 * Persistence class operating with Goat data.
 * 
 * It is easier to cache and back up your data as an option.
 * By default, the cache folder points to a goat-cache folder within the wp-content folder, 
 * but it can be overwritten with a hook.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
class DataPersistence implements Persistence
{
    protected $cacheFolder;

    /**
     * Checks the cache folder and creates a Cache for the class.
     * 
     * @return void 
     */
    public function __construct()
    {
        $this->cacheFolder = apply_filters(
            'turbo_goat_cache_folder', 
            WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'turbo-goat'
        );
    }

    /**
     * Saves the data to the database and create cache.
     * 
     * @param string    $key    The key based on which it is saved can also be retrieved based on this.
     * @param array     $data   The data to be save.
     * 
     * @return void 
     */
    public function persist(string $key, array $data): void
    {
        /** 
         * TODO: Ide még jön egy cache is!
         */
        update_option("turbo_goat_{$key}", $data, 'no');
    }

    /**
     * Returns data in array form based on the key.
     * If the cache file does not exist, but the option does, it creates the cache.
     * 
     * @param string $key The key that searches for saved data.
     * 
     * @return array Data you found based on the key.
     */
    public function retrieve(string $key): array
    {
        /** 
         * TODO: Ellenőrizni, hogy létezik-e cache!
         */
        $data = get_option("turbo_goat_{$key}", []);
        
        return $data;
    }

    /**
     * Clears the cache and the option part based on a key.
     * 
     * @param string $key The key by which to delete data.
     * 
     * @return void 
     */
    public function delete(string $key): void
    {
        delete_option("turbo_goat_{$key}");
    }
}
