[![Build Status](https://travis-ci.org/DannyvdSluijs/WsdlToClass.svg?branch=master)](https://travis-ci.org/DannyvdSluijs/WsdlToClass)
[![Latest Stable Version](https://poser.pugx.org/dvandersluijs/wsdl-to-class/v/stable)](https://packagist.org/packages/dvandersluijs/wsdl-to-class)
[![Latest Unstable Version](https://poser.pugx.org/dvandersluijs/wsdl-to-class/v/unstable)](https://packagist.org/packages/dvandersluijs/wsdl-to-class)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/DannyvdSluijs/WsdlToClass/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/DannyvdSluijs/WsdlToClass/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/DannyvdSluijs/WsdlToClass/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/DannyvdSluijs/WsdlToClass/?branch=master)

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
