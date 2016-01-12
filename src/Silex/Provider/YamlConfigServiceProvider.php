<?php

namespace Ronanchilvers\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Yaml\Parser as YamlParser;

/**
 * Simple class to provide a config service parsed from a YAML file.
 * 
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class YamlConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * The yml filename to parse
     * 
     * @var string
     */
    protected $filename;

    /**
     * Class constructor
     *
     * @param  string $filename
     * 
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Register this provider.
     *
     * @param Silex\Application $app
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function register(Application $app)
    {
        if (is_null($this->filename)) {
            throw new \RuntimeException('You must provide a valid config filename');
        }
        if (!file_exists($this->filename)) {
            throw new \RuntimeException(sprintf('Config path \'%s\' is not valid', $this->filename));
        }
        if (!is_readable($this->filename)) {
            throw new \RuntimeException(sprintf('Config path \'%s\' is not readable', $this->filename));
        }
        $parser = new YamlParser();
        $config = $parser->parse(file_get_contents($this->filename));
        if (is_array($config) && !empty($config)) {
            if (isset($app['config']) && is_array($app['config'])) {
                $config = array_replace_recursive($app['config'], $config);
            }
            $app['config'] = $config;
        }
    }

    /**
     * Boot the provider.
     *
     * @param Silex\Application $app
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function boot(Application $app)
    {
    }
}
