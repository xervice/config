Xervice: Config
====

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/xervice/config/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/xervice/config/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/xervice/config/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/xervice/config/?branch=master)
[![Build Status](https://travis-ci.org/xervice/config.svg?branch=master)](https://travis-ci.org/xervice/config)

Config loader for Xervice services.

Installation
---------------------
```
composer require xervice/config
```

Configuration
---------------------
1. Add a config directory to your root path
2.  In there you have different config files parsed in this order:
    * config_default.php
    * config_<APPLICATION_ENV>.php
    * config_local.php
    * (additional config files defined in previous config file)

***APPLICATION_ENV*** is a environment variable. The default value is "production".

To add additional config files you can add them to your config_default:
```php
$config[\Xervice\Config\XerviceConfig::ADDITIONAL_CONFIG_FILES] = [
    __DIR__ . '/addition_config.php'
];
```

If you want to change the config-directory, you can set the environment variable ***APPLICATION_PATH***.
If this variable is defined, the config will search for config-files in <APPLICATION_PATH>/config.

Usage
--------------------
```php
$configProvider = new XerviceConfig(new XerviceConfigFactory());
$config = $configProvider->getConfig();

$value = $config->get('CONFIG_KEY');

$valueWithDefault = $config->get('CONFIG_KEY', 'defaultvalue');
```