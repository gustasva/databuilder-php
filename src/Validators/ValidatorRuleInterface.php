<?php

namespace Databuilder\Validators;

interface ValidatorRuleInterface
{
    public function validate(string $element): void;

    public function isSupported(string $elementName): bool;
}
