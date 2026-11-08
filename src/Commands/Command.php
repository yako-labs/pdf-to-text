<?php

namespace YakoLabs\PdfToText\Commands;

use Stringable;
use YakoLabs\PdfToText\Support\Console;
use YakoLabs\PdfToText\Support\Binary;

abstract class Command implements Stringable
{
    /** Get the binary name used by the command */
    abstract static function binary(): string;

    /** Build the command arguments array */
    abstract protected function build(): array;

    /** Check if the command binary is available in the system */
    public static function isBinaryFound(): bool
    {
        return Binary::exists(static::binary());
    }

    /** Get the version string of the binary */
    public static function version(): string
    {
        return Console::successfulProcess([static::binary(), '-v'])->getErrorOutput();
    }

    /** Get the binary usage information */
    public static function help(): string
    {
        return Console::successfulProcess([static::binary(), '-h'])->getErrorOutput();
    }

    /** Execute a system command and return the process result */
    public static function run(array $command): string
    {
        return Console::successfulProcess($command)->getOutput();
    }

    /** Convert to string representation of the command */
    public function __toString(): string
    {
        return implode(' ', $this->build());
    }
}
