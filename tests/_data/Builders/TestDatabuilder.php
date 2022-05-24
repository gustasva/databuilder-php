<?php

namespace DatabuilderTests\_data\Builders;

use Databuilder\Databuilder;

class TestDatabuilder extends Databuilder
{
    public const FILE_NAME = 'test';

    public function build(): array
    {
        return [
            'TestRegistration' => [
                'store' => $this->faker->word(),
                'name' => '=test',
                'age' => $this->faker->randomNumber()
            ],
            'AnotherObject' => [
                'test' => $this->faker->randomElement(['a', 'b']),
                'randomness' => $this->faker->word,
            ],
        ];
    }

    public function getName(): string
    {
        return self::FILE_NAME;
    }
}
