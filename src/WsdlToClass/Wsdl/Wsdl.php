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

    /**
     *
     * @param  string                 $which
     * @param  string                 $key
     * @param  \Object                $value
     * @return \WsdlToClass\Wsdl\Wsdl
     * @throws \Exception
     */
    private function add($which, $key, $value)
    {
        if (!isset($this->$which)) {
            throw new \Exception(sprintf('Invalid property [%s]', $which));
        }

        $this->{$which}[$key] = $value;

        return $this;
    }

    /**
     *
     * @param  string     $which
     * @param  string     $key
     * @return \Object
     * @throws \Exception
     */
    private function has($which, $key)
    {
        if (!isset($this->$which)) {
            throw new \Exception(sprintf('Invalid property [%s]', $which));
        }

        return array_key_exists($key, $this->{$which});
    }

    /**
     *
     * @param  string     $which
     * @param  string     $key
     * @return \Object
     * @throws \Exception
     */
    private function get($which, $key)
    {
        if (!isset($this->$which)) {
            throw new \Exception(sprintf('Invalid property [%s]', $which));
        }

        return array_key_exists($key, $this->{$which}) ? $this->{$which}[$key] : null;
    }

    /**
     *
     * @param  type $key
     * @param  type $value
     * @return type
     */
    public function addModel($key, $value)
    {
        return $this->add('models', $key, $value);
    }

    /**
     *
     * @return type
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     *
     * @param  string $key
     * @return Struct
     */
    public function getModel($key)
    {
        return $this->get('models', $key);
    }

    /**
     *
     * @param  string                   $key
     * @param  \WsdlToClass\Wsdl\Method $method
     * @return type
     */
    public function addMethod($key, Method $method)
    {
        if (!$this->hasResponse($method->getResponse())) {
            $this->addResponse($method->getResponse(), $this->getModel($method->getResponse()));
        }

        if (!$this->hasRequest($method->getRequest())) {
            $this->addRequest($method->getRequest(), $this->getModel($method->getRequest()));
        }

        return $this->add('methods', $key, $method);
    }

    /**
     *
     * @return Method[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     *
     * @param  string  $key
     * @param  Request $value
     * @return type
     */
    public function addRequest($key, $value)
    {
        return $this->add('requests', $key, $value);
    }

    /**
     *
     * @return Request[]
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     *
     * @param  string  $key
     * @return boolean
     */
    public function hasRequest($key)
    {
        return $this->has('requests', $key);
    }

    /**
     *
     * @param string   $key
     * @param Response $response
     */
    public function addResponse($key, $response)
    {
        $this->add('responses', $key, $response);
    }

    /**
     *
     * @return Reponse[]
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     *
     * @param  string  $key
     * @return boolean
     */
    public function hasResponse($key)
    {
        return $this->has('responses', $key);
    }

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return $this->source;
    }

    /**
     *
     * @param  IServiceGenerator $generator
     * @return string
     */
    public function visit(IServiceGenerator $generator)
    {
        return $generator->generateService($this);
    }
}
