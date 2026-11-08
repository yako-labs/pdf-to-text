<?php

namespace YakoLabs\PdfToText\Exceptions;

use RuntimeException;

class BinaryNotFoundException extends RuntimeException
{
    /** Create the exception for a missing binary */
    public function __construct(string $binary, int $code = 0)
    {
        parent::__construct("The '{$binary}' binary was not found in your system.", $code);
    }
}
