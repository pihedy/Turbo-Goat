<?php declare(strict_types=1);

namespace Goat;

/** 
 * The App Class, which helps to install Goat.
 * 
 * Among other things, sharing the settings between the parties in a common container.
 * Part of the idea was given by the Slim framework.
 * I thank them from here! :)
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
class App
{
    /** 
     * @var null|self Copy of the Goat App Class.
     */
    private static $instances = null;

    /**
     * @var \Goat\Sides\Admin|\Goat\Sides\Site Class filled with the right party.
     */
    private $Side;

    /**
     * The App's constructor should always be private to prevent direct
     * construction calls with the `new` operator.
     */
    protected function __construct()
    {
        /* Do Nothing */
    }

    /**
     * App should not be cloneable.
     */
    protected function __clone()
    {
        /* Do Nothing */
    }

    /**
     * App should not be restorable from strings.
     */
    public function __wakeup()
    {
        throw new \Exception('Cannot unserialize a singleton.');
    }

    /** 
     * This implementation lets you subclass the Singleton class while keeping
     * just one instance of each subclass around.
     * 
     * @return self
     */
    public static function getInstance(): self
    {
        if (is_null(static::$instances)) {
            static::$instances = new static;
        }

        return static::$instances;
    }

    /**
     * @param array $container The settings array that will later be converted to the appropriate class.
     */
    public function setContainer($container = [])
    {
        if (is_array($container)) {
            $Container = new Container($container);
        }

        if (!$Container instanceof Interfaces\Container) {
            throw new \InvalidArgumentException('Container incorrectly specified.');
        }

        $Side       = \is_admin() ? \Goat\Sides\Admin::class : \Goat\Sides\Site::class;
        $this->Side = new $Side($Container);

        return $this->Side;
    }

    /**
     * Installation modules required.
     */
    public function install()
    {
        \register_activation_hook(GOAT_FILE, function () {
            /* NOTE: Ide jönnek az install funkciók ha kellenek! */
        });
    }

    /**
     * A getter on a side request.
     * 
     * The reason for its creation is to make the created Side object global.
     * 
     * @return \Goat\Sides\Admin|\Goat\Sides\Site
     */
    public function getSide()
    {
        return $this->Side;
    }
}
