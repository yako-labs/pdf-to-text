<?php

namespace YakoLabs\PdfToText\Commands;

use YakoLabs\PdfToText\Support\Binary;

class PdfUnite extends Command
{
    /** @var string|null Destination PDF file path */
    protected ?string $destinationFile = null;

    /** Get the pdfunite binary name */
    public static function binary(): string
    {
        return 'pdfunite';
    }

    /** @param string[] $pdfs PDF files to merge */
    public function __construct(
        protected array $pdfs
    ) {}

    /** Create a new instance from PDF files */
    public static function from(array $pdfs): self
    {
        return new self($pdfs);
    }

    /** Get the PDF files to merge */
    public function pdfs(): array
    {
        return $this->pdfs;
    }

    /** Add a PDF file to merge */
    public function add(string $path): self
    {
        $this->pdfs[] = $path;

        return $this;
    }

    /** Set the destination PDF file path */
    public function destinationFile(string $path): self
    {
        $this->destinationFile = $path;

        return $this;
    }

    /** @return string[] Build the pdfunite command array */
    protected function build(): array
    {
        $command = [self::binary()];

        foreach ($this->pdfs as $pdf) {
            $command[] = $pdf;
        }

        $command[] = $this->destinationFile;

        return $command;
    }

    /** Merge the PDF files into the destination file */
    public function save(): true
    {
        $this->run();

        return true;
    }

    /** Merge the PDF files into a specific destination file */
    public function saveAs(string $path): true
    {
        return $this->destinationFile($path)->save();
    }

    /** Get the PDF files to merge as an array */
    public function toArray(): array
    {
        return $this->pdfs();
    }
}
