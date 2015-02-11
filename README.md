[![License](https://poser.pugx.org/timitao/behatplaceholderextension/license.svg)](https://packagist.org/packages/timitao/behatplaceholderextension)
[![Latest Stable Version](https://poser.pugx.org/timitao/behatplaceholderextension/v/stable.svg)](https://packagist.org/packages/timitao/behatplaceholderextension)
[![Latest Unstable Version](https://poser.pugx.org/timitao/behatplaceholderextension/v/unstable.svg)](https://packagist.org/packages/timitao/behatplaceholderextension)
[![Total Downloads](https://poser.pugx.org/timitao/behatplaceholderextension/downloads.svg)](https://packagist.org/packages/timitao/behatplaceholderextension)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d6c70d12-ccdb-4c13-a4d6-bbe6113d5601/mini.png)](https://insight.sensiolabs.com/projects/d6c70d12-ccdb-4c13-a4d6-bbe6113d5601)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/timitao/behatplaceholderextension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/timitao/behatplaceholderextension/?branch=master)



BehatPlaceholderExtension
================

Add functionality to replace some placeholders with special data.
Default are added 2:
* PHP consts - NULL, TRUE, FALSE
* Configuration consts - defined at config file

Purpose of this is that usually i use in system non meaning const data, like default system admin.
Over testing on local machine is okey, but when need run over some dump, user probably will change and i don't need to change scenarios.

## Installing extension

The easiest way to install is by using [Composer](https://getcomposer.org):

```bash
$> curl -sS https://getcomposer.org/installer | php
$> php composer.phar require timitao/behatplaceholderextension='1.0.*'
```

or composer.json

    "require": {
        "timitao/behatplaceholderextension": "1.0.*"
    },


## Example

PHP Consts
* ``placeholder(NULL)`` - at context arrive NULL
* ``placeholder(TRUE)`` - at context arrive TRUE

Configuration consts - given example

    Behat\PlaceholderExtension\ServiceContainer\Extension:
        defaults:
          key1: value1
          key2: value2


* ``placeholder(key1)`` - at context arrive ``value1``
* ``placeholder(key2)`` - at context arrive ``value2``

## Versioning
 
This repository will follow [Semantic Versioning v2.0.0](http://semver.org/spec/v2.0.0.html).

## Contributors

* Tomasz Kunicki [TimiTao](http://github.com/timiTao) [lead developer]

