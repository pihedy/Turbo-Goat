<?php declare(strict_types=1);

namespace Goat\Sides;

use \Goat\Base;
use \Goat\Container;

class Site extends Base
{
    /**
     * @param array $container 
     */
    public function __construct(Container $Container)
    {
        $this->Container = $Container;
    }

    /** 
     * Starting the site section.
     */
    public function run()
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
