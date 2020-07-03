<?php declare(strict_types=1);

namespace Goat\Managers;

/** 
 * Provides service for template.
 * 
 * Provides class service between classes.
 * You can request a custom route or even a template for the class.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
class TemplateManager implements \Goat\Interfaces\Manager
{
    /** 
     * It points to the root of the template folder.
     */
    protected const GOAT_TEMPLATE_DIR = GOAT_APP_ROOT . DIRECTORY_SEPARATOR . 'Templates';

    /** 
     * The object into which the property is loaded.
     * 
     * @var object
     */
    protected $container;

    /**
     * Creates and uploads parameters.
     * 
     * @param array $start The starting position for the template service path.
     */
    public function __construct(array $start = [])
    {
        $this->container = new \stdClass;
        $this->container->start = $start;
    }

    /**
     * Within the class namespace any file can be requested with this function.
     * The path can be specified by dots and the last element is the file name.
     * If there is no file then false returns.
     * 
     * @param string $path  The route you are looking for is separated by dots.
     * @param bool $self    If self true returns a file with the class name within the class namespace.
     */
    public function get(string $path, bool $self = false)
    {
        if ($self) {
            $segments = explode('.', $path);
            $root = implode(DIRECTORY_SEPARATOR, $segments);
        } else {
            $segments = explode('.', $path);

            array_pop($this->container->start);

            $rootArray = array_merge(
                $this->container->start, 
                $segments
            );

            $root = implode(DIRECTORY_SEPARATOR, $rootArray);
        }

        if (file_exists(self::GOAT_TEMPLATE_DIR . DIRECTORY_SEPARATOR . $root . '.php')) {
            return self::GOAT_TEMPLATE_DIR . DIRECTORY_SEPARATOR . $root . '.php';
        } else {
            return false;
        }
    }
}
