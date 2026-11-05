<?php

namespace YakoLabs\PdfToText\Commands;

use YakoLabs\PdfToText\Support\Binary;

class PdfFonts
{
    public const BINARY = Binary::PDFFONTS;

    /** @var array<string, mixed> Command options */
    protected array $command = [
        '-f' => null,
        '-l' => null,
        '-subst' => false,
        '-opw' => null,
        '-upw' => null,
    ];

    /** @param string $pdf PDF file path */
    public function __construct(
        protected readonly string $pdf
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

    /** Set -subst show font substitutions */
    public function substitutions(bool $substitutions = true): self
    {
        $this->command['-subst'] = $substitutions;

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

    /** @return string[] Build the pdffonts command array */
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

    /** Execute pdffonts and return the font listing */
    public function all(): string
    {
        return $this->run();
    }

    /** Execute the pdffonts command and return the output */
    protected function run(): string
    {
        return Binary::run($this->buildCommand());
    }

    /** Check if pdffonts is available in the system */
    public static function isBinaryFound(): bool
    {
        return Binary::exists(self::BINARY);
    }

    /** Get pdffonts version and copyright information */
    public static function version(): string
    {
        return Binary::version(self::BINARY);
    }

    /** Print pdffonts usage information */
    public static function help(): string
    {
        return Binary::help(self::BINARY);
    }

    /** Get command options and input as an array */
    public function toArray(): array
    {
        return array_merge(
            $this->command,
            [
                'input' => $this->pdf,
            ]
        );
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