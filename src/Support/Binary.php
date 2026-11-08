<?php

namespace YakoLabs\PdfToText\Support;

use YakoLabs\PdfToText\Exceptions\BinaryNotFoundException;
use Symfony\Component\Process\ExecutableFinder;

class Binary
{
    /** Get the full path to the binary */
    public static function path(string $binary): ?string
    {
        return (new ExecutableFinder())->find($binary);
    }

    /** Check if the binary exists in the system */
    public static function exists(string $binary): bool
    {
        return self::path($binary) !== null;
    }

    /** Check if the binary is missing from the system */
    public static function missing(string $binary): bool
    {
        return ! self::exists($binary);
    }

    /** Assert that the binary exists, throwing an exception if it doesn't */
    public static function require(string $binary): void
    {
        if (self::missing($binary)) {
            throw new BinaryNotFoundException($binary);
        }
    }
}
