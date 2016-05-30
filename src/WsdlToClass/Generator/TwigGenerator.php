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
namespace WsdlToClass\Generator;

use WsdlToClass\Wsdl\Wsdl;
use WsdlToClass\Wsdl\Struct;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * The generator generates the classes based on the Wsdl provided.
 *
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
class TwigGenerator extends AbstractGenerator implements ICompositeGenerator
{
    /**
     *
     * @var Twig_Environment
     */
    private $twig;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->twig = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__ . '/Twig'), array());
    }

    /**
     * Generate a class map.
     * @param Wsdl $wsdl
     * @return string
     */
    public function generateClassMap(Wsdl $wsdl)
    {
        return $this->twig->render('class-map.html', array(
            'wsdl' => $wsdl,
            'namespace' => $this->getNamespace(),
        ));
    }

    /**
     * Generate a single struct
     * @param  Struct  $struct
     * @return string
     */
    public function generateStruct(Struct $struct)
    {
        return $this->twig->render('struct.html', array(
            'struct' => $struct,
            'namespace' => $this->getNamespace(),
            'full_namespace' => $this->getFullNamespace()
        ));
    }

    /**
     * Generate a service class
     * @param Wsdl $wsdl
     * @return string
     */
    public function generateService(Wsdl $wsdl)
    {
        return $this->twig->render('service.html', array('wsdl' => $wsdl, 'namespace' => $this->getNamespace()));
    }

    /**
     * Generate the method classes
     * @param \WsdlToClass\Wsdl\Method $method
     * @return string
     */
    public function generateMethod(\WsdlToClass\Wsdl\Method $method)
    {
        return $this->twig->render('method.html', array(
            'method' => $method,
            'namespace' => $this->getNamespace(),
            'full_namespace' => $this->getFullNamespace()
        ));
    }

    /**
     * Generate the client class
     * @param Wsdl $wsdl
     * @return string
     */
    public function generateClient(Wsdl $wsdl)
    {
        return $this->twig->render('client.html', array('wsdl' => $wsdl, 'namespace' => $this->getNamespace()));
    }

}
