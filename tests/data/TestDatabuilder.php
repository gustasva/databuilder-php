<?php

namespace DatabuilderTests\data;

use Databuilder\Databuilder;

class TestDatabuilder extends Databuilder
{
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
}
