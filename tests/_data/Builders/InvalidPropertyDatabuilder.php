<?php

namespace DatabuilderTests\_data\Builders;

use Databuilder\Databuilder;

class InvalidPropertyDatabuilder extends Databuilder
{
    public const FILE_NAME = 'invalid_property';

    public function build(): array
    {
        return [
            'ValidTransferName' => [
                'invalidPProperty' => $this->faker->word()
            ]
        ];
    }

    public function getName(): string
    {
        return self::FILE_NAME;
    }
}