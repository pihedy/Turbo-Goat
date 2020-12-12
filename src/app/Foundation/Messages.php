<?php declare(strict_types=1);

namespace Goat\Foundation;

/** 
 * The department that handles other messages.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
final class Messages
{
    /**
     * Loaded messages to search.
     * 
     * @var array
     */
    protected $messages;

    /**
     * @param array $messages Received messages in which to search.
     */
    public function __construct(array $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Returns the message based on the key.
     * 
     * @param string $key 
     * 
     * @return null|string 
     */
    public function get(string $key): ?string
    {
        if (array_key_exists($key, $this->messages)) {
            return $this->messages[$key];
        }

        $segments   = explode('.', $key);
        $root       = $this->messages;

        foreach ($segments as $segment) {
            if (!array_key_exists($segment, $root)) {
                return null;
            }

            $root = $root[$segment];
        }

        return $root;
    }
}
