<?php

namespace Tests\Unit\Commands;

use YakoLabs\PdfToText\Commands\PdfFonts;

test('check if binary is found', function() {
    expect(PdfFonts::isBinaryFound())->toBeTrue();
});

test('get pdffonts version', function () {
    expect(PdfFonts::version())
        ->toContain('pdffonts version');
});

test('get pdffonts help', function () {
    expect(PdfFonts::help())
        ->toContain('Usage: pdffonts');
});

test('default command', function () {
    $pdf = PdfFonts::from('file.pdf');

    expect((string) $pdf)->toEqual('pdffonts file.pdf');
});

test('-f first page', function () {
    $pdf = PdfFonts::from('file.pdf')->firstPage(5);

    expect((string) $pdf)->toContain('-f 5');
});

test('-l last page', function () {
    $pdf = PdfFonts::from('file.pdf')->lastPage(10);

    expect((string) $pdf)->toContain('-l 10');
});

test('-subst flag', function () {
    $pdf = PdfFonts::from('file.pdf')->substitutions();

    expect((string) $pdf)->toContain('-subst');
});

test('-opw owner password', function () {
    $pdf = PdfFonts::from('file.pdf')->ownerPassword('secret');

    expect((string) $pdf)->toContain('-opw secret');
});

test('-upw user password', function () {
    $pdf = PdfFonts::from('file.pdf')->userPassword('123');

    expect((string) $pdf)->toContain('-upw 123');
});
