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

use WsdlToClass\Generator\IServiceGenerator;

/**
 * Description of Wsdl
 *
 * @author dannyvandersluijs
 */
class Wsdl
{
    /**
     * The WSDL source
     * @var string
     */
    private $source;

    /**
     * The methods available in the WSDl
     * @var Wsdl\Method[]
     */
    private $methods = array();

    /**
     * The models(complex types) that are used in the web service.
     * @var Wsdl\Model[]
     */
    private $models = array();

    /**
     * The requests(complex types) that are used in the webservice
     * @var Wsdl\Request[]
     */
    private $requests = array();

    /**
     * The responses(complex types) that are used in the webservice
     * @var Wsdl\Response[]
     */
    private $responses = array();

    /**
     * Comstructor
     * @param string $source
     */
    public function __construct($source)
    {
        $this->source = (string) $source;
    }

    private function add($which, $key, $value)
    {
        if (!isset($this->$which)) {
            throw new \Exception(sprintf('Invalid property [%s]', $which));
        }

        $this->{$which}[$key] = $value;

        return $this;
    }

    public function addModel($key, $value)
    {
        return $this->add('models', $key, $value);
    }

    public function getModels()
    {
        return $this->models;
    }

    public function addMethod($key, $value)
    {
        return $this->add('methods', $key, $value);
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function addRequest($key, $value)
    {
        return $this->add('requests', $key, $value);
    }

    public function getRequests()
    {
        return $this->requests;
    }

    public function addResponse($key, $value)
    {
        $this->add('responses', $key, $value);
    }

    public function getResponses()
    {
        return $this->responses;
    }

    public function __toString()
    {
        return $this->source;
    }

    public function visit(IServiceGenerator $generator)
    {
        return $generator->generate($this);
    }
}
