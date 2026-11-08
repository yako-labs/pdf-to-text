<?php

namespace Tests\Unit\Support;

use YakoLabs\PdfToText\Exceptions\BinaryNotFoundException;
use YakoLabs\PdfToText\Support\Binary;

test('get binary path', function () {
    expect(Binary::path('pdftotext'))
        ->toBeString()
        ->toContain('pdftotext');
});

test('check if binary exists', function () {
    expect(Binary::exists('pdftotext'))
        ->toBeTrue();
});

test('check if binary doesnt exist', function () {
    expect(Binary::missing('missing-binary'))
        ->toBeTrue();
});

test('binary is required', function () {
    expect(fn () => Binary::require('missing-binary'))
        ->toThrow(BinaryNotFoundException::class);
});
