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

namespace WsdlToClass;

use WsdlToClass\Wsdl;
/**
 * Description of WsdlToClass
 *
 * @author dannyvandersluijs
 */
class WsdlToClass
{
    /**
     *
     * @var \WsdlToClass\Wsdl\Wsdl
     */
    private $wsdl;

    private $output;

    private $namespacePrefix;

    /**
     *
     * @var \WsdlToClass\Parser\IParser
     */
    private $parser;

    public function __construct($wsdl, $output, $namespacePrefix, $parser)
    {
        $this->wsdl = $wsdl;
        $this->output = $output;
        $this->namespacePrefix = $namespacePrefix;
        $this->parser = $parser;
    }

        public function getWsdl()
    {
        return $this->wsdl;
    }

    public function setWsdl(Wsdl\Wsdl $wsdl)
    {
        $this->wsdl = $wsdl;
        return $this;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput($output)
    {
        $this->output = $output;
        return $this;
    }

    public function getNamespacePrefix()
    {
        return $this->namespacePrefix;
    }

    public function setNamespacePrefix($namespacePrefix)
    {
        $this->namespacePrefix = $namespacePrefix;
        return $this;
    }

    public function execute()
    {
        $this->setupDirectoryStructure()
            ->parseWsdl()
            ->generateModels()
            ->generateRequests()
            ->generateResponses()
            ->generateService()
            ->generateClassMap();
    }

    protected function setupDirectoryStructure()
    {
        $subDirectories = array('Method', 'Model', 'Request', 'Response');

        foreach ($subDirectories as $subDir) {
            if (!is_dir($this->getOutput() . DIRECTORY_SEPARATOR . $subDir)) {
                mkdir($this->getOutput() . DIRECTORY_SEPARATOR . $subDir);
            }
        }

        return $this;
    }

    protected function parseWsdl()
    {
        $client = new \SoapClient((string) $this->wsdl);

        foreach ($client->__getTypes() as $rawType) {
            $struct = $this->parser->parse($rawType);
            $this->wsdl->addModel($struct->getName(), $struct);
        }

        foreach ($client->__getFunctions() as $rawFunction) {
            var_dump($rawFunction);
        }

        return $this;
    }

    protected function generateModels()
    {
        $modelGenerator = new Generator\ModelGenerator();
        foreach ($this->wsdl->getModels() as $name => $model) {
            $filename = $this->output . DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';

            $handle = fopen($filename, 'w');
            fwrite($handle, $model->visit($modelGenerator));
            fclose($handle);

        }
        return $this;
    }

    protected function generateRequests()
    {
        return $this;
    }

    protected function generateResponses()
    {
        return $this;
    }

    protected function generateService()
    {
        return $this;
    }

    protected function generateClassMap()
    {
        return $this;
    }
}
