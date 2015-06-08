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

/**
 * The generator generates the classes based on the Wsdl provided.
 *
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
class Generator extends AbstractGenerator implements IClassMapGenerator, IStructureGenerator, IServiceGenerator, IMethodGenerator
{
    /**
     * Generate a class map.
     * @param Wsdl $wsdl
     * @return string
     */
    public function generateClassMap(Wsdl $wsdl)
    {
        $mappingItems = "/* Structs */\n";
        foreach ($wsdl->getStructures() as $name => $structure) {
            $mappingItems .= "\t\t\t'{$name}' => '{$this->getNamespace()}\Structure\\{$structure->getName()}',\n";
        }
        $mappingItems .= "\t\t\t/* Responses */\n";
        foreach ($wsdl->getResponses() as $name => $response) {
            $mappingItems .= "\t\t\t'{$name}' => '{$this->getNamespace()}\Response\\{$name}',\n";
        }
        $mappingItems .= "\t\t\t/* Requests */\n";
        foreach ($wsdl->getRequests() as $name => $request) {
            $mappingItems .= "\t\t\t'{$name}' => '{$this->getNamespace()}\Request\\{$name}',\n";
        }
        $mappingItems = trim(substr(trim($mappingItems), 0, -1));

        return <<<EOT
<?php

namespace {$this->getNamespace()};

class ClassMap\n{\n
    public static function get()
    {
        return array(
            {$mappingItems}
        );
    }
}
EOT;
    }

    /**
     * Generate a struct
     * @param  Struct  $struct
     * @return string
     */

    public function generateStruct(Struct $struct)
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
     * @param  Struct $struct
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
     * @param  Struct $struct
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

    /**
     * Generate a service class
     * @param Wsdl $wsdl
     * @return string
     */
    public function generateService(\WsdlToClass\Wsdl\Wsdl $wsdl)
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
     * @param  Wsdl   $wsdl
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
    
    /**
     * Generate the method classes
     * @param \WsdlToClass\Wsdl\Method $method
     * @return string
     */
    public function generateMethod(\WsdlToClass\Wsdl\Method $method)
    {

    }

}
