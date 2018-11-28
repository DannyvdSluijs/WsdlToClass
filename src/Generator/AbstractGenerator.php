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
 * The abstract generator holds attributes needed, without being to concrete
 */
abstract class AbstractGenerator
{
    /**
     * The package root namespace.
     * @var string
     */
    private $namespace = '';

    /**
     * The child namespace used for contextual knowledge e.g. request/response etc
     * @var string
     */
    private $childNamespace = '';

    /**
     * Get the namespace
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * Set the namespace
     * @param  string $namespace
     */
    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    /**
     * Get the child namespace
     * @return string
     */
    public function getChildNamespace(): string
    {
        return $this->childNamespace;
    }

    /**
     * Set the child namespace
     * @param string $childNamespace
     */
    public function setChildNamespace(string $childNamespace): void
    {
        $this->childNamespace = $childNamespace;
    }

    /**
     * Get the full namespace
     * @return string
     */
    public function getFullNamespace(): string
    {
        if (empty($this->childNamespace)) {
            return $this->namespace;
        }

        return $this->namespace . '\\' . $this->childNamespace;
    }
}
