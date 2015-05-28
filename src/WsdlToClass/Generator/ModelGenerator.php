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

use WsdlToClass\Wsdl\Struct;
/**
 * Description of ModelGenerator
 *
 * @author dannyvandersluijs
 */
class ModelGenerator extends AbstractGenerator implements IModelGenerator
{
    /**
     * Generate the struct in a model representation
     * @param Struct $struct
     * @return tstring
     */
    public function generateModel(Struct $struct)
    {
        return <<<EOT
<?php

namespace {$this->getNamespace()};

class {$struct->getName()}
{
\t{$this->generateProperties($struct)}

\t{$this->generateGettersSetters($struct)}
}
EOT;
    }

    /**
     * Generate the properties for a strcut
     * @param Struct $struct
     * @return string
     */
    protected function generateProperties(Struct $struct)
    {
        if (count($struct->getProperties()) == 0) {
            return '';
        }

        $propertiesString = '';

        foreach ($struct->getProperties() as $name => $property) {
            $propertiesString .= "\t/**\n\t * @var {$property->getType()}\n\t */\n\tprivate \${$property->getName()} = null;\n\n";
        }

        return trim($propertiesString);
    }

    /**
     * Generate the getters and setters for a struct
     * @param Struct $struct
     * @return string
     */
    protected function generateGettersSetters(Struct $struct)
    {
        if (count($struct->getProperties()) == 0) {
            return '';
        }

        $gettersSettersString = '';

        foreach ($struct->getProperties() as $name => $property) {
            $gettersSettersString .= "\tpublic function get{$property->getName()}()\n\t{\n\t\treturn \$this->{$property->getName()};\n\t}\n\n";
        }

        return trim($gettersSettersString);
    }
}
