<?php

namespace Databuilder;

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
    public function transform(DatabuilderInterface $phpDatabuilder)
    {
        $parsedData = $this->parser->parse($phpDatabuilder);

        $databuilder = $this->generator->generate($parsedData);

        return $databuilder;
    }
}