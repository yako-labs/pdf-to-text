<?php

namespace YakoLabs\PdfToText\Commands;

use YakoLabs\PdfToText\Support\Binary;

class PdfInfo
{
    public const BINARY = Binary::PDFINFO;

    /** @var array<string, mixed> Command options */
    protected array $command = [
        '-f' => null,
        '-l' => null,
        '-box' => false,
        '-meta' => false,
        '-custom' => false,
        '-js' => false,
        '-struct' => false,
        '-struct-text' => false,
        '-isodates' => false,
        '-rawdates' => false,
        '-dests' => false,
        '-url' => false,
        '-enc' => null,
        '-listenc' => false,
        '-opw' => null,
        '-upw' => null,
    ];

    public function __construct(
        protected readonly string $pdf
    ) {}

    /** Create a new instance from a PDF file */
    public static function from(string $pdf): self
    {
        return new self($pdf);
    }

    /** Get the PDF file path */
    public function pdf(): ?string
    {
        return $this->pdf;
    }

    /** Set -f <int> first page to convert */
    public function firstPage(?int $page): self
    {
        $this->command['-f'] = $page;

        return $this;
    }

    /** Set -l <int> last page to convert */
    public function lastPage(?int $page): self
    {
        $this->command['-l'] = $page;

        return $this;
    }

    /** Set -box print the page bounding boxes */
    public function box(bool $box = true): self
    {
        $this->command['-box'] = $box;

        return $this;
    }

    /** Set -meta print the document metadata (XML) */
    public function metadata(bool $metadata = true): self
    {
        $this->command['-meta'] = $metadata;

        return $this;
    }

    /** Set -custom print both custom and standard metadata */
    public function customMetadata(bool $customMetadata = true): self
    {
        $this->command['-custom'] = $customMetadata;

        return $this;
    }

    /** Set -js print all JavaScript in the PDF */
    public function javascript(bool $javascript = true): self
    {
        $this->command['-js'] = $javascript;

        return $this;
    }

    /** Set -struct print the logical document structure (for tagged files) */
    public function structure(bool $structure = true): self
    {
        $this->command['-struct'] = $structure;

        return $this;
    }

    /** Set -struct-text print text contents along with document structure (for tagged files) */
    public function structureWithText(bool $structureWithText = true): self
    {
        $this->command['-struct-text'] = $structureWithText;

        return $this;
    }

    /** Set -isodates print the dates in ISO-8601 format */
    public function isoDates(bool $isoDates = true): self
    {
        $this->command['-isodates'] = $isoDates;

        return $this;
    }

    /** Set -rawdates print the undecoded date strings directly from the PDF file */
    public function rawDates(bool $rawDates = true): self
    {
        $this->command['-rawdates'] = $rawDates;

        return $this;
    }

    /** Set -dests print all named destinations in the PDF */
    public function destinations(bool $destinations = true): self
    {
        $this->command['-dests'] = $destinations;

        return $this;
    }

    /** Set -url print all URLs inside PDF objects (does not scan text content) */
    public function urls(bool $urls = true): self
    {
        $this->command['-url'] = $urls;

        return $this;
    }

    /** Set -enc <string> output text encoding name */
    public function encoding(?string $encoding): self
    {
        $this->command['-enc'] = $encoding;

        return $this;
    }

    /** Set -listenc list available encodings */
    public function listEncodings(bool $listEncodings = true): self
    {
        $this->command['-listenc'] = $listEncodings;

        return $this;
    }

    /** Set -opw <string> owner password (for encrypted files) */
    public function ownerPassword(?string $password): self
    {
        $this->command['-opw'] = $password;

        return $this;
    }

    /** Set -upw <string> user password (for encrypted files) */
    public function userPassword(?string $password): self
    {
        $this->command['-upw'] = $password;

        return $this;
    }

    /** @return string[] Build the pdftotext command array */
    protected function buildCommand(): array
    {
        $command = [self::BINARY];

        foreach ($this->command as $key => $value) {
            if ($value === true) {
                $command[] = $key;
            } elseif ($value !== null && $value !== false) {
                $command[] = $key;
                $command[] = (string) $value;
            }
        }
        
        $command[] = $this->pdf;

        return $command;
    }

    /** Execute the pdftotext command and return the output */
    public function run(): string
    {
        return Binary::run($this->buildCommand());
    }

    /** Check if pdftotext is available in the system */
    public static function isBinaryFound(): bool
    {
        return Binary::exists(self::BINARY);
    }

    /** Get pdftotext version and copyright information */
    public static function version(): string
    {
        return Binary::version(self::BINARY);
    }

    public static function help(): string
    {
        return Binary::help(self::BINARY);
    }

    public function toArray(): array
    {
        return array_merge(
            $this->command,
            [
                'input' => $this->pdf,
            ]
        );
    }

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