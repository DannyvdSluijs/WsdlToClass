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

use \WsdlToClass\Wsdl\Wsdl;

/**
 * Description of ServiceGenerator
 *
 * @author dannyvandersluijs
 */
class ClassMapGenerator extends AbstractGenerator implements IClassMapGenerator
{
    /**
     *
     * @param \WsdlToClass\Wsdl\Wsdl $wsdl
     * @return type
     */
    public function generateClassMap(Wsdl $wsdl)
    {
        return <<<EOT
<?php

namespace {$this->getNamespace()};

class ClassMap\n{\n
    public static function getMapping()
    {
        return array(
        );
    }
}
EOT;
    }

}
