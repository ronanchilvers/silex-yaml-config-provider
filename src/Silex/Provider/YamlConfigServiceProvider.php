<?php

namespace Ronanchilvers\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\Yaml\Parser as YamlParser;

/**
 * Simple class to provide a config service parsed from a YAML file
 * 
 * @author Ronan Chilvers <ronan@d3r.com>
 */
class YamlConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * Register this provider
     *
     * @param Silex\Application $app
     *
     * @author Ronan Chilvers <ronan@d3r.com>
     */
    public function register(Application $app)
    {
        $app['config.path'] = null;

        $app['config'] = $app->share(function(Application $app) {
            if (is_null($app['config.path'])) {
                throw new \RuntimeException('You must provide a valid config path in config.path');
            }
            if (!file_exists($app['config.path'])) {
                throw new \RuntimeException(sprintf('Config path \'%s\' is not valid', $app['config.path']));
            }
            if (!is_readable($app['config.path'])) {
                throw new \RuntimeException(sprintf('Config path \'%s\' is not readable', $app['config.path']));
            }
            $parser = new YamlParser();
            $config = $parser->parse(file_get_contents($app['config.path']));

            return $config;
        });
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
