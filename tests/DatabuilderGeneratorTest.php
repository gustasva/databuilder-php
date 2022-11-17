<?php

namespace DatabuilderTests;

use Databuilder\DatabuilderGenerator;
use PHPUnit\Framework\TestCase;

class DatabuilderGeneratorTest extends TestCase
{
    private DatabuilderGenerator $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->generator = new DatabuilderGenerator();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        array_map('unlink', glob(__DIR__ . '/_data/*.xml'));
    }


    public function testDatabuilderGenerating(): void
    {
        $this->generator->generate();

        $this->assertFileExists(__DIR__ . '/_data/test.databuilder.xml');
        $this->assertFileExists(__DIR__ . '/_data/another.databuilder.xml');
    }
}
