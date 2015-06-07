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
     * The structures(complex types) that are used in the web service.
     * @var Wsdl\Structs[]
     */
    private $structures = array();

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
     * @param  Strcut|Method|Request|Response                $value
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
     * @param string $key
     * @param Struct $struct
     * @return Wsdl
     */
    public function addStruct($key, Struct $struct)
    {
        return $this->add('structures', $key, $struct);
    }

    /**
     *
     * @return Wsdl\Struct[]
     */
    public function getStructures()
    {
        return $this->structures;
    }

    /**
     *
     * @param  string $key
     * @return Struct
     */
    public function getStruct($key)
    {
        return $this->get('structures', $key);
    }

    /**
     *
     * @param string $key
     * @param \WsdlToClass\Wsdl\Method $method
     * @return Wsdl
     */
    public function addMethod($key, Method $method)
    {
        if (!$this->hasResponse($method->getResponse())) {
            $this->addResponse($method->getResponse(), $this->getStruct($method->getResponse()));
        }

        if (!$this->hasRequest($method->getRequest())) {
            $this->addRequest($method->getRequest(), $this->getStruct($method->getRequest()));
        }

        return $this->add('methods', $key, $method);
    }

    /**
     *
     * @return Wsdl\Method[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     *
     * @param string $key
     * @param Request $request
     * @return Wsdl
     */
    public function addRequest($key, $request)
    {
        return $this->add('requests', $key, $request);
    }

    /**
     *
     * @return Wsdl\Request[]
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
     * @return Wsdl\Response[]
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
