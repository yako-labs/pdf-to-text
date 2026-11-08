<?php

namespace Tests\Unit\Support;

use YakoLabs\PdfToText\Support\Console;

test('capture commands', function () {
    Console::startCapture();

    Console::captureCommand('pdftotext');
    Console::captureCommand('pdftohtml');

    $commands = Console::endCapture();

    expect($commands)
        ->toBeArray()
        ->toContain('pdftotext', 'pdftohtml');
});

test('checks the end of capturing', function () {
    Console::startCapture();

    Console::captureCommand('pdftotext');
    Console::captureCommand('pdftohtml');

    expect(Console::isCapturing())
        ->toBeTrue();

    Console::endCapture();

    expect(Console::isCapturing())
        ->toBeFalse();
});

test('groups of captures', function () {
    Console::startCapture();

    Console::captureCommand('command_level_1');

    Console::startCapture();
    Console::captureCommand('command_level_2');
    $commandsLevel2 = Console::endCapture();

    Console::startCapture();
    Console::captureCommand('command_level_3');
    $commandsLevel3 = Console::endCapture();


    Console::captureCommand('command_level_1');
    $commandsLevel1 = Console::endCapture();

    expect($commandsLevel1)
        ->toBeArray()
        ->toContain('command_level_1', 'command_level_1');

    expect($commandsLevel2)
        ->toBeArray()
        ->toContain('command_level_2');

    expect($commandsLevel3)
        ->toBeArray()
        ->toContain('command_level_3');
});

test('capture commands in callback', function () {
    $commands = Console::capture(function () {
        Console::captureCommand('pdftotext');
        Console::captureCommand('pdftohtml');
    });

    expect($commands)
        ->toBeArray()
        ->toContain('pdftotext', 'pdftohtml');
});
