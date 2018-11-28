<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.1
 *
 * @copyright 2015-2018 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

declare(strict_types=1);

namespace WsdlToClass\Wsdl;

use WsdlToClass\Generator\IMethodGenerator;

/**
 * A method represents an function available from a WSDL.
 */
class Method implements IWsdlNode
{
    /**
     * The name of the method.
     * @var string
     */
    private $name = '';

    /**
     * The name of the request belonging to the method.
     * @var string
     */
    private $request = '';

    /**
     * The name of the response belonging to the method.
     * @var string
     */
    private $response = '';

    /**
     * Method constructor.
     * @param string $name
     * @param string $request
     * @param string $response
     */
    public function __construct(string $name, string $request, string $response)
    {
        $this->name = $name;
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Get the name of the method.
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the name of the method.
     * @param  string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get the name of the request belonging to the method.
     * @return string
     */
    public function getRequest(): string
    {
        return $this->request;
    }

    /**
     * Set the name of the request belonging to the method
     * @param  string $request
     */
    public function setRequest(string $request): void
    {
        $this->request = $request;
    }

    /**
     * Get the name of the response belonging to the method
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * Set the name of the response belonging to the method
     * @param string $response
     */
    public function setResponse(string $response): void
    {
        $this->response = $response;
    }

    /**
     * Visit the method with an IMethodGenerator
     * @param IMethodGenerator $generator
     * @return string
     */
    public function visit(IMethodGenerator $generator): string
    {
        return $generator->generateMethod($this);
    }
}
