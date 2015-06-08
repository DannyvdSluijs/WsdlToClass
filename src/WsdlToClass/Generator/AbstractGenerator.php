<?php

/**
 * wsdlToClass
 *
 * PHP Version 5.3
 *
 * @copyright 2015 Danny van der Sluijs <dammy.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */
namespace WsdlToClass\Generator;

/**
 * The abstract generator holds attributes needed, without being to concrete
 *
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
abstract class AbstractGenerator
{
    /**
     * The namespace to be used when calling a generate command.
     * @var string
     */
    private $namespace;

    /**
     * Get the namespace
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set the namespace
     * @param  string                                   $namespace
     * @return \WsdlToClass\Generator\AbstractGenerator
     */
    public function setNamespace($namespace)
    {
        $this->namespace = (string) $namespace;

        return $this;
    }
}
