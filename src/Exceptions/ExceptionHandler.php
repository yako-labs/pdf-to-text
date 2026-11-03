<?php

namespace YakoLabs\PdfToText\Exceptions;

use YakoLabs\PdfToText\Exceptions\Process\CommandLineException;
use YakoLabs\PdfToText\Exceptions\Process\ConfigException;
use YakoLabs\PdfToText\Exceptions\Process\IncorrectPasswordException;
use YakoLabs\PdfToText\Exceptions\Process\InternalException;
use YakoLabs\PdfToText\Exceptions\Process\IOException;
use YakoLabs\PdfToText\Exceptions\Process\PermissionException;
use YakoLabs\PdfToText\Exceptions\Process\ProcessFailedException;
use YakoLabs\PdfToText\Exceptions\Process\SyntaxException;
use YakoLabs\PdfToText\Exceptions\Process\UnimplementedFeatureException;
use RuntimeException;
use Symfony\Component\Process\Process;

class ExceptionHandler
{
    /** Create the appropriate exception from a Symfony Process */
    public static function fromProcess(Process $process): RuntimeException
    {
        $error = trim($process->getErrorOutput());
        $code = $process->getExitCode();

        return match(true) {
            // Specific
            str_contains($error, 'Incorrect password') => new IncorrectPasswordException($error, $code),

            // General
            str_starts_with($error, 'Syntax Error') => new SyntaxException($error, $code),
            str_starts_with($error, 'Config Error') => new ConfigException($error, $code),
            str_starts_with($error, 'Command Line Error') => new CommandLineException($error, $code),
            str_starts_with($error, 'I/O Error') => new IOException($error, $code),
            str_starts_with($error, 'Permission Error') => new PermissionException($error, $code),
            str_starts_with($error, 'Unimplemented Feature') => new UnimplementedFeatureException($error, $code),
            str_starts_with($error, 'Internal Error') => new InternalException($error, $code),

            // Default
            default => new ProcessFailedException($error, $code),
        };
    }
}
