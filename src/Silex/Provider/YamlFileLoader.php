<?php

namespace Ronanchilvers\Silex\Provider;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Parser as YamlParser;
use Symfony\Component\Yaml\Exception\ParseException;

class YamlFileLoader extends FileLoader
{
    /**
     * @var YamlParser
     */
    private $yamlParser;

    /**
     * Loads a Yaml file.
     *
     * @param string      $file A Yaml file path
     * @param string|null $type The resource type
     *
     * @return array Parsed config
     *
     * @throws \InvalidArgumentException When a config can't be parsed because YAML is invalid
     */
    public function load($file, $type = null)
    {
        $path = $this->locator->locate($file);

        if (null === $this->yamlParser) {
            $this->yamlParser = new YamlParser();
        }

        if (!is_readable($path)) {
            throw new \RuntimeException(sprintf('Config file "%s" is not readable', $path));
        }

        try {
            $parsedConfig = $this->yamlParser->parse(file_get_contents($path));
        } catch (ParseException $e) {
            throw new \InvalidArgumentException(sprintf('The file "%s" does not contain valid YAML.', $path), 0, $e);
        }

        return $parsedConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && in_array(pathinfo($resource, PATHINFO_EXTENSION), array('yml', 'yaml'), true) && (!$type || 'yaml' === $type);
    }
}
