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

/**
 * Description of ServiceGenerator
 *
 * @author dannyvandersluijs
 */
class ServiceGenerator extends AbstractGenerator implements IServiceGenerator
{
    public function generate(\WsdlToClass\Wsdl\Wsdl $wsdl)
    {
        return <<<EOT
<?php

namespace {$this->getNamespace()};

class Service\n{\n
    {$this->generateMethods($wsdl)}
}
EOT;
    }

    protected function generateMethods(\WsdlToClass\Wsdl\Wsdl $wsdl)
    {
        if (count($wsdl->getMethods()) == 0) {
            return '';
        }

        $methods = '';

        foreach ($wsdl->getMethods() as $name => $property) {
            $methods .= "\t/**\n\t *\n\t**/\n\tpublic function {$name}()\n\t{\n\t\treturn ;\n\t}\n\n";
        }

        return trim($methods);
    }
}
