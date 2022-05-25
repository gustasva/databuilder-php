<?php

namespace Databuilder\Utils;

use DOMDocument;
use DOMElement;
use DOMException;

class XmlBuilder
{
    public const XML_VERSION = '1.0';

    public const ELEMENT_TRANSFERS = 'transfers';
    public const ELEMENT_TRANSFER = 'transfer';
    public const ELEMENT_PROPERTY = 'property';

    public const ATTRIBUTE_NAME = 'name';
    public const ATTRIBUTE_RULE = 'dataBuilderRule';

    public const ATTRIBUTE_XMLNS = 'spryker:databuilder-01';
    public const ATTRIBUTE_XMLNS_XSI = 'http://www.w3.org/2001/XMLSchema-instance';
    public const ATTRIBUTE_XSI_SCHEMA_LOCATION = 'spryker:databuilder-01 http://static.spryker.com/databuilder-01.xsd';

    /**
     * @throws DOMException
     */
    public function generate(array $databuilder): DOMDocument
    {
        $doc = new DOMDocument(static::XML_VERSION);
        $doc->formatOutput = true;
        $transfers = $this->createTransfersElement($doc);

        /**
         * @var string $transferName
         * @var string[] $properties
         */
        foreach ($databuilder as $transferName => $properties) {
            $transfer = $doc->createElement(static::ELEMENT_TRANSFER);
            $transfer->setAttribute(static::ATTRIBUTE_NAME, $transferName);

            /**
             * @var string $name
             * @var string $rule
             */
            foreach ($properties as $name => $rule) {
                $property = $doc->createElement(static::ELEMENT_PROPERTY);
                $property->setAttribute(static::ATTRIBUTE_NAME, $name);
                $property->setAttribute(static::ATTRIBUTE_RULE, $rule);

                $transfer->appendChild($property);
            }

            $transfers->appendChild($transfer);
        }

        $doc->appendChild($transfers);

        return $doc;
    }

    /**
     * @throws DOMException
     */
    protected function createTransfersElement(DOMDocument $doc): DOMElement
    {
        $xmlDatabuilder = $doc->createElement(static::ELEMENT_TRANSFERS);

        $xmlDatabuilder->setAttribute('xmlns', static::ATTRIBUTE_XMLNS);
        $xmlDatabuilder->setAttribute('xmlns:xsi', static::ATTRIBUTE_XMLNS_XSI);
        $xmlDatabuilder->setAttribute('xsi:schemaLocation', static::ATTRIBUTE_XSI_SCHEMA_LOCATION);

        return $xmlDatabuilder;
    }
}
