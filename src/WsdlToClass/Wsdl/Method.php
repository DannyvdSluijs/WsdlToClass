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
namespace WsdlToClass\Wsdl;

use WsdlToClass\Generator\IMethodGenerator;

/**
 * A method represents an function available from a WSDL.
 *
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
class Method implements IWsdlNode
{
    /**
     * The name of the method.
     * @var string
     */
    private $name;

    /**
     * The name of the request belonging to the method.
     * @var string
     */
    private $request;

    /**
     * The name of the response belonging to the method.
     * @var string
     */
    private $response;

    /**
     * Get the name of the method.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the method.
     * @param  string $name
     * @return Method
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * Get the name of the request belonging to the method.
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set the name of the request belonging to the method
     * @param  string $request
     * @return Method
     */
    public function setRequest($request)
    {
        $this->request = (string) $request;

        return $this;
    }

    /**
     * Get the name of the response belonging to the method
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set the name of the response belonging to the method
     * @param string $response
     */
    public function setResponse($response)
    {
        $this->response = (string) $response;

        return $this;
    }

    /**
     * Visit the method with an IMethodGenerator
     * @param IMethodGenerator $generator
     * @return string
     */
    public function visit(IMethodGenerator $generator)
    {
        return $generator->generateMethod($this);
    }
}
