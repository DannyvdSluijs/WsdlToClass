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

namespace WsdlToClass;

use Symfony\Component\Console\Output\OutputInterface;
use WsdlToClass\Wsdl\Wsdl;
use WsdlToClass\Wsdl\Struct;
use WsdlToClass\Wsdl\Property;
use WsdlToClass\Parser\IParser;
use WsdlToClass\Generator\ICompositeGenerator;
use WsdlToClass\Writer\IWriter;

/**
 * The WsdlToClass acts as facade class to simplify the overall process.
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
     * The generator to generate WsdlClass internals to classes
     * @var ICompositeGenerator
     */
    private $generator;

    /**
     * The writer to write the classes to file
     * @var IWriter
     */
    private $writer;

    /**
     * Constructor
     * @param Wsdl $wsdl
     * @param string $destination
     * @param string $namespacePrefix
     * @param IParser $parser
     * @param ICompositeGenerator $generator
     * @param IWriter $writer
     */
    public function __construct(
        Wsdl $wsdl,
        $destination,
        $namespacePrefix,
        IParser $parser,
        ICompositeGenerator $generator,
        IWriter $writer
    ) {
        $this->wsdl = $wsdl;
        $this->setDestination($destination);
        $this->namespacePrefix = (string) $namespacePrefix;
        $this->parser = $parser;
        $this->generator = $generator;
        $this->writer = $writer;
    }

    /**
     * Get the Wsdl
     * @return Wsdl
     */
    public function getWsdl(): Wsdl
    {
        return $this->wsdl;
    }

    /**
     * Set the Wsdl
     * @param Wsdl $wsdl
     * @return \WsdlToClass\WsdlToClass
     */
    public function setWsdl(Wsdl $wsdl): WsdlToClass
    {
        $this->wsdl = $wsdl;

        return $this;
    }

    /**
     * Get the destination folder
     * @return string
     */
    public function getDestination(): string
    {
        return $this->destination;
    }

    /**
     * Set the destination folder
     * @param string $destination
     * @return \WsdlToClass\WsdlToClass
     */
    public function setDestination($destination): WsdlToClass
    {
        $this->destination = (substr($destination, -1) == '/') ? substr($destination, 0, -1) : $destination;
        return $this;
    }

    /**
     * Get the namespace prefix
     * @return string
     */
    public function getNamespacePrefix(): string
    {
        return $this->namespacePrefix;
    }

    /**
     * Set the namespace prefix
     * @param string $namespacePrefix
     * @return \WsdlToClass\WsdlToClass
     */
    public function setNamespacePrefix($namespacePrefix): WsdlToClass
    {
        $this->namespacePrefix = (string) $namespacePrefix;

        return $this;
    }

    /**
     * Get the output interface
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    /**
     * Set the output interface
     * @param OutputInterface $output
     * @return \WsdlToClass\WsdlToClass
     */
    public function setOutput(OutputInterface $output): WsdlToClass
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @return IParser
     */
    public function getParser(): IParser
    {
        return $this->parser;
    }

    /**
     * @param IParser $parser
     * @return WsdlToClass
     */
    public function setParser(IParser $parser): WsdlToClass
    {
        $this->parser = $parser;
        return $this;
    }

    /**
     * @return ICompositeGenerator
     */
    public function getGenerator(): ICompositeGenerator
    {
        return $this->generator;
    }

    /**
     * @param ICompositeGenerator $generator
     * @return WsdlToClass
     */
    public function setGenerator(ICompositeGenerator $generator): WsdlToClass
    {
        $this->generator = $generator;
        return $this;
    }

    /**
     * Execte the wsdl to class
     * @return void
     */
    public function execute()
    {
        $this->generator->setNamespace($this->getNamespacePrefix());
        $this->setupDirectoryStructure()
            ->parseWsdl()
            ->generateStructures()
            ->generateRequests()
            ->generateResponses()
            ->generateMethods()
            ->generateService()
            ->generateClient()
            ->generateClassMap();
    }

    /**
     * Create the required directories
     * @return \WsdlToClass\WsdlToClass
     */
    protected function setupDirectoryStructure(): WsdlToClass
    {
        $this->output->writeln("Creating subdirectories.");
        $subDirectories = ['Method', 'Structure', 'Request', 'Response'];

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
    protected function parseWsdl(): WsdlToClass
    {
        $this->output->writeln("Parsing WSDL.");
        $client = new \SoapClient((string) $this->wsdl);

        foreach ($client->__getTypes() as $rawType) {
            $type = $this->parser->parseType($rawType);

            if ($type instanceof Struct) {
                $this->wsdl->addStruct($type->getName(), $type);
            } elseif ($type instanceof Property) {
                $this->wsdl->addSimpleType($type->getName(), $type);
            }
        }

        foreach ($client->__getFunctions() as $rawFunction) {
            $method = $this->parser->parseFunction($rawFunction);
            $this->wsdl->addMethod($method->getName(), $method);
        }

        return $this;
    }

    /**
     * Generate the structure classes
     * @return WsdlToClass
     */
    protected function generateStructures(): WsdlToClass
    {
        $this->output->writeln("Generating structures.");


        $this->generator->setChildNamespace('Structure');

        foreach ($this->wsdl->getStructures() as $name => $structure) {
            /* Request & response are generated in generateResponses */
            if ($this->wsdl->hasResponse($name) || $this->wsdl->hasRequest($name)) {
                continue;
            }

            $filename = $this->destination . DIRECTORY_SEPARATOR . 'Structure' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';
            $content = $structure->visit($this->generator);
            $this->writer->writeFile($filename, $content);
        }

        return $this;
    }

    /**
     * Generate the request classes
     * @return WsdlToClass
     */
    protected function generateRequests(): WsdlToClass
    {
        $this->output->writeln("Generating requests.");

        $this->generator->setChildNamespace('Request');

        foreach ($this->wsdl->getRequests() as $name => $request) {
            $filename = $this->destination . DIRECTORY_SEPARATOR . 'Request' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';
            $content = $request->visit($this->generator);
            $this->writer->writeFile($filename, $content);
        }

        return $this;
    }

    /**
     * Generate the response classes
     * @return WsdlToClass
     */
    protected function generateResponses(): WsdlToClass
    {
        $this->output->writeln("Generating responses.");

        $this->generator->setChildNamespace('Response');

        foreach ($this->wsdl->getResponses() as $name => $response) {
            $filename = $this->destination . DIRECTORY_SEPARATOR . 'Response' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';
            $content = $response->visit($this->generator);
            $this->writer->writeFile($filename, $content);
        }

        return $this;
    }

    /**
     * Generate the method classes
     * @return WsdlToClass
     */
    protected function generateMethods(): WsdlToClass
    {
        $this->output->writeln("Generating methods.");

        $this->generator->setChildNamespace('Method');
        foreach ($this->wsdl->getMethods() as $name => $method) {
            $filename = $this->destination . DIRECTORY_SEPARATOR . 'Method' . DIRECTORY_SEPARATOR . ucfirst($name) . '.php';
            $content = $method->visit($this->generator);
            $this->writer->writeFile($filename, $content);
        }

        return $this;
    }

    /**
     * Generate the service class
     * @return WsdlToClass
     */
    protected function generateService(): WsdlToClass
    {
        $this->output->writeln("Generating service.");

        $this->generator->setNamespace($this->getNamespacePrefix());
        $filename = $this->destination . DIRECTORY_SEPARATOR . 'Service.php';
        $content = $this->wsdl->visit($this->generator);
        $this->writer->writeFile($filename, $content);

        return $this;
    }

    /**
     * Generate the client class
     * @return WsdlToClass
     */
    protected function generateClient(): WsdlToClass
    {
        $this->output->writeln("Generating client.");

        $this->generator->setNamespace($this->getNamespacePrefix());
        $filename = $this->destination . DIRECTORY_SEPARATOR . 'Client.php';
        $content = $this->generator->generateClient($this->wsdl);
        $this->writer->writeFile($filename, $content);

        return $this;
    }

    /**
     * Generate the class map class
     * @return WsdlToClass
     */
    protected function generateClassMap(): WsdlToClass
    {
        $this->output->writeln("Generating class map.");

        $this->generator->setNamespace($this->getNamespacePrefix());
        $filename = $this->destination . DIRECTORY_SEPARATOR . 'ClassMap.php';
        $content = $this->generator->generateClassMap($this->wsdl);
        $this->writer->writeFile($filename, $content);

        return $this;
    }
}
