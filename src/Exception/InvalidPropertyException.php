<?php

namespace Databuilder\Exception;

use InvalidArgumentException;
use SebastianBergmann\RecursionContext\Exception;
use Throwable;

class InvalidPropertyException extends InvalidArgumentException implements Exception
{
    public function __construct(
        $message = "Property does not match camel case.",
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
