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

namespace WsdlToClass\Writer;

/**
 *
 */
interface IWriter
{
    /**
     * @param string $filename
     * @param string $content
     */
    public function writeFile(string $filename, string $content = ''):void;
}
