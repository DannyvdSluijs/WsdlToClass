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

use WsdlToClass\Exception\Exception;

/**
 *
 */
class ResourceWriter implements IWriter
{
    /**
     * @param string $filename
     * @param string $content
     * @throws Exception
     */
    public function writeFile(string $filename, string $content = '')
    {
        $handle = fopen($filename, 'w');
        if ($handle === false) {
            throw new Exception("Unable to open file [$filename] for writing.");
        }

        fwrite($handle, $content);
        fclose($handle);
    }
}
