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
     */
    public function setWsdl(Wsdl $wsdl): void
    {
        $this->wsdl = $wsdl;
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
     */
    public function setDestination($destination): void
    {
        $this->destination = (substr($destination, -1) == '/') ? substr($destination, 0, -1) : $destination;
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
     * @throws InvalidArgumentException
     */
    public function setNamespace($namespace): void
    {
        $validator = new NamespaceValidator();
        if (!$validator->isValid($namespace)) {
            throw InvalidArgumentException::forArgument('namespace', $namespace);
        }

        $this->namespace = $namespace;
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
     */
    public function setPrinter(Printer $printer): void
    {
        $this->printer = $printer;
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
     */
    public function setParser(IParser $parser): void
    {
        $this->parser = $parser;
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
     */
    public function setGenerator(ICompositeGenerator $generator): void
    {
        $this->generator = $generator;
    }

    /**
     * Execute the wsdl to class
     */
    public function execute(): void
    {
        $this->generator->setNamespace($this->getNamespace());
        $this->parseWsdl();
        $this->generateStructures();
        $this->generateRequests();
        $this->generateResponses();
        $this->generateMethods();
        $this->generateService();
        $this->generateClient();
        $this->generateClassMap();
        ;
    }

    /**
     * Parse a  wsdl to the WsdlToClass internals
     */
    private function parseWsdl(): void
    {
        $this->printer->writeln('Parsing WSDL.');
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
    }

    /**
     * Generate the structure classes
     */
    private function generateStructures(): void
    {
        $this->printer->writeln('Generating structures.');
        $this->generator->setChildNamespace('Structure');

        /** @var Struct $structure */
        foreach ($this->wsdl->getStructures() as $name => $structure) {
            $this->printer->writeln(" |\-Generating structure $name");
            $this->generate($structure);
        }
    }

    /**
     * Generate the request classes
     */
    private function generateRequests(): void
    {
        $this->printer->writeln('Generating requests.');
        $this->generator->setChildNamespace('Request');

        /** @var Request $request */
        foreach ($this->wsdl->getRequests() as $name => $request) {
            $this->printer->writeln(" |\-Generating request $name");
            $this->generate($request);
        }
    }

    /**
     * Generate the response classes
     */
    private function generateResponses(): void
    {
        $this->printer->writeln('Generating responses.');
        $this->generator->setChildNamespace('Response');

        /** @var Response $response */
        foreach ($this->wsdl->getResponses() as $name => $response) {
            $this->printer->writeln(" |\-Generating response $name");
            $this->generate($response);
        }
    }

    /**
     * Generate the method classes
     */
    private function generateMethods(): void
    {
        $this->printer->writeln('Generating methods.');
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
    }

    /**
     * Generate the service class
     */
    private function generateService(): void
    {
        $this->printer->writeln('Generating service.');
        $this->generator->setNamespace($this->getNamespace());

        $code = $this->wsdl->visit($this->generator);
        $className = $this->findClassName($code);
        $filename = $this->destination . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        $this->writer->writeFile($filename, $code);
        $this->printer->writeln("  |- Wrote $className to $filename");
    }

    /**
     * Generate the client class
     */
    private function generateClient(): void
    {
        $this->printer->writeln('Generating client.');
        $this->generator->setNamespace($this->getNamespace());

        $code = $this->generator->generateClient($this->wsdl);
        $className = $this->findClassName($code);
        $filename = $this->destination . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        $this->writer->writeFile($filename, $code);
        $this->printer->writeln("  |- Wrote $className to $filename");
    }

    /**
     * Generate the class map class
     */
    private function generateClassMap(): void
    {
        $this->printer->writeln('Generating class map.');
        $this->generator->setNamespace($this->getNamespace());

        $code = $this->generator->generateClassMap($this->wsdl);
        $className = $this->findClassName($code);
        $filename = $this->destination . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        $this->writer->writeFile($filename, $code);
        $this->printer->writeln("  |- Wrote $className to $filename");
    }

    /**
     * @param Struct $struct
     * @throws Exception
     */
    private function generate(Struct $struct): void
    {
        $code = $struct->visit($this->generator);
        $className = $this->findClassName($code);
        $filename = $this->destination . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        $this->writer->writeFile($filename, $code);
        $this->printer->writeln("  |- Wrote $className to $filename");
    }

    /**
     * @param string $code
     * @return string
     * @throws Exception
     */
    private function findClassName(string $code): string
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        try {
            $ast = $parser->parse($code);
        } catch (\Exception $e) {
            throw new Exception('Error "' . $e->getMessage() . '" in ' . $code);
        }

        $nodeTraverser = new NodeTraverser();
        $classNameFinder = new ClassNameFinder();
        $nodeTraverser->addVisitor($classNameFinder);

        $nodeTraverser->traverse($ast);

        return (string) $classNameFinder;
    }
}
