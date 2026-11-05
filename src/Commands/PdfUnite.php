<?php

namespace YakoLabs\PdfToText\Commands;

use YakoLabs\PdfToText\Support\Binary;

class PdfUnite
{
    public const BINARY = Binary::PDFUNITE;

    /** @var string|null Destination PDF file path */
    protected ?string $destinationFile = null;

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
    protected function buildCommand(): array
    {
        $command = [self::BINARY];

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

    /** Execute the pdfunite command and return the output */
    protected function run(): string
    {
        return Binary::run($this->buildCommand());
    }

    /** Check if pdfunite is available in the system */
    public static function isBinaryFound(): bool
    {
        return Binary::exists(self::BINARY);
    }

    /** Get pdfunite version and copyright information */
    public static function version(): string
    {
        return Binary::version(self::BINARY);
    }

    /** Print pdfunite usage information */
    public static function help(): string
    {
        return Binary::help(self::BINARY);
    }

    /** Get the PDF files to merge as an array */
    public function toArray(): array
    {
        return $this->pdfs();
    }

    /** Build the command as a string */
    public function toString(): string
    {
        return implode(' ', $this->buildCommand());
    }

    /** Convert to string representation of the command */
    public function __toString(): string
    {
        return $this->toString();
    }
}