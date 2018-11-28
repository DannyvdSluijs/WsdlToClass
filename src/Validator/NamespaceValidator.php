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

namespace WsdlToClass\Validator;

/**
 * @todo write class doc
 */
class NamespaceValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    private $keywords = [
        'abstract',
        'and',
        'array',
        'as',
        'break',
        'callable',
        'case',
        'catch',
        'class',
        'clone',
        'const',
        'continue',
        'declare',
        'default',
        'die',
        'do',
        'echo',
        'else',
        'elseif',
        'empty',
        'enddeclare',
        'endfor',
        'endforeach',
        'endif',
        'endswitch',
        'endwhile',
        'eval',
        'exit',
        'extends',
        'final',
        'finally',
        'for',
        'foreach',
        'function',
        'global',
        'goto',
        'if',
        'implements',
        'include',
        'instanceof',
        'insteadof',
        'interface',
        'isset',
        'list',
        'namespace',
        'new',
        'or',
        'print',
        'private',
        'protected',
        'public',
        'require',
        'return',
        'static',
        'switch',
        'throw',
        'trait',
        'try',
        'unset',
        'use',
        'var',
        'while',
        'xor',
        'yield'
    ];

    /**
     * @param string $value
     * @return bool
     */
    public function isValid(string $value): bool
    {
        /* Validate the namespace value as a correct namespace */
        if (!preg_match('/^(([A-Za-z]+)(\\\\[A-Za-z]+)*)$/m', $value)) {
            return false;
        }

        /* Validate the namespace value not to contain reserved keywords */
        $elements = explode('\\', $value);
        $elements = array_map('strtolower', $elements);
        $found = array_intersect($this->keywords, $elements);

        if (count($found)) {
            return false;
        }

        return true;
    }
}
