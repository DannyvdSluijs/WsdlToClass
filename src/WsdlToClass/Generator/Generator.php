<?php

/*
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
 * Description of Generator
 *
 * @author dannyvandersluijs
 */
class Generator extends AbstractGenerator implements IClassMapGenerator, IModelGenerator, IServiceGenerator
{
    public function generateClassMap(\WsdlToClass\Wsdl\Wsdl $wsdl)
    {
        $mappingItems = "/* Models */\n";
        foreach ($wsdl->getModels() as $name => $model) {
            $mappingItems .= "\t\t\t'{$name}' => '{$this->getNamespace()}\Model\\{$model->getName()}',\n";
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

    public function generateModel(\WsdlToClass\Wsdl\Struct $struct)
    {
    }

    public function generateService(\WsdlToClass\Wsdl\Wsdl $wsdl)
    {
    }

//put your code here
}
