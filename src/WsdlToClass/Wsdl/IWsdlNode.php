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
namespace WsdlToClass\Wsdl;
/**
 *
 * @author dannyvandersluijs
 */
interface IWsdlNode
{
    /**
     * Get the name of the Wsdl Node
     */
    public function getName();

    /**
     * Set the name of the Wsdl Node
     * @param string $name
     * @return IWsdlNode
     */
    public function setName($name);
}