<?php

namespace Databuilder;

use Faker\Factory;
use Faker\Generator;

abstract class Databuilder implements DatabuilderInterface
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
}