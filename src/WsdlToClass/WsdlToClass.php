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
use WsdlToClass\Wsdl\Wsdl;
use WsdlToClass\Parser\IParser;

/**
 * The WsdlToClass acts as facade class to simplyfy the overall process.
 *
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
class WsdlToClass
{
    /**
     * The Wsdl class
     * @var Wsdl
     */
    private $wsdl;

    /**
     * The destination to output generated classes
     * @var string
     */
    private $destination;

    /**
     * A default namespace prefix
     * @var string
     */
    private $namespacePrefix;

    /**
     * The output interface to output progression
     * @var OutputInterface
     */
    private $output;

    /**
     * The parser to parse PHP internals to WsdlToClass internals
     * @var IParser
     */
    private $parser;

    /**
     * Constructor
     * @param Wsdl\Wsdl $wsdl
     * @param string $destination
     * @param string $namespacePrefix
     * @param IParser $parser
     */
    public function __construct(Wsdl $wsdl, $destination, $namespacePrefix, IParser $parser)
    {
        $this->wsdl = $wsdl;
        $this->destination = (string) $destination;
        $this->namespacePrefix = (string) $namespacePrefix;
        $this->parser = $parser;
    }

    /**
     * Get the Wsdl
     * @return Wsdl
     */
    public function getWsdl()
    {
        return $this->wsdl;
    }

    /**
     * Set the Wsdl
     * @param Wsdl $wsdl
     * @return \WsdlToClass\WsdlToClass
     */
    public function setWsdl(Wsdl $wsdl)
    {
        $this->wsdl = $wsdl;

        return $this;
    }

    /**
     * Get the destination folder
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set the destination folder
     * @param type $destination
     * @return \WsdlToClass\WsdlToClass
     */
    public function setDestination($destination)
    {
        $this->destination = (string) $destination;

        return $this;
    }

    /**
     * Get the namespace prefix
     * @return string
     */
    public function getNamespacePrefix()
    {
        return $this->namespacePrefix;
    }

    /**
     * Set the namespace prefix
     * @param string $namespacePrefix
     * @return \WsdlToClass\WsdlToClass
     */
    public function setNamespacePrefix($namespacePrefix)
    {
        $this->namespacePrefix = (string) $namespacePrefix;

        return $this;
    }

    /**
     * Get the output interface
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Set the output interface
     * @param OutputInterface $output
     * @return \WsdlToClass\WsdlToClass
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
        return $this;
    }

    /**
     * Execte the wsdl to class
     * @return void
     */
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

    /**
     * Create the required directories
     * @return \WsdlToClass\WsdlToClass
     */
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

    /**
     * Parse a  wsdl to the WsdlToClass internals
     * @return \WsdlToClass\WsdlToClass
     */
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

    /**
     * Generate the structure classes
     * @return \WsdlToClass\WsdlToClass
     */
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

    /**
     * Generate the request classes
     * @return \WsdlToClass\WsdlToClass
     */
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

    /**
     * Generate the response classes
     * @return \WsdlToClass\WsdlToClass
     */
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

    /**
     * Generate the method classes
     * @return \WsdlToClass\WsdlToClass
     */
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

    /**
     * Generate the service class
     * @return \WsdlToClass\WsdlToClass
     */
    protected function generateService()
    {
        $this->output->writeln("Generating service.");

        $serviceGenerator = new Generator\Generator();
        $serviceGenerator->setNamespace($this->getNamespacePrefix());
        $filename = $this->destination . DIRECTORY_SEPARATOR . 'Service.php';

        $handle = fopen($filename, 'w');
        fwrite($handle, $this->wsdl->visit($serviceGenerator));
        fclose($handle);

        return $this;
    }

    /**
     * Generate the class map class
     * @return \WsdlToClass\WsdlToClass
     */
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
