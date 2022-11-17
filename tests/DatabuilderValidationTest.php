<?php

namespace DatabuilderTests;

use Databuilder\DatabuilderInterface;
use Databuilder\DatabuilderTransformer;
use Databuilder\Exception\InvalidDatabuilderTransferNameException;
use Databuilder\Exception\InvalidPropertyException;
use DatabuilderTests\_data\ValidatorBuilders\InvalidDatabuilderTransferDatabuilder;
use DatabuilderTests\_data\ValidatorBuilders\InvalidPropertyDatabuilder;
use PHPUnit\Framework\TestCase;

class DatabuilderValidationTest extends TestCase
{
    private DatabuilderTransformer $transformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new DatabuilderTransformer();
    }

    /**
     * @throws \DOMException
     * @throws \ReflectionException
     */
    public function testValidatorThrowsExceptionWhenPropertyHasTwoCapitalLettersInARow(): void
    {
        $databuilder = $this->getDatabuilderWithInvalidDatabuilderTransferName();
        $this->expectException(InvalidDatabuilderTransferNameException::class);

        $this->transformer->transform($databuilder);
    }

    /**
     * @throws \DOMException
     * @throws \ReflectionException
     */
    public function testValidatorThrowsExceptionWhenDatabuilderTransferNameIsNotCamelCase(): void
    {
        $databuilder = $this->getDatabuilderWithInvalidProperty();
        $this->expectException(InvalidPropertyException::class);

        $this->transformer->transform($databuilder);
    }

    private function getDatabuilderWithInvalidProperty(): DatabuilderInterface
    {
        return new InvalidPropertyDatabuilder();
    }

    private function getDatabuilderWithInvalidDatabuilderTransferName(): DatabuilderInterface
    {
        return new InvalidDatabuilderTransferDatabuilder();
    }
}
