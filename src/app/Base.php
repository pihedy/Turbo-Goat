<?php declare(strict_types=1);

namespace Goat;

use \Goat\Builders\HookBuilder;
use \Goat\Interfaces\Provider;
use \Goat\Managers\TemplateManager;
use \Monolog\Logger;

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
     * @param array $container 
     */
    public function __construct(Container $Container)
    {
        $this->Container = $Container;
    }

    /**
     * Abstraction of the boot function.
     */
    abstract public function run();

    /**
     * Provider registration function for sides.
     * 
     * @return void 
     */
    protected function registerProviders(): void
    {
        $providers = $this->Container->get('providers');

        foreach ($providers as $providerClass) {
            $Provider = new $providerClass;

            if (!$Provider instanceof Provider) {
                continue;
            }

            $Provider->register();
        }
    }

    /** 
     * @param string $channel Specifies the channel name written in the queue.
     * 
     * @return \Monolog\Logger
     */
    public function log(string $channel = 'default'): Logger
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
    public function template(): TemplateManager
    {
        return new \Goat\Managers\TemplateManager();
    }

    /**
     * A unique function for hooks, which makes it easier and more compact.
     * 
     * @param object $class When called globally, the class is the first parameter.
     * 
     * @return Goat\Builders\HookBuilder
     * 
     * @throws \InvalidArgumentException    If one of the parameters is bad during the run.
     * @throws \Exception                   For other errors.
     */
    public function setHooks(?object $class = null): HookBuilder
    {
        $HookBuilder = new \Goat\Builders\HookBuilder;

        if ($class === null) {
            $class = $this;
        }

        return $HookBuilder->initData($class);
    }

    /**
     * Initializes the modules to the appropriate side.
     * 
     * @param string $sideName The name of the side.
     * 
     * @return void 
     */
    public function initModules(string $sideName): void
    {
        $Modules        = $this->Container->get('modules')->getModulesData($sideName);
        $ModulesData    = $this->Container->get('data')->findByKey('module_statuses');

        $Modules->each(function (array $module) use ($ModulesData) {
            if ($ModulesData->isEmpty()) {
                return false;
            }

            $data           = $ModulesData->where('key', $module['key']);
            $starterFile    = $module['path'] . DIRECTORY_SEPARATOR . $module['start'];
            
            do_action('turbo_goat_before_init_module', $module, $data);

            if (!file_exists($starterFile)) {
                return true;
            }

            if ($data['status']) {
                include $starterFile;
            }

            do_action('turbo_goat_after_init_module', $module, $data);
        });
    }

    /**
     * The url of the file in the asset folder can be requested.
     * 
     * @param   string|null   $name   File name when you search.
     * @param   string        $type   File type when you search.
     * 
     * @return  string  File URL.
     * 
     * @throws \Exception If direcotry not found.
     */
    public function getAssetUrl(?string $name, string $type = 'image'): string
    {
        if ($name === null) {
            throw new \Exception(
                __('Name is required!', 'goat')
            );
        }

        $file = GOAT_ROOT . DIRECTORY_SEPARATOR . 'asset' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $name;

        if (!file_exists($file)) {
            throw new \Exception(
                sprintf(__('File (%s) or directory (%s) not found.', 'goat'), $name, $type)
            );
        }

        return plugin_dir_url(GOAT_FILE) . "asset/{$type}/{$name}";
    }

    /**
     * Introduces the script or style if you need it.
     * 
     * @param string        $url        The path to the script.
     * @param string        $type       Type of script.
     * @param null|string   $version    If you have a version, you will also get the version of the plugin otherwise.
     * 
     * @return void
     */
    public function setScript(string $url, string $type, ?string $version = null): void
    {
        $avalible = [
            'style',
            'script'
        ];

        if (!in_array($type, $avalible)) {
            throw new \Exception(
                __('The specified type is not available!', 'goat')
            );
        }

        if ($version === null) {
            $version = get_file_data(GOAT_FILE, ['Version' => 'Version'])['Version'];
        }

        $function = "wp_enqueue_{$type}";
        $fileName = basename($url);

        $function($fileName, $url, [], $version);
    }
}
