<?php

namespace Ronanchilvers\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Config\ConfigCacheFactory;
use Symfony\Component\Config\ConfigCacheInterface;
use Symfony\Component\Config\FileLocator;

/**
 * Simple class to provide a config service parsed from a YAML file.
 * 
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class YamlConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * The yml filename to parse.
     * 
     * @var string
     */
    protected $filePaths;

    /**
     * @var ConfigCacheFactory
     */
    protected $configCacheFactory;

    /**
     * Class constructor.
     *
     * @param string|array $filePaths
     * @param string|null  $cacheDirPath
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct($filePaths = array(), $cacheDirPath = null)
    {
        $this->filePaths = (array) $filePaths;
        $this->cacheDirPath = $cacheDirPath;
    }

    /**
     * Register this provider.
     *
     * @param \Silex\Application $app
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     *
     * @return mixed
     */
    public function register(Application $app)
    {
        if ($this->cacheDirPath) {
            $cache = $this->getConfigCacheFactory($app['debug'])->cache($this->cacheDirPath.'/config.cache',
                function (ConfigCacheInterface $cache) {

                    $config = $this->loadConfig();

                    $cache->write(serialize($config));
                }
            );

            $app['config'] = unserialize(file_get_contents($cache->getPath()));
        } else {
            $app['config'] = $this->loadConfig();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {
    }

    /**
     * @param bool $debug Is debug mode enabled
     *
     * @return ConfigCacheFactory
     */
    private function getConfigCacheFactory($debug)
    {
        if ($this->configCacheFactory === null) {
            $this->configCacheFactory = new ConfigCacheFactory($debug);
        }

        return $this->configCacheFactory;
    }

    protected function loadConfig()
    {
        $paths = array_map(function($filePath) {
            return dirname($filePath);
        }, $this->filePaths);

        $loader = new YamlFileLoader(new FileLocator($paths));

        $config = [];
        foreach ($this->filePaths as $filePath) {
            $config = array_replace_recursive($config, $loader->load($filePath));
        }

        return $config;
    }
}
