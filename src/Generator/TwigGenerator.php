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

namespace WsdlToClass\Generator;

use WsdlToClass\Exception\NotFoundException;
use WsdlToClass\Wsdl\Method;
use WsdlToClass\Wsdl\Request;
use WsdlToClass\Wsdl\Response;
use WsdlToClass\Wsdl\Wsdl;
use WsdlToClass\Wsdl\Struct;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * The generator generates the classes based on the Wsdl provided.
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
    public function __construct($template)
    {
        $path = 'data/templates/' . $template;

        if (!is_readable($path)) {
            throw new NotFoundException('Unable to read ' . $path);
        }
        $this->twig = new Twig_Environment(new Twig_Loader_Filesystem($path));
        $this->twig->addExtension(new TwigExtension());
    }

    /**
     * Generate a class map.
     * @param Wsdl $wsdl
     * @return string
     */
    public function generateClassMap(Wsdl $wsdl): string
    {
        return $this->twig->render('class-map.html', [
            'wsdl' => $wsdl,
            'namespace' => $this->getNamespace(),
        ]);
    }

    /**
     * Generate a single struct
     * @param  Struct  $struct
     * @return string
     */
    public function generateStruct(Struct $struct): string
    {
        $classNamePostfix = '';
        if ($struct instanceof Response) {
            $classNamePostfix = 'Response';
        }
        if ($struct instanceof Request) {
            $classNamePostfix = 'Request';
        }
        return $this->twig->render('struct.html', [
            'classNamePostfix' => $classNamePostfix,
            'struct' => $struct,
            'namespace' => $this->getNamespace(),
            'full_namespace' => $this->getFullNamespace()
        ]);
    }

    /**
     * Generate a service class
     * @param Wsdl $wsdl
     * @return string
     */
    public function generateService(Wsdl $wsdl): string
    {
        return $this->twig->render('service.html', ['wsdl' => $wsdl, 'namespace' => $this->getNamespace()]);
    }

    /**
     * Generate the method classes
     * @param Method $method
     * @return string
     */
    public function generateMethod(Method $method): string
    {
        return $this->twig->render('method.html', [
            'method' => $method,
            'namespace' => $this->getNamespace(),
            'full_namespace' => $this->getFullNamespace()
        ]);
    }

    /**
     * Generate the client class
     * @param Wsdl $wsdl
     * @return string
     */
    public function generateClient(Wsdl $wsdl): string
    {
        return $this->twig->render('client.html', ['wsdl' => $wsdl, 'namespace' => $this->getNamespace()]);
    }
}
