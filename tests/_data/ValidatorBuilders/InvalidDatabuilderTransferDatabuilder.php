<?php

namespace DatabuilderTests\_data\ValidatorBuilders;

use Databuilder\Databuilder;

class InvalidDatabuilderTransferDatabuilder extends Databuilder
{
    public const FILE_NAME = 'invalid_databuilder_name';

    public function build(): array
    {
        return [
            'InvalidNName' => [
                'test' => $this->faker->word()
            ]
        ];
    }

    public function getName(): string
    {
        return self::FILE_NAME;
    }
}
