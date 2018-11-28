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
    public function writeFile(string $filename, string $content = ''): void
    {
        if (!is_dir(dirname($filename))) {
            mkdir(dirname($filename), 0777, true);
        }
        $handle = fopen($filename, 'w');
        if ($handle === false) {
            throw new Exception("Unable to open file [$filename] for writing.");
        }

        fwrite($handle, $content);
        fclose($handle);
    }
}
