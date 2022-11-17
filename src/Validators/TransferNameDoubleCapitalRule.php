<?php

namespace Databuilder\Validators;

use Databuilder\Exception\InvalidDatabuilderTransferNameException;
use Databuilder\Utils\XmlBuilder;

class TransferNameDoubleCapitalRule implements ValidatorRuleInterface
{
    public function validate(string $element): void
    {
        if (preg_match('/([A-Z]{2,})/', $element)) {
            throw new InvalidDatabuilderTransferNameException();
        }
    }

    public function isSupported(string $elementName): bool
    {
        return $elementName === XmlBuilder::ELEMENT_TRANSFER;
    }
}
