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

use PhpParser\NodeTraverser;
use PhpParser\ParserFactory;
use WsdlToClass\Exception\Exception;
use WsdlToClass\Exception\InvalidArgumentException;
use WsdlToClass\Util\ClassNameFinder;
use WsdlToClass\Util\Printer;
use WsdlToClass\Validator\NamespaceValidator;
use WsdlToClass\Wsdl\Method;
use WsdlToClass\Wsdl\Request;
use WsdlToClass\Wsdl\Response;
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
    private $namespace;

    /**
     * The output interface to output progression
     * @var Printer
     */
    private $printer;

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
     * @param string $namespace
     * @param IParser $parser
     * @param ICompositeGenerator $generator
     * @param IWriter $writer
     * @param Printer $printer
     */
    public function __construct(
        Wsdl $wsdl,
        $destination,
        $namespace,
        IParser $parser,
        ICompositeGenerator $generator,
        IWriter $writer,
        Printer $printer
    ) {
        $this->wsdl = $wsdl;
        $this->setDestination($destination);
        $this->parser = $parser;
        $this->generator = $generator;
        $this->writer = $writer;
        $this->printer = $printer;
        $this->setNamespace($namespace);
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
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * Set the namespace prefix
     * @param string $namespace
     * @return WsdlToClass
     * @throws InvalidArgumentException
     */
    public function setNamespace($namespace): WsdlToClass
    {
        $validator = new NamespaceValidator();
        if (!$validator->isValid($namespace)) {
            throw InvalidArgumentException::forArgument('namespace', $namespace);
        }

        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get the output interface
     * @return Printer
     */
    public function getPrinter(): Printer
    {
        return $this->printer;
    }

    /**
     * Set the output interface
     * @param Printer $printer
     * @return \WsdlToClass\WsdlToClass
     */
    public function setPrinter(Printer $printer): WsdlToClass
    {
        $this->printer = $printer;
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
        $this->generator->setNamespace($this->getNamespace());
        $this->parseWsdl()
            ->generateStructures()
            ->generateRequests()
            ->generateResponses()
            ->generateMethods()
            ->generateService()
            ->generateClient()
            ->generateClassMap();
    }

    /**
     * Parse a  wsdl to the WsdlToClass internals
     * @return \WsdlToClass\WsdlToClass
     */
    private function parseWsdl(): WsdlToClass
    {
        $this->printer->writeln("Parsing WSDL.");
        $client = new \SoapClient((string) $this->wsdl);

        foreach ($client->__getTypes() as $rawType) {
            $type = $this->parser->parseType($rawType);

            if ($type instanceof Struct) {
                $this->wsdl->addStruct($type);
            } elseif ($type instanceof Property) {
                $this->wsdl->addSimpleType($type);
            }
        }

        foreach ($client->__getFunctions() as $rawFunction) {
            $method = $this->parser->parseFunction($rawFunction);
            $this->wsdl->addMethod($method);
        }

        return $this;
    }

    /**
     * Generate the structure classes
     * @return WsdlToClass
     */
    private function generateStructures(): WsdlToClass
    {
        $this->printer->writeln("Generating structures.");
        $this->generator->setChildNamespace('Structure');

        /** @var Struct $structure */
        foreach ($this->wsdl->getStructures() as $name => $structure) {
            $this->printer->writeln(" |\-Generating structure $name");
            $this->generate($structure);
        }

        return $this;
    }

    /**
     * Generate the request classes
     * @return WsdlToClass
     */
    private function generateRequests(): WsdlToClass
    {
        $this->printer->writeln("Generating requests.");
        $this->generator->setChildNamespace('Request');

        /** @var Request $request */
        foreach ($this->wsdl->getRequests() as $name => $request) {
            $this->printer->writeln(" |\-Generating request $name");
            $this->generate($request);
        }

        return $this;
    }

    /**
     * Generate the response classes
     * @return WsdlToClass
     */
    private function generateResponses(): WsdlToClass
    {
        $this->printer->writeln("Generating responses.");
        $this->generator->setChildNamespace('Response');

        /** @var Response $response */
        foreach ($this->wsdl->getResponses() as $name => $response) {
            $this->printer->writeln(" |\-Generating response $name");
            $this->generate($response);
        }

        return $this;
    }

    /**
     * Generate the method classes
     * @return WsdlToClass
     */
    private function generateMethods(): WsdlToClass
    {
        $this->printer->writeln("Generating methods.");
        $this->generator->setChildNamespace('Method');

        /** @var Method $method */
        foreach ($this->wsdl->getMethods() as $name => $method) {
            $this->printer->writeln(" |\-Generating method $name");
            $code = $method->visit($this->generator);
            $className = $this->findClassName($code);
            $filename = $this->destination . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

            $this->writer->writeFile($filename, $code);
            $this->printer->writeln("  |- Wrote $className to $filename");
        }

        return $this;
    }

    /**
     * Generate the service class
     * @return WsdlToClass
     */
    private function generateService(): WsdlToClass
    {
        $this->printer->writeln("Generating service.");
        $this->generator->setNamespace($this->getNamespace());

        $code = $this->wsdl->visit($this->generator);
        $className = $this->findClassName($code);
        $filename = $this->destination . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        $this->writer->writeFile($filename, $code);
        $this->printer->writeln("  |- Wrote $className to $filename");

        return $this;
    }

    /**
     * Generate the client class
     * @return WsdlToClass
     */
    private function generateClient(): WsdlToClass
    {
        $this->printer->writeln("Generating client.");
        $this->generator->setNamespace($this->getNamespace());

        $code = $this->generator->generateClient($this->wsdl);
        $className = $this->findClassName($code);
        $filename = $this->destination . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        $this->writer->writeFile($filename, $code);
        $this->printer->writeln("  |- Wrote $className to $filename");

        return $this;
    }

    /**
     * Generate the class map class
     * @return WsdlToClass
     */
    private function generateClassMap(): WsdlToClass
    {
        $this->printer->writeln("Generating class map.");
        $this->generator->setNamespace($this->getNamespace());

        $code = $this->generator->generateClassMap($this->wsdl);
        $className = $this->findClassName($code);
        $filename = $this->destination . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        $this->writer->writeFile($filename, $code);
        $this->printer->writeln("  |- Wrote $className to $filename");

        return $this;
    }

    private function generate(Struct $struct)
    {
        $code = $struct->visit($this->generator);
        $className = $this->findClassName($code);
        $filename = $this->destination . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        $this->writer->writeFile($filename, $code);
        $this->printer->writeln("  |- Wrote $className to $filename");
    }

    /**
     * @param $code
     * @return string
     */
    private function findClassName($code): string
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {
            $ast = $parser->parse($code);
        } catch (\Exception $e) {
            throw new Exception('Error "' . $e->getMessage() . '" in ' . $code);
            die();
        }

        $traverser = new NodeTraverser();
        $classNameFinder = new ClassNameFinder();
        $traverser->addVisitor($classNameFinder);

        $traverser->traverse($ast);

        return (string) $classNameFinder;
    }
}
