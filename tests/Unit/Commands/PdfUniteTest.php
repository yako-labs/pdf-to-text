<?php

namespace Tests\Unit\Commands;

use YakoLabs\PdfToText\Commands\PdfUnite;

test('check if binary is found', function() {
    expect(PdfUnite::isBinaryFound())->toBeTrue();
});

test('get pdfunite version', function () {
    expect(PdfUnite::version())
        ->toContain('pdfunite version');
});

test('get pdfunite help', function () {
    expect(PdfUnite::help())
        ->toContain('Usage: pdfunite');
});

test('default command', function () {
    $pdf = PdfUnite::from(['file.pdf'])->destinationFile('output.pdf');

    expect((string) $pdf)->toEqual('pdfunite file.pdf output.pdf');
});

test('add new pdfs', function () {
    $pdf = PdfUnite::from([]);

    $pdf->add('file1.pdf');
    $pdf->add('file2.pdf');
    
    $pdf->destinationFile('output.pdf');

    expect((string) $pdf)->toEqual('pdfunite file1.pdf file2.pdf output.pdf');
});