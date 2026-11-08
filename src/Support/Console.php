<?php

namespace YakoLabs\PdfToText\Support;

use Closure;
use LogicException;
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

        static::captureCommand($process->getCommandLine());

        if (!$process->isSuccessful()) {
            throw ExceptionHandler::fromProcess($process);
        }

        return $process;
    }

    /** @var array<int, string[]> Stack of active capture levels */
    protected static array $captures = [];

    /** Run a callback while capturing the commands executed within it */
    public static function capture(Closure $callback): array
    {
        static::startCapture();

        try {
            $callback();
        } finally {
            $commands = static::endCapture();
        }

        return $commands;
    }

    /** Start a new capture level */
    public static function startCapture(): void
    {
        static::$captures[] = [];
    }

    /** Add a command to the current capture level */
    public static function captureCommand(string $command): void
    {
        if (!static::isCapturing()) {
            return;
        }

        $lastKey = array_key_last(static::$captures);

        static::$captures[$lastKey][] = $command;
    }

    /** Check if a capture is currently active */
    public static function isCapturing(): bool
    {
        return static::$captures !== [];
    }

    /** End the current capture level and return its captured commands */
    public static function endCapture(): array
    {
        if (!static::isCapturing()) {
            throw new LogicException('Cannot end capture: no capture is in progress.');
        }

        return array_pop(static::$captures);
    }

    /** Clear all active capture levels */
    public static function flushCaptures(): void
    {
        static::$captures = [];
    }
}
