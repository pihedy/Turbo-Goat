<?php

namespace Goat\Interfaces;

/** 
 * Interface that defines providers.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
interface Provider
{
    /**
     * Required registration function.
     * 
     * @return void 
     */
    public function register(): void;
}
