<?php

namespace Databuilder;

use ReflectionException;

class DatabuilderTransformer
{
    protected Parser $parser;

    public function __construct()
    {
        $this->parser = new Parser();
    }

    /**
     * @throws ReflectionException
     */
    public function transform(DatabuilderInterface $phpDatabuilder)
    {
        $parsedData = $this->parser->parse($phpDatabuilder);


        return '';
    }


}