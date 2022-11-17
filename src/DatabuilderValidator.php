<?php

namespace Databuilder;

use Databuilder\Validators\PropertyCamelCaseRule;
use Databuilder\Validators\TransferNameDoubleCapitalRule;
use Databuilder\Validators\ValidatorRuleInterface;

class DatabuilderValidator
{
    /** @var array<ValidatorRuleInterface>|null */
    protected ?array $rules;

    public function validate(string $element, string $elementName): void
    {
        foreach ($this->getValidationRules() as $rule) {
            if ($rule->isSupported($elementName)) {
                $rule->validate($element);
            }
        }
    }

    /**
     * @return array<ValidatorRuleInterface>
     */
    protected function getValidationRules(): array
    {
        if (!isset($this->rules)) {
            $this->rules = $this->createValidationRules();
        }

        return $this->rules;
    }

    /**
     * @return array<ValidatorRuleInterface>
     */
    protected function createValidationRules(): array
    {
        return [
            new PropertyCamelCaseRule(),
            new TransferNameDoubleCapitalRule()
        ];
    }
}
