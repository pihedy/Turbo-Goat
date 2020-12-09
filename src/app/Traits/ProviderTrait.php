<?php

namespace Goat\Traits;

/** 
 * A little simplification for providers is that the mandatory registration function is placed in trait.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
trait ProviderTrait
{
    protected $sideKey;

    public function register(): void
    {
        foreach ($this->registers as $registerName) {
            $this->{"register{$registerName}"}();
        }
    }
}
