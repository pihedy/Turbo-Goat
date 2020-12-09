<?php declare(strict_types=1);

namespace Goat\Sides;

use \Goat\Base;

class Site extends Base
{
    /**
     * @var string A constant that specifies the name of the side.
     */
    const SIDE_NAME = 'site';

    /** 
     * Starting the site section.
     */
    public function run(): void
    {
        $this->registerProviders();
    }
}
