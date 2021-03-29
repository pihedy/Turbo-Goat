<?php declare(strict_types=1);

namespace Goat\Sides;

use \Goat\Base;

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
    /**
     * @var string A constant that specifies the name of the side.
     */
    const SIDE_NAME = 'admin';

    /** 
     * Starting the admin section.
     */
    public function run(): void
    {
        $this->registerProviders();
        $this->initModules(self::SIDE_NAME);
    }
}
