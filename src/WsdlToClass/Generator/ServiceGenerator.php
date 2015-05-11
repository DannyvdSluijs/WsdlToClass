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
class ServiceGenerator implements IServiceGenerator
{
    public function generate(\WsdlToClass\Wsdl\Wsdl $wsdl)
    {
        return <<<EOT
namespace Todo;

class Service {
    
}
EOT;
    }

}
