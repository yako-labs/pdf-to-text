<?php

namespace Tests;

use Symfony\Component\Process\Process;
use Throwable;
use YakoLabs\PdfToText\Exceptions\ExceptionHandler;

trait WithProcessMock
{
    public function mockProcessError(string $error, int $code = 1): Process
    {
        $process = $this->createMock(Process::class);
        $process->method('getErrorOutput')->willReturn($error);
        $process->method('getExitCode')->willReturn($code);

        return $process;
    }

    public function mockProcessException(string $error, int $code = 1): Throwable
    {
        $process = $this->mockProcessError($error, $code);

        return ExceptionHandler::fromProcess($process);
    }
}