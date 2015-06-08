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

/**
 * Description of WsdlToClass
 *
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
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

    /**
     * @param Wsdl\Wsdl          $wsdl
     * @param Parser\RegexParser $parser
     */
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

    /**
     * @return string
     */
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
            ->generateStructures()
            ->generateRequests()
            ->generateResponses()
            ->generateMethods()
            ->generateService()
            ->generateClassMap();
    }

    protected function setupDirectoryStructure()
    {
        $subDirectories = array('Method', 'Structure', 'Request', 'Response');

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
            $struct = $this->parser->parseType($rawType);
            $this->wsdl->addStruct($struct->getName(), $struct);
        }

        foreach ($client->__getFunctions() as $rawFunction) {
            $method = $this->parser->parseFunction($rawFunction);
            $this->wsdl->addMethod($method->getName(), $method);
        }

        return $this;
    }

    protected function generateStructures()
    {
        $generator = new Generator\Generator();
        $generator->setNamespace($this->getNamespacePrefix() . '\Structure');

        foreach ($this->wsdl->getStructures() as $name => $structure) {
            /* Request & response are generated in generateResponses */
            if ($this->wsdl->hasResponse($name) || $this->wsdl->hasRequest($name)) {
                continue;
            }

            $filename = $this->output . DIRECTORY_SEPARATOR . 'Structure' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';

            $handle = fopen($filename, 'w');
            fwrite($handle, $structure->visit($generator));
            fclose($handle);
        }

        return $this;
    }

    protected function generateRequests()
    {
        $generator = new Generator\Generator();
        $generator->setNamespace($this->getNamespacePrefix() . '\Request');

        foreach ($this->wsdl->getRequests() as $name => $request) {
            $filename = $this->output . DIRECTORY_SEPARATOR . 'Request' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';
            $handle = fopen($filename, 'w');
            fwrite($handle, $request->visit($generator));
            fclose($handle);
        }

        return $this;
    }

    protected function generateResponses()
    {
        $generator = new Generator\Generator();
        $generator->setNamespace($this->getNamespacePrefix() . '\Response');

        foreach ($this->wsdl->getResponses() as $name => $response) {
            $filename = $this->output . DIRECTORY_SEPARATOR . 'Response' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';
            $handle = fopen($filename, 'w');
            fwrite($handle, $response->visit($generator));
            fclose($handle);
        }

        return $this;
    }

    protected function generateMethods()
    {
        $generator = new Generator\Generator();
        $generator->setNamespace($this->getNamespacePrefix());
        foreach ($this->wsdl->getMethods() as $name => $method) {
            $filename = $this->output . DIRECTORY_SEPARATOR . 'Method' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';
            $handle = fopen($filename, 'w');
            fwrite($handle, $method->visit($generator));
            fclose($handle);
        }

        return $this;
    }

    protected function generateService()
    {
        $serviceGenerator = new Generator\ServiceGenerator();
        $serviceGenerator->setNamespace($this->getNamespacePrefix());
        $filename = $this->output . DIRECTORY_SEPARATOR . 'Service.php';

        $handle = fopen($filename, 'w');
        fwrite($handle, $this->wsdl->visit($serviceGenerator));
        fclose($handle);

        return $this;
    }

    protected function generateClassMap()
    {
        $generator = new Generator\Generator();
        $generator->setNamespace($this->getNamespacePrefix());
        $filename = $this->output . DIRECTORY_SEPARATOR . 'ClassMap.php';

        $handle = fopen($filename, 'w');
        fwrite($handle, $generator->generateClassMap($this->wsdl));
        fclose($handle);

        return $this;
    }
}
