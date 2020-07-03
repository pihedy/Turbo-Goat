<?php declare(strict_types=1);

namespace Goat;

/** 
 * Goat's basic class.
 * 
 * You can find the features between the sides here.
 * What is mandatory for an implementation is the run function.
 * The tests are written in separate admin and site sections.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
abstract class Base
{
    /** 
     * The Container class where the settings are loaded.
     * 
     * @var Container
     */
    public $Container;

    /**
     * A common variable between the parties.
     * 
     * Here, DecksRepository is uploaded between the two spaces.
     * 
     * @var DecksRepository
     */
    public $DecksRepository;

    /**
     * Abstraction of the boot function.
     */
    abstract public function run();

    /** 
     * @param string $channel Specifies the channel name written in the queue.
     * 
     * @return \Monolog\Logger $logger
     */
    public function log(string $channel = 'default')
    {
        $logger = new \Monolog\Logger($channel);

        $logger->pushHandler(
            new \Monolog\Handler\StreamHandler(
                GOAT_ROOT . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . date('Y-m-d') . '.log'
            )
        );

        return $logger;
    }

    /**
     * Returns the path to the template if the file exists, 
     * depending on the location of the call.
     * 
     * @return \Goat\Managers\TemplateManager 
     */
    public function template()
    {
        return new \Goat\Managers\TemplateManager();
    }

    /**
     * A unique function for hooks, which makes it easier and more compact.
     * 
     * @param object $class When called globally, the class is the first parameter.
     * 
     * @throws \InvalidArgumentException    If one of the parameters is bad during the run.
     * @throws \Exception                   For other errors.
     * 
     * @return Goat\Builders\HookBuilder
     */
    public function setHooks(?object $class = null)
    {
        try {
            $HookBuilder = new \Goat\Builders\HookBuilder;

            if (is_null($class)) {
                $class = $this;
            }

            return $HookBuilder->initData($class);
        } catch (\InvalidArgumentException $e) {
            $this->log()->error(
                'Invalid argument',
                [
                    'message'   => $e->getMessage(),
                    'file'      => $e->getFile() . ' - ' . $e->getLine()
                ]
            );
        } catch (\Exception $e) {
            $this->log()->warning(
                'Exception',
                [
                    'message'   => $e->getMessage(),
                    'file'      => $e->getFile() . ' - ' . $e->getLine()
                ]
            );
        }
    }

    /**
     * The url of the file in the asset folder can be requested.
     * 
     * @param string|null   $name   File name when you search.
     * @param string        $type   File type when you search.
     * 
     * @return string               File URL.
     * 
     * @throws \Exception If direcotry not found.
     */
    public function getAssetUrl(?string $name, string $type = 'image')
    {
        try {
            if (is_null($name)) {
                throw new \Exception(
                    __('Name is required!', 'goat')
                );
            }

            $file = GOAT_ROOT . DIRECTORY_SEPARATOR . 'asset' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $name;

            if (file_exists($file)) {
                return plugin_dir_url(GOAT_FILE) . "asset/{$type}/{$name}";
            } else {
                throw new \Exception(
                    sprintf(__('File (%s) or directory (%s) not found.', 'goat'), $name, $type)
                );
            }
        } catch (\Exception $e) {
            $this->log()->warning(
                'Exception',
                [
                    'message'   => $e->getMessage(),
                    'file'      => $e->getFile() . ' - ' . $e->getLine()
                ]
            );
        }
    }

    /**
     * Introduces the script or style if you need it.
     * 
     * @param string        $url        The path to the script.
     * @param string        $type       Type of script.
     * @param null|string   $version    If you have a version, you will also get the version of the plugin otherwise.
     */
    public function setScript(string $url, string $type, ?string $version = null)
    {
        try {
            $avalible = [
                'style',
                'script'
            ];

            if (!in_array($type, $avalible)) {
                throw new \Exception(
                    __('The specified type is not available!', 'goat')
                );
            }

            if (is_null($version)) {
                $version = get_file_data(GOAT_FILE, ['Version' => 'Version'])['Version'];
            }

            $function = "wp_enqueue_{$type}";
            $fileName = basename($url);

            $function($fileName, $url, [], $version);
        } catch (\Exception $e) {
            $this->log()->info(
                'Exception',
                [
                    'message'   => $e->getMessage(),
                    'file'      => $e->getFile() . ' - ' . $e->getLine()
                ]
            );
        }
    }

    public function slugify(string $text, string $glue = '_'): ?string
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
