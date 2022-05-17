<?php

namespace DatabuilderTests\data;

use Databuilder\Databuilder;

class TestDatabuilder extends Databuilder
{
    public function build(): array
    {
        return [
            'TestRegistration' => [
                'store' => $this->faker->word()
            ]
        ];
    }
}
