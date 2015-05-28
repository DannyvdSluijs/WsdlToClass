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

use WsdlToClass\Generator\IModelGenerator;

/**
 * Description of Mathod
 *
 * @author dannyvandersluijs
 */
class Method
{
    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var string
     */
    private $request;

    /**
     *
     * @var string
     */
    private $response;

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param string $request
     */
    public function setRequest($request)
    {
        $this->request = (string) $request;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param string $response
     */
    public function setResponse($response)
    {
        $this->response = (string) $response;
        return $this;
    }

    /**
     *
     * @param IModelGenerator $generator
     */
    public function visit(IModelGenerator $generator)
    {
    }
}
