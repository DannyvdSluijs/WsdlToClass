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

use Symfony\Component\Console\Output\OutputInterface;

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

    private $destination;

    private $namespacePrefix;

    /**
     *
     * @var OutputInterface
     */
    private $output;

    /**
     *
     * @var \WsdlToClass\Parser\IParser
     */
    private $parser;

    /**
     * @param Wsdl\Wsdl          $wsdl
     * @param Parser\RegexParser $parser
     */
    public function __construct($wsdl, $destination, $namespacePrefix, $parser)
    {
        $this->wsdl = $wsdl;
        $this->destination = $destination;
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

    public function getDestination()
    {
        return $this->destination;
    }

    public function setDestination($output)
    {
        $this->destination = $output;

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

    public function getOutput()
    {
        return $this->output;
    }

    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
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
        $this->output->writeln("Creating subdirectories.");
        $subDirectories = array('Method', 'Structure', 'Request', 'Response');

        foreach ($subDirectories as $subDir) {
            $fqdn = $this->getDestination() . DIRECTORY_SEPARATOR . $subDir;
            if (!is_dir($fqdn)) {
                $this->output->writeln("\tCreating subdirectory '$fqdn'");
                mkdir($fqdn);
            }
        }

        return $this;
    }

    protected function parseWsdl()
    {
        $this->output->writeln("Parsing WSDL.");
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
        $this->output->writeln("Generating structures.");

        $generator = new Generator\Generator();
        $generator->setNamespace($this->getNamespacePrefix() . '\Structure');

        foreach ($this->wsdl->getStructures() as $name => $structure) {
            /* Request & response are generated in generateResponses */
            if ($this->wsdl->hasResponse($name) || $this->wsdl->hasRequest($name)) {
                continue;
            }

            $filename = $this->destination . DIRECTORY_SEPARATOR . 'Structure' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';

            $handle = fopen($filename, 'w');
            fwrite($handle, $structure->visit($generator));
            fclose($handle);
        }

        return $this;
    }

    protected function generateRequests()
    {
        $this->output->writeln("Generating requests.");

        $generator = new Generator\Generator();
        $generator->setNamespace($this->getNamespacePrefix() . '\Request');

        foreach ($this->wsdl->getRequests() as $name => $request) {
            $filename = $this->destination . DIRECTORY_SEPARATOR . 'Request' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';
            $handle = fopen($filename, 'w');
            fwrite($handle, $request->visit($generator));
            fclose($handle);
        }

        return $this;
    }

    protected function generateResponses()
    {
        $this->output->writeln("Generating responses.");

        $generator = new Generator\Generator();
        $generator->setNamespace($this->getNamespacePrefix() . '\Response');

        foreach ($this->wsdl->getResponses() as $name => $response) {
            $filename = $this->destination . DIRECTORY_SEPARATOR . 'Response' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';
            $handle = fopen($filename, 'w');
            fwrite($handle, $response->visit($generator));
            fclose($handle);
        }

        return $this;
    }

    protected function generateMethods()
    {
        $this->output->writeln("Generating methods.");

        $generator = new Generator\Generator();
        $generator->setNamespace($this->getNamespacePrefix());
        foreach ($this->wsdl->getMethods() as $name => $method) {
            $filename = $this->destination . DIRECTORY_SEPARATOR . 'Method' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';
            $handle = fopen($filename, 'w');
            fwrite($handle, $method->visit($generator));
            fclose($handle);
        }

        return $this;
    }

    protected function generateService()
    {
        $this->output->writeln("Generating service.");

        $serviceGenerator = new Generator\ServiceGenerator();
        $serviceGenerator->setNamespace($this->getNamespacePrefix());
        $filename = $this->destination . DIRECTORY_SEPARATOR . 'Service.php';

        $handle = fopen($filename, 'w');
        fwrite($handle, $this->wsdl->visit($serviceGenerator));
        fclose($handle);

        return $this;
    }

    protected function generateClassMap()
    {
        $this->output->writeln("Generating class map.");

        $generator = new Generator\Generator();
        $generator->setNamespace($this->getNamespacePrefix());
        $filename = $this->destination . DIRECTORY_SEPARATOR . 'ClassMap.php';

        $handle = fopen($filename, 'w');
        fwrite($handle, $generator->generateClassMap($this->wsdl));
        fclose($handle);

        return $this;
    }
}
