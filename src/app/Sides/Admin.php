<?php declare(strict_types=1);

namespace Goat\Sides;

use \Goat\Base;
use \Goat\Traits\SideTrait;

/** 
 * The department responsible for the functions on the Admin site.
 * 
 * Here are the functions for need to load and run the admin modules.
 * The commonly used features go back to origin.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
class Admin extends Base
{
    use SideTrait;

    /**
     * @var string A constant that specifies the name of the side.
     */
    private $side = 'admin';
}
