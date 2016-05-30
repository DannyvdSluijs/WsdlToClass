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
     * The package root namespace.
     * @var string
     */
    private $namespace;

    /**
     * The child namespace used for contextual knowlegde e.g. request/response etc
     * @var string
     */
    private $childNamespace;

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

    /**
     * Get the child namespace
     * @return string
     */
    public function getChildNamespace()
    {
        return $this->childNamespace;
    }

    /**
     * Set the child namespace
     * @param string $childNamespace
     * @return \WsdlToClass\Generator\AbstractGenerator
     */
    public function setChildNamespace($childNamespace)
    {
        $this->childNamespace = (string) $childNamespace;
        return $this;
    }

    /**
     * Get the full namespace
     * @return type
     */
    public function getFullNamespace()
    {
        if (empty($this->childNamespace)) {
            return $this->namespace;
        }

        return $this->namespace . '\\' . $this->childNamespace;
    }
}
