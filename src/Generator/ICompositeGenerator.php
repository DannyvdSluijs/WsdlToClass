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
 * The ICompositeGenerator joins the different generator interfaces to a single interface
 */
interface ICompositeGenerator extends IClassMapGenerator, IClientGenerator, IMethodGenerator, IServiceGenerator, IStructureGenerator
{
    /* Intentionally left blank */
}
