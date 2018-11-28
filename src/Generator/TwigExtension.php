<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.1
 *
 * @copyright 2015-2018 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

declare(strict_types=1);

namespace WsdlToClass\Generator;

/**
 * The TwigExtension provides a set of filters to use in the templates
 */
class TwigExtension extends \Twig_Extension
{
    const PHP_SCALAR_TYPES = [
        'string',
        'float',
        'int',
        'bool',
        'DateTime',
    ];

    const WSDL_SCALAR_TYPES = [
        'boolean',
        'double',
        'short'
    ];

    /**
     * Get the filters for the extension
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter('lowerCamelCase', [$this, 'lowerCamelCase']),
            new \Twig_SimpleFilter('upperCamelCase', [$this, 'upperCamelCase']),
            new \Twig_SimpleFilter('camelCaseToWords', [$this, 'camelCaseToWords']),
            new \Twig_SimpleFilter('toPhpSupportedScalar', [$this, 'toPhpSupportedScalar']),
            new \Twig_SimpleFilter('postfix', [$this, 'postfix']),
        ];
    }

    /**
     * @return array
     */
    public function getTests(): array
    {
        return [
            new \Twig_SimpleTest('phpScalarType', [$this, 'isPhpScalarType']),
            new \Twig_SimpleTest('scalarType', [$this, 'isScalarType']),
        ];
    }


    /**
     * Change the input to lower camel case
     * @param string $name
     * @return string
     */
    public function lowerCamelCase(string $name): string
    {
        return lcfirst($name);
    }

    /**
     * Change the input to upper camel case
     * @param string $name
     * @return string
     */
    public function upperCamelCase(string $name): string
    {
        return ucfirst($name);
    }

    /**
     * Change the camel case input to separate words
     * @param string $name
     * @return string
     */
    public function camelCaseToWords(string $name): string
    {
        return trim(strtolower(preg_replace('/(?<!\ )[A-Z]/', ' $0', $name)));
    }

    /**
     * SOAP specification support scalar types that aren't supported or written differently by PHP
     * @param string $type
     * @return string
     */
    public function toPhpSupportedScalar(string $type): string
    {
        if ($this->isPhpScalarType($type)) {
            return $type;
        }

        if ($type === 'short') {
            return 'float';
        }
        if ($type === 'double') {
            return 'float';
        }
        if ($type === 'boolean') {
            return 'bool';
        }

        return $type;
    }

    /**
     * @param string $type
     * @return bool
     */
    public function isPhpScalarType(string $type): bool
    {
        return in_array($type, self::PHP_SCALAR_TYPES);
    }

    /**
     * @param string $type
     * @return bool
     */
    public function isScalarType(string $type): bool
    {
        return in_array($type, array_merge(self::PHP_SCALAR_TYPES, self::WSDL_SCALAR_TYPES));
    }

    /**
     * Add an additional postfix if the string doesn't end with it.
     * @param string $value
     * @param string $postfix
     * @return string
     */
    public function postfix(string $value, string $postfix): string
    {
        if (substr($value, strlen($value) - strlen($postfix)) === $postfix) {
            return $value;
        }

        return $value . $postfix;
    }
}
