<?php

namespace DatabuilderTests;

use Databuilder\DatabuilderTransformer;
use DatabuilderTests\_data\Builders\TestDatabuilder;
use DOMDocument;
use DOMException;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use ReflectionException;

class DatabuilderTransformerTest extends TestCase
{
    private DatabuilderTransformer $transformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->transformer = new DatabuilderTransformer();
    }

    /**
     * @throws ReflectionException
     * @throws DOMException
     */
    public function testTransformsPhpDatabuilderToXmlDatabuilder(): void
    {
        $phpDatabuilder = $this->getPhpDatabuilder();
        $xmlDatabuilder = $this->getXmlDatabuilder();

        $transformerPhpDatabuilder = $this->transformer->transform($phpDatabuilder);

        $this->assertEquals(
            $xmlDatabuilder->saveXML(),
            $transformerPhpDatabuilder->saveXML(),
            'Databuilder transformation has failed!'
        );
    }

    protected function getPhpDatabuilder(): TestDatabuilder
    {
        return new TestDatabuilder();
    }

    private function getXmlDatabuilder(): DOMDocument
    {
        $doc = new DOMDocument('1.0');
        $doc->formatOutput = true;
        $xmlDatabuilder = $doc->createElement('transfers');
        $xmlDatabuilder->setAttribute('xmlns', 'spryker:databuilder-01');
        $xmlDatabuilder->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $xmlDatabuilder->setAttribute(
            'xsi:schemaLocation',
            'spryker:databuilder-01 http://static.spryker.com/databuilder-01.xsd'
        );

        $transfer = $doc->createElement('transfer');
        $transfer->setAttribute('name', 'TestRegistration');

        $property = $doc->createElement('property');
        $property->setAttribute('name', 'store');
        $property->setAttribute('dataBuilderRule', 'word()');

        $property2 = $doc->createElement('property');
        $property2->setAttribute('name', 'name');
        $property2->setAttribute('dataBuilderRule', '=test');

        $property3 = $doc->createElement('property');
        $property3->setAttribute('name', 'age');
        $property3->setAttribute('dataBuilderRule', 'randomNumber()');

        $transfer->appendChild($property);
        $transfer->appendChild($property2);
        $transfer->appendChild($property3);

        $transfer2 = $doc->createElement('transfer');
        $transfer2->setAttribute('name', 'AnotherObject');

        $property = $doc->createElement('property');
        $property->setAttribute('name', 'test');
        $property->setAttribute('dataBuilderRule', 'randomElement([\'a\', \'b\'])');

        $property2 = $doc->createElement('property');
        $property2->setAttribute('name', 'randomness');
        $property2->setAttribute('dataBuilderRule', 'word');

        $transfer2->appendChild($property);
        $transfer2->appendChild($property2);

        $xmlDatabuilder->appendChild($transfer);
        $xmlDatabuilder->appendChild($transfer2);
        $doc->appendChild($xmlDatabuilder);

        return $doc;
    }
}
