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

namespace WsdlToClass\Writer;

/**
 *
 */
class ResourceWriter implements IWriter
{
    public function writeFile(string $filename, string $content = '')
    {
        $handle = fopen($filename, 'w');
        fwrite($handle, $content);
        fclose($handle);
    }
}
