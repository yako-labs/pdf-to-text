<?php

namespace YakoLabs\PdfToText\Support;

use InvalidArgumentException;
use YakoLabs\PdfToText\Exceptions\ExceptionHandler;
use Symfony\Component\Process\Process;

final class Console
{
    /** Run a command and return the process, throwing an exception if it fails */
    public static function successfulProcess(array $command): Process
    {
        if (empty($command)) {
            throw new InvalidArgumentException("Cannot run an empty command.");
        }

        Binary::require($command[0]);

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw ExceptionHandler::fromProcess($process);
        }

        return $process;
    }
}
