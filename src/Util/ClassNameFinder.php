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

namespace WsdlToClass\Util;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class ClassNameFinder extends NodeVisitorAbstract
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $className;

    /**
     * @param Node $node
     */
    public function enterNode(Node $node): void
    {
        if ($node instanceof Node\Stmt\Namespace_) {
            $this->namespace = (string) $node->name;
        }
        if ($node instanceof Node\Stmt\Class_) {
            $this->className = (string) $node->name;
        }
    }

    public function __toString(): string
    {
        return implode('\\', [$this->namespace, $this->className]);
    }
}
