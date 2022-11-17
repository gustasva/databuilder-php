<?php

namespace Databuilder\Exception;

use InvalidArgumentException;
use SebastianBergmann\RecursionContext\Exception;
use Throwable;

class InvalidDatabuilderTransferNameException extends InvalidArgumentException implements Exception
{
    public function __construct(
        $message = "Two capital letters in a row in a transfer name.",
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
