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
     * Starting the admin section.
     */
    public function run(): void
    {
        try {
            
        } catch (\Exception $e) {
            $this->log()->error(
                'Exception',
                [
                    'message'   => $e->getMessage(),
                    'file'      => $e->getFile() . ' - ' . $e->getLine()
                ]
            );
        } catch (\InvalidArgumentException $e) {
            $this->log()->warning(
                'InvalidArgumentException',
                [
                    'message'   => $e->getMessage(),
                    'file'      => $e->getFile() . ' - ' . $e->getLine()
                ]
            );
        } catch (\OutOfBoundsException $e) {
            $this->log()->info(
                'OutOfBoundsException',
                [
                    'message'   => $e->getMessage(),
                    'file'      => $e->getFile() . ' - ' . $e->getLine()
                ]
            );
        }
    }
}
