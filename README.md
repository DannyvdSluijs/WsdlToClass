[![GitHub](https://img.shields.io/github/license/DannyvdSluijs/WsdlToClass)](https://choosealicense.com/licenses/mit/)
[![Packagist Version](https://img.shields.io/packagist/v/dvandersluijs/wsdl-to-class)](https://packagist.org/packages/json-mapper/json-mapper)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/dvandersluijs/wsdl-to-class)](#)
![Build](https://github.com/DannyvdSluijs/WsdlToClass/workflows/Build/badge.svg?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/DannyvdSluijs/WsdlToClass/badge.svg?branch=develop)](https://coveralls.io/github/JsonMapper/JsonMapper?branch=develop)

# WsdlToClass - Import a WSDL to output classes
WsdlToClass enables you to load an (external) WSDL an generate the classes needed for a implementation.

# Installation
## Composer
Add a dependency using composer:
```bash
composer require 'dvandersluijs/wsdl-to-class:dev-master'
```
Or simply add a dependency on dvandersluijs/wsdl-to-class to your project's composer.json file.
```json
{
    "require": {
        "dvandersluijs/wsdl-to-class": "dev-master"
    }
}
```
For a system-wide installation via Composer, you can run:
```bash
composer global require "dvandersluijs/wsdl-to-class"
```
Make sure you have ~/.composer/vendor/bin/ in your path.

# About
WsdlToClass is a Cilex powered application and uses the PHP internal SOAP implementation
to generate php classes out of the WSDL.

## List of Contributors
Thanks to everyone who has contributed to WsdlToClass! You can find a detailed list of contributors on every WsdlToClass related package on GitHub. This list shows only the major components:

* [WsdlToClass](https://github.com/DannyvdSluijs/WsdlToClass/graphs/contributors)
