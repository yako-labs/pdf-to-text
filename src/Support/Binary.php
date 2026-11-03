<?php

namespace YakoLabs\PdfToText\Support;

use InvalidArgumentException;
use YakoLabs\PdfToText\Exceptions\BinaryNotFoundException;
use YakoLabs\PdfToText\Exceptions\ExceptionHandler;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class Binary
{
    public const PDFTOTEXT = 'pdftotext';

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

    /** Get the version string of the binary */
    public static function version(string $binary): string
    {
        $process = new Process([$binary, '-v']);
        $process->run();

        if ($process->isSuccessful()) {
            return $process->getErrorOutput();
        }

        ExceptionHandler::fromProcess($process);
    }

    /** Execute a system command and return the process result */
    public static function run(array $command): string
    {
        if (empty($command)) {
            throw new InvalidArgumentException("Cannot run an empty command.");
        }

        self::require($command[0]);

        $process = new Process($command);
        $process->run();

        if ($process->isSuccessful()) {
            return $process->getOutput();
        }

        ExceptionHandler::fromProcess($process);
    }
}
