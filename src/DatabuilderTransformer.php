<?php

namespace Databuilder;

use Databuilder\Utils\Parser;
use Databuilder\Utils\XmlBuilder;
use DOMDocument;
use DOMException;
use ReflectionException;

class DatabuilderTransformer
{
    protected Parser $parser;
    protected XmlBuilder $generator;

    public function __construct()
    {
        $this->parser = new Parser();
        $this->generator = new XmlBuilder();
    }

    /**
     * @throws ReflectionException
     * @throws DOMException
     */
    public function transform(DatabuilderInterface $phpDatabuilder): DOMDocument
    {
        $parsedData = $this->parser->parse($phpDatabuilder);

        $databuilder = $this->generator->generate($parsedData);

        return $databuilder;
    }
}