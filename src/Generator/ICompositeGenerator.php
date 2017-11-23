<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.0
 *
 * @copyright 2015-2017 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

namespace WsdlToClass\Generator;

/**
 * The ICompositeGenerator joins the different generator interfaces to a single interface
 */
interface ICompositeGenerator extends IClassMapGenerator, IClientGenerator, IMethodGenerator, IServiceGenerator, IStructureGenerator
{
    /* Intentionally left blank */
}
