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
 * The Wsdl is a class representation of an actual WSDL
 *
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
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
     * @var Method[]
     */
    private $methods = array();

    /**
     * The structures(complex types) that are used in the web service.
     * @var Struct[]
     */
    private $structures = array();

    /**
     * The requests(complex types) that are used in the webservice
     * @var Request[]
     */
    private $requests = array();

    /**
     * The responses(complex types) that are used in the webservice
     * @var Response[]
     */
    private $responses = array();

    /**
     * The simple types that are used in the web service
     * @var Property[]
     */
    private $simpleTypes = array();

    /**
     * Comstructor
     * @param string $source
     */
    public function __construct($source)
    {
        $this->source = (string) $source;
    }

    /**
     * Get the WSDL source
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set the WSDL source
     * @param string $source
     * @return \WsdlToClass\Wsdl\Wsdl
     */
    public function setSource($source)
    {
        $this->source = (string) $source;
        return $this;
    }

    /**
     * Add an internal item to its stack
     * @param  string                 $which
     * @param  string                 $key
     * @param  IWsdlNode              $value
     * @return \WsdlToClass\Wsdl\Wsdl
     * @throws \Exception
     */
    private function add($which, $key, IWsdlNode $value)
    {
        if (!isset($this->$which)) {
            throw new \Exception(sprintf('Invalid property [%s]', $which));
        }

        $this->{$which}[$key] = $value;

        return $this;
    }

    /**
     * Test if a named item is available on its stack
     * @param  string     $which
     * @param  string     $key
     * @return boolean
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
     * Get a named item from its internal stack
     * @param  string     $which
     * @param  string     $key
     * @return IWsdlNode
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
     * Add a struct to the internal stack
     * @param string $key
     * @param Struct $struct
     * @return Wsdl
     */
    public function addStruct($key, Struct $struct)
    {
        return $this->add('structures', $key, $struct);
    }

    /**
     * Get all structures
     * @return Wsdl\Structs[]
     */
    public function getStructures()
    {
        return $this->structures;
    }

    /**
     * Test if a named struct is available.
     * @param  string  $key
     * @return boolean
     */
    public function hasStruct($key)
    {
        return $this->has('structures', $key);
    }

    /**
     * Get a single named struct
     * @param  string $key
     * @return Struct
     */
    public function getStruct($key)
    {
        return $this->get('structures', $key);
    }

    /**
     * Add a named method.
     * @param string $key
     * @param \WsdlToClass\Wsdl\Method $method
     * @return Wsdl
     */
    public function addMethod($key, Method $method)
    {
        if (!$this->hasResponse($method->getResponse()) && $this->hasStruct($method->getResponse())) {
            $struct = $this->getStruct($method->getResponse());
            $request = Response::createFromStruct($struct);
            $this->addResponse($method->getResponse(), $request);
        }

        if (!$this->hasRequest($method->getRequest()) && $this->hasStruct($method->getRequest())) {
            $struct = $this->getStruct($method->getRequest());
            $request = Request::createFromStruct($struct);
            $this->addRequest($method->getRequest(), $request);
        }

        return $this->add('methods', $key, $method);
    }

    /**
     * Get all methods
     * @return Wsdl\Method[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Add a named requests.
     * @param string $key
     * @param Request $request
     * @return Wsdl
     */
    public function addRequest($key, $request)
    {
        return $this->add('requests', $key, $request);
    }

    /**
     * Get all requests.
     * @return Wsdl\Request[]
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * Test if a named request is available.
     * @param  string  $key
     * @return boolean
     */
    public function hasRequest($key)
    {
        return $this->has('requests', $key);
    }

    /**
     * Add a named response.
     * @param string   $key
     * @param Response $response
     */
    public function addResponse($key, Response $response)
    {
        return $this->add('responses', $key, $response);
    }

    /**
     * Get all responses.
     * @return Wsdl\Response[]
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * Test if a nmed response is avialable.
     * @param  string  $key
     * @return boolean
     */
    public function hasResponse($key)
    {
        return $this->has('responses', $key);
    }

    /**
     * Add a simple type.
     * @param string   $key
     * @param Property $response
     */
    public function addSimpleType($key, Property $response)
    {
        return $this->add('simpleTypes', $key, $response);
    }

    /**
     * Get all simpel types
     * @return Wsdl\Property[]
     */
    public function getSimpleTypes()
    {
        return $this->simpleTypes;
    }

    /**
     * Test if a named simple type is available.
     * @param  string  $key
     * @return boolean
     */
    public function hasSimpleType($key)
    {
        return $this->has('simpleTypes', $key);
    }

    /**
     * Get a single named simple type
     * @param  string $key
     * @return SimpleType
     */
    public function getSimpleType($key)
    {
        return $this->get('simpleTypes', $key);
    }

    /**
     * Cast the wsdl to string. Acts a convenience method to use the Wsdl as the source for a client.
     * @return string
     */
    public function __toString()
    {
        return $this->source;
    }

    /**
     * Visit the wsdl with a service generator
     * @param  IServiceGenerator $generator
     * @return string
     */
    public function visit(IServiceGenerator $generator)
    {
        return $generator->generateService($this);
    }
}
