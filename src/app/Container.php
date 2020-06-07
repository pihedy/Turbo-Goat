<?php

namespace Lana;

use \Pimple\Container as PimpleContainer; 
use \Lana\Interfaces\Container as CointainerInterface;

/** 
 * Lana container class to save settings.
 * 
 * Settings between the two sides can be requested and added. 
 * This also makes basic settings easier to access.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
class Container extends PimpleContainer implements CointainerInterface
{
    /**
     * @param array $values The settings that have already been checked during the initial run.
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);
    }

    /**
     * It verifies the existence of the key and returns to good value.
     * 
     * @param string $key   The key you are looking for.
     * @param mixed $return That's what she returns if she has no results.
     * 
     * @return mixed 
     */
    public function get(string $key, $return = null)
    {
        if ($this->has($key)) {
            $return = $this->offsetGet($key);
        }

        return $return;
    }

    /**
     * You went down a key under the key.
     * 
     * @param string $key   The key to which the value will be applied is the value.
     * @param mixed $value  Data to be saved.
     */
    public function set(string $key, $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * We can check if the data has been saved with that key.
     * 
     * @param mixed $key The key to its existence is under investigation.
     * 
     * @return bool 
     */
    public function has(string $key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Deletes a data under a specific key.
     * 
     * @param string $key 
     */
    public function delete(string $key)
    {
        if ($this->has($key)) {
            $this->offsetUnset($key);
        }
    }
}
