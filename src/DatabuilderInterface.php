<?php

namespace Databuilder;

interface DatabuilderInterface
{
    public function build(): array;

    public function getName(): string;
}