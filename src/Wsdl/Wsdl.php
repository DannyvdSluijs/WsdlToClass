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

use WsdlToClass\Generator\IServiceGenerator;

/**
 * The Wsdl is a class representation of an actual WSDL
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
     * @var MethodCollection
     */
    private $methods;

    /**
     * The structures(complex types) that are used in the web service.
     * @var StructCollection
     */
    private $structures;

    /**
     * The requests(complex types) that are used in the webservice
     * @var RequestCollection
     */
    private $requests;

    /**
     * The responses(complex types) that are used in the webservice
     * @var ResponseCollection
     */
    private $responses;

    /**
     * The simple types that are used in the web service
     * @var PropertyCollection
     */
    private $simpleTypes;

    /**
     * Constructor
     * @param string $source
     */
    public function __construct(string $source)
    {
        $this->source = $source;
        $this->methods = new MethodCollection();
        $this->requests = new RequestCollection();
        $this->responses = new ResponseCollection();
        $this->simpleTypes = new PropertyCollection();
        $this->structures = new StructCollection();
    }

    /**
     * Get the WSDL source
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * Add a struct to the internal stack
     * @param Struct $struct
     * @return Wsdl
     */
    public function addStruct(Struct $struct)
    {
        $this->structures->add($struct);

        return $this;
    }

    /**
     * Get all structures
     * @return StructCollection
     */
    public function getStructures()
    {
        return $this->structures;
    }

    /**
     * Add a named method.
     * @param \WsdlToClass\Wsdl\Method $method
     * @return Wsdl
     */
    public function addMethod(Method $method): self
    {
        if (!$this->hasResponse($method->getResponse()) && $this->structures->has($method->getResponse())) {
            $struct = $this->structures->get($method->getResponse());
            $response = Response::createFromStruct($struct);
            $this->responses->add($response);
        }

        if (!$this->hasRequest($method->getRequest()) && $this->structures->has($method->getRequest())) {
            $struct = $this->structures->get($method->getRequest());
            $request = Request::createFromStruct($struct);
            $this->requests->add($request);
        }

        $this->methods->add($method);

        return $this;
    }

    /**
     * Get all methods
     * @return MethodCollection
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Get all requests.
     * @return RequestCollection
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * Test if a named request is available.
     * @param  string  $name
     * @return boolean
     */
    public function hasRequest(string $name): bool
    {
        return $this->requests->has($name);
    }

    /**
     * Get all responses.
     * @return ResponseCollection
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * Test if a named response is available.
     * @param  string  $name
     * @return boolean
     */
    public function hasResponse(string $name): bool
    {
        return $this->responses->has($name);
    }

    /**
     * Add a simple type.
     * @param Property $property
     * @return Wsdl
     */
    public function addSimpleType(Property $property): self
    {
        return $this->simpleTypes->add($property);
    }

    /**
     * Get all simple types
     * @return PropertyCollection
     */
    public function getSimpleTypes()
    {
        return $this->simpleTypes;
    }

    /**
     * Cast the wsdl to string. Acts a convenience method to use the Wsdl as the source for a client.
     * @return string
     */
    public function __toString(): string
    {
        return $this->source;
    }

    /**
     * Visit the wsdl with a service generator
     * @param  IServiceGenerator $generator
     * @return string
     */
    public function visit(IServiceGenerator $generator): string
    {
        return $generator->generateService($this);
    }
}
