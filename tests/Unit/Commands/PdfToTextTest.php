<?php

namespace Tests\Unit\Commands;

use YakoLabs\PdfToText\Commands\PdfToText;

test('check if binary is found', function() {
    expect(PdfToText::isBinaryFound())->toBeTrue();
});

test('get pdftotext version', function () {
    expect(PdfToText::version())
        ->toContain('pdftotext version');
});

test('default command', function () {
    $pdf = PdfToText::from('file.pdf');

    expect((string) $pdf)->toEqual('pdftotext file.pdf');
});

test('-f first page', function () {
    $pdf = PdfToText::from('file.pdf')->firstPage(5);

    expect((string) $pdf)->toContain('-f 5');
});

test('-l last page', function () {
    $pdf = PdfToText::from('file.pdf')->lastPage(10);

    expect((string) $pdf)->toContain('-l 10');
});

test('-r resolution', function () {
    $pdf = PdfToText::from('file.pdf')->resolution(300);

    expect((string) $pdf)->toContain('-r 300');
});

test('-x crop X', function () {
    $pdf = PdfToText::from('file.pdf')->cropX(10);

    expect((string) $pdf)->toContain('-x 10');
});

test('-y crop Y', function () {
    $pdf = PdfToText::from('file.pdf')->cropY(20);

    expect((string) $pdf)->toContain('-y 20');
});

test('-W crop width', function () {
    $pdf = PdfToText::from('file.pdf')->cropWidth(100);

    expect((string) $pdf)->toContain('-W 100');
});

test('-H crop height', function () {
    $pdf = PdfToText::from('file.pdf')->cropHeight(200);

    expect((string) $pdf)->toContain('-H 200');
});

test('cropArea sets all crop values', function () {
    $pdf = PdfToText::from('file.pdf')->cropArea(10, 20, 100, 200);

    expect((string) $pdf)->toContain('-x 10')
        ->toContain('-y 20')
        ->toContain('-W 100')
        ->toContain('-H 200');
});

test('-layout flag', function () {
    $pdf = PdfToText::from('file.pdf')->layout();

    expect((string) $pdf)->toContain('-layout');
});

test('-fixed flag', function () {
    $pdf = PdfToText::from('file.pdf')->fixedPitch(1.5);

    expect((string) $pdf)->toContain('-fixed 1.5');
});

test('-raw flag', function () {
    $pdf = PdfToText::from('file.pdf')->raw();

    expect((string) $pdf)->toContain('-raw');
});

test('-remove-hyphens flag', function () {
    $pdf = PdfToText::from('file.pdf')->removeHyphens(PdfToText::HYPHENS_SOFT);

    expect((string) $pdf)->toContain('-remove-hyphens soft');
});

test('-remove-hyphens default is all', function () {
    $pdf = PdfToText::from('file.pdf')->removeHyphens();

    expect((string) $pdf)->toContain('-remove-hyphens all');
});

test('-nodiag flag', function () {
    $pdf = PdfToText::from('file.pdf')->noDiagonalText();

    expect((string) $pdf)->toContain('-nodiag');
});

test('-htmlmeta flag', function () {
    $pdf = PdfToText::from('file.pdf')->htmlMeta();

    expect((string) $pdf)->toContain('-htmlmeta');
});

test('-tsv flag', function () {
    $pdf = PdfToText::from('file.pdf')->tsv();

    expect((string) $pdf)->toContain('-tsv');
});

test('-enc flag', function () {
    $pdf = PdfToText::from('file.pdf')->encoding('UTF-8');

    expect((string) $pdf)->toContain('-enc UTF-8');
});

test('-eol flag', function () {
    $pdf = PdfToText::from('file.pdf')->endOfLine('unix');

    expect((string) $pdf)->toContain('-eol unix');
});

test('-nopgbrk flag', function () {
    $pdf = PdfToText::from('file.pdf')->noPageBreaks();

    expect((string) $pdf)->toContain('-nopgbrk');
});

test('-bbox flag', function () {
    $pdf = PdfToText::from('file.pdf')->boundingBox();

    expect((string) $pdf)->toContain('-bbox');
});

test('-bbox-layout flag', function () {
    $pdf = PdfToText::from('file.pdf')->boundingBoxLayout();

    expect((string) $pdf)->toContain('-bbox-layout');
});

test('-cropbox flag', function () {
    $pdf = PdfToText::from('file.pdf')->cropBox();

    expect((string) $pdf)->toContain('-cropbox');
});

test('-colspacing flag', function () {
    $pdf = PdfToText::from('file.pdf')->columnSpacing(0.7);

    expect((string) $pdf)->toContain('-colspacing 0.7');
});

test('-opw owner password', function () {
    $pdf = PdfToText::from('file.pdf')->ownerPassword('secret');

    expect((string) $pdf)->toContain('-opw secret');
});

test('-upw user password', function () {
    $pdf = PdfToText::from('file.pdf')->userPassword('123');

    expect((string) $pdf)->toContain('-upw 123');
});

test('-q quiet flag', function () {
    $pdf = PdfToText::from('file.pdf')->quiet();

    expect((string) $pdf)->toContain('-q');
});