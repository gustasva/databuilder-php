<?php

namespace Databuilder\Validators;

use Databuilder\Exception\InvalidPropertyException;
use Databuilder\Utils\XmlBuilder;

class PropertyCamelCaseRule implements ValidatorRuleInterface
{
    public function validate(string $element): void
    {
        if (!preg_match('/^[a-z]+(?:[A-Z][a-z]+)*$/', $element)) {
            throw new InvalidPropertyException();
        }
    }

    public function isSupported(string $elementName): bool
    {
        return $elementName === XmlBuilder::ELEMENT_PROPERTY;
    }
}
