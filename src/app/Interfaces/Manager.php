<?php declare(strict_types=1);

namespace Goat\Interfaces;

/** 
 * This is a determining interface for setting classes.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
interface Manager
{
    /**
     * @param string $path The file path is separated by dots.
     * 
     * @return string|null The full path of the file.
     */
    public function get(string $path);
}
