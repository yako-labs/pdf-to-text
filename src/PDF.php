<?php

namespace YakoLabs\PdfToText;

use YakoLabs\PdfToText\Commands\PdfFonts;
use YakoLabs\PdfToText\Commands\PdfInfo;
use YakoLabs\PdfToText\Commands\PdfToText;

final class PDF
{
    public function __construct(
        protected string $pdf
    ) {}

    /** Create a new instance from a PDF file */
    public static function from(string $pdf): self
    {
        return new self($pdf);
    }

    /** Get the PDF file path */
    public function pdf(): string
    {
        return $this->pdf;
    }

    /** Create a PdfInfo command instance */
    public function info(): PdfInfo
    {
        return new PdfInfo($this->pdf);
    }

    /** Create a PdfFonts command instance */
    public function fonts(): PdfFonts
    {
        return new PdfFonts($this->pdf);
    }

    /** Create a PdfToText command instance */
    public function toText(): PdfToText
    {
        return new PdfToText($this->pdf);
    }
}