<?php

namespace DatabuilderTests\_data\Builders;

use Databuilder\Databuilder;

class AnotherDatabuilder extends Databuilder
{
    public const FILE_NAME = 'another';

    public function build(): array
    {
        return [
            'TestForm' => [
                'test' => $this->faker->word(),
            ],
        ];
    }

    public function getName(): string
    {
        return self::FILE_NAME;
    }
}