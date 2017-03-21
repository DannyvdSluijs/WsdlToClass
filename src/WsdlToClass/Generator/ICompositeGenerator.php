<?php

/*
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
 * The ICompositeGenerator joins the different generator interfaces to a single interface
 * @author dannyvandersluijs
 */
interface ICompositeGenerator extends IClassMapGenerator, IClientGenerator, IMethodGenerator, IServiceGenerator, IStructureGenerator
{
    /* Intentionally left blank */
}
