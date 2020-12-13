<?php declare(strict_types=1);

namespace Goat\Builders;

/** 
 * Responsible for assembling and running the hooks.
 * 
 * This class can be used to put together a class of hooks.
 * But it can be expanded beyond that.
 * 
 * @author Pihedy <pihedy@gmail.com>
 */
final class HookBuilder
{
    /** 
     * The data for the hooks are loaded into this object.
     * 
     * @var object;
     */
    protected $hookObject;

    /** 
     * Creates a new hookObject when called.
     */
    private function reset()
    {
        $this->hookObject = new \stdClass;
    }

    /**
     * Adds basic data to run.
     * 
     * @param object $class         The class from which to call the function.
     * @param array $classHooks     Added actions and filters at once.
     */
    public function initData(object $class, array $classHooks = [])
    {
        $this->reset();

        $this->hookObject->class = $class;
        $this->hookObject->hooks = $classHooks;

        return $this;
    }

    /**
     * Plus the ability to add action.
     * 
     * @param array $action The action data must contain the position and function of the hook.
     */
    public function addAction(array $action = [])
    {
        $this->hookObject->hooks['actions'][] = $action;

        return $this;
    }

    /** 
     * Introduces the received hooks for that class.
     * 
     * @throws \InvalidArgumentException If the class is missing to call the hook.
     * @throws \InvalidArgumentException If you are missing a tag key or empty.
     * @throws \InvalidArgumentException If the function key is missing or empty.
     */
    public function execute()
    {
        if (!isset($this->hookObject->class)) {
            throw new \InvalidArgumentException(
                'The class property is missing from hookObject.'
            );
        }

        $class = $this->hookObject->class;

        foreach ($this->hookObject->hooks as $hookValue) {
            array_walk($hookValue, function ($value) use ($class) {
                if (!isset($value['tag']) || ($value['tag'] == '')) {
                    throw new \InvalidArgumentException(
                        'The tag key is missing from the hook group.'
                    );
                } else if (!isset($value['function']) || ($value['function'] == '')) {
                    throw new \InvalidArgumentException(
                        'The function key is missing from the hook group.'
                    );
                }

                add_filter(
                    $value['tag'],
                    [
                        $class,
                        $value['function']
                    ],
                    isset($value['priority']) ? $value['priority'] : 10,
                    isset($value['args']) ? $value['args'] : 1
                );
            });
        }
    }
}
