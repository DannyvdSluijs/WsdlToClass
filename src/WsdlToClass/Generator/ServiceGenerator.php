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
/**
 * Description of ServiceGenerator
 *
 * @author dannyvandersluijs
 */
class ServiceGenerator extends AbstractGenerator implements IServiceGenerator
{
    /**
     * Generate the service class for an WSDL
     * @param \WsdlToClass\Wsdl\Wsdl $wsdl
     * @return type
     */
    public function generateService(Wsdl $wsdl)
    {
        return <<<EOT
<?php

namespace {$this->getNamespace()};

class Service\n{\n
    {$this->generateMethods($wsdl)}
}
EOT;
    }

    /**
     * Generate the methods of a WSDL.
     * @param Wsdl $wsdl
     * @return string
     */
    protected function generateMethods(Wsdl $wsdl)
    {
        if (count($wsdl->getMethods()) == 0) {
            return '';
        }

        $methods = '';

        foreach ($wsdl->getMethods() as $name => $method) {
            $methods .= <<<EOM
    /**
     * Calls the soap method {$name}
     * @return {$method->getResponse()}
     **/
    public function {$name}()
    {
        \$request = new Request\\{$method->getRequest()}();
        \$method = new Method\\{$method->getName()}(\$request);

        return new Response\\{$method->getResponse()}(\$method->execute());
    }

EOM;
        }

        return trim($methods);
    }
}
