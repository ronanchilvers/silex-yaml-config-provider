# YamlConfigServiceProvider

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
$app->register(new \Ronanchilvers\Silex\Provider\YamlConfigServiceProvider(), [
    'config.path' => '/path/to/my/yaml/config.yml'
]);
```

## Services Exposed
The YamlConfigServiceProvider exposes the following services.

- `config.path` - The path to the config file
- `config` - The parsed configuration data as an array
