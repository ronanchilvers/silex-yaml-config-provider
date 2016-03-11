# YamlConfigServiceProvider

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4edf38b2-659b-4fdf-908d-cd4fe8a22ded/mini.png)](https://insight.sensiolabs.com/projects/4edf38b2-659b-4fdf-908d-cd4fe8a22ded)

A very simple YAML config provider for Silex 1.3+ allowing you to read your configuration in from YAML files.

## Installation

The easiest mechanism is via composer. Add the provider to your composer.json:

```json
{
    "require": {
        "ronanchilvers/silex-yaml-config-provider": "dev-master"
    }
}
```

## Usage

To register the service provider you can do something like this:

```php
$app->register(new \Ronanchilvers\Silex\Provider\YamlConfigServiceProvider(
    '/path/to/my/yaml/config.yml'
));
```

You can add the provider multiple times if you want to parse multiple files and the configuration will be merged together.

```php
$app->register(new \Ronanchilvers\Silex\Provider\YamlConfigServiceProvider(
    [
        '/path/to/my/yaml/config1.yml',
        '/path/to/my/yaml/config2.yml',
    ]
));
```

Also you can use caching for your config file(s) for performance:

```php
$app->register(new \Ronanchilvers\Silex\Provider\YamlConfigServiceProvider(
    '/path/to/my/yaml/config.yml',
    '/path/to/cache/directory'
));
```

## Services Exposed

The YamlConfigServiceProvider exposes the following services.

- `config` - The parsed configuration data as an array
