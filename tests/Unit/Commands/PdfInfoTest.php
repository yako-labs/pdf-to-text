<?php

namespace Tests\Unit\Commands;

use YakoLabs\PdfToText\Commands\PdfInfo;

test('check if binary is found', function() {
    expect(PdfInfo::isBinaryFound())->toBeTrue();
});

test('get pdfinfo version', function () {
    expect(PdfInfo::version())
        ->toContain('pdfinfo version');
});

test('get pdfinfo help', function () {
    expect(PdfInfo::help())
        ->toContain('Usage: pdfinfo');
});

test('default command', function () {
    $pdf = PdfInfo::from('file.pdf');

    expect((string) $pdf)->toEqual('pdfinfo file.pdf');
});

test('-f first page', function () {
    $pdf = PdfInfo::from('file.pdf')->firstPage(5);

    expect((string) $pdf)->toContain('-f 5');
});

test('-l last page', function () {
    $pdf = PdfInfo::from('file.pdf')->lastPage(10);

    expect((string) $pdf)->toContain('-l 10');
});

test('-box flag', function () {
    $pdf = PdfInfo::from('file.pdf')->box();

    expect((string) $pdf)->toContain('-box');
});

test('-meta flag', function () {
    $pdf = PdfInfo::from('file.pdf')->metadata();

    expect((string) $pdf)->toContain('-meta');
});

test('-custom flag', function () {
    $pdf = PdfInfo::from('file.pdf')->customMetadata();

    expect((string) $pdf)->toContain('-custom');
});

test('-js flag', function () {
    $pdf = PdfInfo::from('file.pdf')->javascript();

    expect((string) $pdf)->toContain('-js');
});

test('-struct flag', function () {
    $pdf = PdfInfo::from('file.pdf')->structure();

    expect((string) $pdf)->toContain('-struct');
});

test('-struct-text flag', function () {
    $pdf = PdfInfo::from('file.pdf')->structureWithText();

    expect((string) $pdf)->toContain('-struct-text');
});

test('-isodates flag', function () {
    $pdf = PdfInfo::from('file.pdf')->isoDates();

    expect((string) $pdf)->toContain('-isodates');
});

test('-rawdates flag', function () {
    $pdf = PdfInfo::from('file.pdf')->rawDates();

    expect((string) $pdf)->toContain('-rawdates');
});

test('-dests flag', function () {
    $pdf = PdfInfo::from('file.pdf')->destinations();

    expect((string) $pdf)->toContain('-dests');
});

test('-url flag', function () {
    $pdf = PdfInfo::from('file.pdf')->urls();

    expect((string) $pdf)->toContain('-url');
});

test('-enc encoding', function () {
    $pdf = PdfInfo::from('file.pdf')->encoding('UTF-8');

    expect((string) $pdf)->toContain('-enc UTF-8');
});

test('-listenc flag', function () {
    $pdf = PdfInfo::from('file.pdf')->listEncodings();

    expect((string) $pdf)->toContain('-listenc');
});

test('-opw owner password', function () {
    $pdf = PdfInfo::from('file.pdf')->ownerPassword('secret');

    expect((string) $pdf)->toContain('-opw secret');
});

test('-upw user password', function () {
    $pdf = PdfInfo::from('file.pdf')->userPassword('123');

    expect((string) $pdf)->toContain('-upw 123');
});
