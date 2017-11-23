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
namespace WsdlToClass\Wsdl;

/**
 * The request is a specific type of struct
 */
class Request extends Struct
{
    /**
     * Create a request from a Struct
     * @param \WsdlToClass\Wsdl\Struct $struct
     * @return Request
     */
    public static function createFromStruct(Struct $struct): Request
    {
        $request = new static;
        $request->setName($struct->getName())
            ->setProperties($struct->getProperties());

        return $request;
    }
}
