<?php declare(strict_types=1);

namespace Goat\Sides;

use \Goat\Base;
use \Goat\Traits\SideTrait;

class Site extends Base
{
    use SideTrait;

    /**
     * @var string A constant that specifies the name of the side.
     */
    private $side = 'site';
}
