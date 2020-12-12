<?php declare(strict_types=1);

use Goat\App;

/** 
 * Auxiliary functions that are good if available within the global scope.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */

if (!function_exists('goat')) {

    /**
     * Returns the created side object.
     * 
     * @return object 
     */
    function goat()
    {
        return App::getInstance()->getSide();
    }
}

if (!function_exists('msg')) {

    /**
     * Returns the translatable text from the message file.
     * 
     * @param string    $key        The key to look for.
     * @param mixed     $return     If no text is found below the key, it returns.
     * 
     * @return string 
     */
    function msg(string $key, $return = null)
    {
        $message = goat()->Container->get('messages')->get($key);

        if ($message === null) {
            $message = $return;
        }

        return $message;
    }
}

if (!function_exists('slugify')) {

    /**
     * A class that makes a slug from a word or sentence.
     * 
     * @param string    $text   The word or phrase that is processed.
     * @param string    $glue   The glue between the normalized word.
     * 
     * @return null|string The normalized word.
     */
    function slugify(string $text, string $glue = '_'): ?string
    {
        $text = preg_replace('~[^\pL\d]+~u', $glue, $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $glue);
        $text = preg_replace('~-+~', $glue, $text);
        $text = strtolower($text);

        if (empty($text)) {
            return null;
        }

        return $text;
    }
}
