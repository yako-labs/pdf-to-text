<?php

namespace Tests\Unit\Exceptions;


use Tests\WithProcessMock;
use YakoLabs\PdfToText\Exceptions\Process\CommandLineException;
use YakoLabs\PdfToText\Exceptions\Process\ConfigException;
use YakoLabs\PdfToText\Exceptions\Process\IncorrectPasswordException;
use YakoLabs\PdfToText\Exceptions\Process\InternalException;
use YakoLabs\PdfToText\Exceptions\Process\IOException;
use YakoLabs\PdfToText\Exceptions\Process\PermissionException;
use YakoLabs\PdfToText\Exceptions\Process\ProcessFailedException;
use YakoLabs\PdfToText\Exceptions\Process\SyntaxException;
use YakoLabs\PdfToText\Exceptions\Process\UnimplementedFeatureException;

uses(WithProcessMock::class);

test('syntax error supported', function () {
    $exception = $this->mockProcessException('Syntax Error: Invalid PDF');
    
    expect($exception)
        ->toBeInstanceOf(SyntaxException::class);
});

test('config error supported', function () {
    $exception = $this->mockProcessException('Config Error: Invalid config');
    
    expect($exception)
        ->toBeInstanceOf(ConfigException::class);
});

test('command line error supported', function () {
    $exception = $this->mockProcessException('Command Line Error: Unknown option');
    
    expect($exception)
        ->toBeInstanceOf(CommandLineException::class);
});

test('incorrect password error supported', function () {
    $exception = $this->mockProcessException('Command Line Error: Incorrect password for encrypted PDF');
    
    expect($exception)
        ->toBeInstanceOf(IncorrectPasswordException::class);
});

test('i/o error supported', function () {
    $exception = $this->mockProcessException('I/O Error: File not found');
    
    expect($exception)
        ->toBeInstanceOf(IOException::class);
});

test('permission error supported', function () {
    $exception = $this->mockProcessException('Permission Error: Access denied');
    
    expect($exception)
        ->toBeInstanceOf(PermissionException::class);
});

test('unimplemented feature supported', function () {
    $exception = $this->mockProcessException('Unimplemented Feature: Not supported');
    
    expect($exception)
        ->toBeInstanceOf(UnimplementedFeatureException::class);
});

test('internal error supported', function () {
    $exception = $this->mockProcessException('Internal Error: Something went wrong');
    
    expect($exception)
        ->toBeInstanceOf(InternalException::class);
});

test('unknown error supported', function () {
    $exception = $this->mockProcessException('Unknown error occurred');
    
    expect($exception)
        ->toBeInstanceOf(ProcessFailedException::class);
});