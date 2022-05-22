<?php

namespace Databuilder;

use ReflectionClass;
use ReflectionException;

class Parser
{
    /**
     * @throws ReflectionException
     */
    public function parse(DatabuilderInterface $phpDatabuilder): array
    {
        $databuilderClass = get_class($phpDatabuilder);
        $builderReflection = new ReflectionClass($databuilderClass);

        $methodReflection = $builderReflection->getMethod('build');

        $methodLength = $methodReflection->getEndLine() - $methodReflection->getStartLine();
        $source = file($methodReflection->getFileName());

        $body = array_slice($source, $methodReflection->getStartLine(), $methodLength);

        $builderName = '';
        $databuilderProperties = [];

        foreach ($body as $line) {
            if ($this->containsAssignment($line) && $this->containsOpeningSquareBracketAsLastChar($line)) {
                $builderName = $this->searchForDatabuilderName($line);
            }

            if ($builderName && $this->isPropertyAssignment($line)) {
                $databuilderProperties[$builderName][$this->getPropertyName($line)] = $this->getPropertyValue($line);
            }

            if ($this->containsClosingSquareBracketOrCommaAsLastChar($line)) {
                $builderName = '';
            }
        }

        return $databuilderProperties;
    }

    protected function containsAssignment(string $line): bool
    {
        return strpos($line, '=>') !== false;
    }

    protected function containsOpeningSquareBracketAsLastChar(string $line): bool
    {
        return substr(trim($line), -1)  === '[';
    }

    protected function containsClosingSquareBracketOrCommaAsLastChar(string $line): bool
    {
        $twoLastChars = substr(trim($line), -2);

        return in_array($twoLastChars, [']', '],']);
    }

    protected function searchForDatabuilderName(string $line): string
    {
        return $this->searchForQuotedValueAndReturnFirstValue($line);
    }

    protected function isPropertyAssignment(string $line): bool
    {
        return $this->containsAssignment($line) &&
            !$this->isDatabuilderAssignment($line);
    }

    protected function getPropertyName(string $line): string
    {
        return $this->searchForQuotedValueAndReturnFirstValue($line);
    }

    protected function getPropertyValue(string $line): string
    {
        $propertyValue = '';

        preg_match('/(?<==>|=> )[$\'"].*/', $line, $propertyValue);

        if (is_array($propertyValue)) {
            return $this->stripTrailingCommasAndQuotes(reset($propertyValue));
        }

        return $propertyValue;
    }

    protected function searchForQuotedValueAndReturnFirstValue(string $line): string
    {
        $value = '';

        preg_match('/(?<=[\'"])(.*?)(?=[\'"])/', $line, $value);

        if (is_array($value)) {
            return reset($value);
        }

        return $value;
    }

    protected function isDatabuilderAssignment(string $line): bool
    {
        return preg_match('/[\'"][^\'\"]+[\'"] => \[/', $line);
    }

    protected function stripTrailingCommasAndQuotes(string $propertyValue): string
    {
        return trim($propertyValue, '\'",');
    }
}