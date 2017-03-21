<?php

/*
 * WsdlToClass
 *
 * PHP Version 5.6
 *
 * @copyright 2015 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */
namespace WsdlToClass\Writer;

/**
 * Description of ResourceWriter
 *
 * @author dannyvandersluijs
 */
class ResourceWriter implements IWriter
{
    public function writeFile($filename, $content = '')
    {
        $handle = fopen($filename, 'w');
        fwrite($handle, $content);
        fclose($handle);
    }
}
