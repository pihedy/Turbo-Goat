<?php

namespace Lana\Interfaces;

/** 
 * Defines the basic functions of the container class.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
interface Container
{
    /**
     * Returns data based on the key.
     * 
     * @param string $key   The key to search for the key is.
     * @param null $return  Return value if you did not find anything under the key.
     * 
     * @return mixed        Your returned data or base return value.
     */
    public function get(string $key, $return = null);

    /**
     * You can add existing container data by key.
     * 
     * @param string $key   The key you assign the data to.
     * @param mixed $value  The data we want to add to the container.
     */
    public function set(string $key, $value);
    
    /**
     * It examines a key whether it exists or not.
     * 
     * @param string $key The key to search for the key is.
     * 
     * @return bool
     */
    public function has(string $key);

    /**
     * Deletes data based on a key.
     * 
     * @param string $key The key I want to delete from the container.
     */
    public function delete(string $key);
}
