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
        try {
            $this->initModules(self::SIDE_NAME);
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
