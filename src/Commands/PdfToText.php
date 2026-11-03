<?php

namespace YakoLabs\PdfToText\Commands;

use YakoLabs\PdfToText\Exceptions\ExceptionHandler;
use YakoLabs\PdfToText\Support\Binary;
use Symfony\Component\Process\Process;

class PdfToText
{
    public const BINARY = Binary::PDFTOTEXT;

    public const HYPHENS_NONE = 'none';

    public const HYPHENS_SOFT = 'soft';

    public const HYPHENS_ALL = 'all';

    /** @var array<string, mixed> Command options */
    protected array $command = [
        '-f' => null,
        '-l' => null,
        '-r' => null,
        '-x' => null,
        '-y' => null,
        '-W' => null,
        '-H' => null,
        '-layout' => false,
        '-fixed' => null,
        '-raw' => false,
        '-remove-hyphens' => null,
        '-nodiag' => false,
        '-htmlmeta' => false,
        '-tsv' => false,
        '-enc' => null,
        '-eol' => null,
        '-nopgbrk' => false,
        '-bbox' => false,
        '-bbox-layout' => false,
        '-cropbox' => false,
        '-colspacing' => null,
        '-opw' => null,
        '-upw' => null,
        '-q' => false,
    ];

    /** @var string|null <text-file> output text file path */
    protected ?string $textFile = null;

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

    /** Set the output text file path */
    public function textFile(?string $textFile): self
    {
        $this->textFile = $textFile;

        return $this;
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

    /** Set -r <fp> resolution, in DPI (default is 72) */
    public function resolution(?float $dpi): self
    {
        $this->command['-r'] = $dpi;

        return $this;
    }

    /** Set -x <int> x-coordinate of the crop area top left corner */
    public function cropX(?int $x): self
    {
        $this->command['-x'] = $x;

        return $this;
    }

    /** Set -y <int> y-coordinate of the crop area top left corner */
    public function cropY(?int $y): self
    {
        $this->command['-y'] = $y;

        return $this;
    }

    /** Set -W <int> width of crop area in pixels (default is 0) */
    public function cropWidth(?int $width): self
    {
        $this->command['-W'] = $width;

        return $this;
    }

    /** Set -H <int> height of crop area in pixels (default is 0) */
    public function cropHeight(?int $height): self
    {
        $this->command['-H'] = $height;

        return $this;
    }

    /** Set -x, -y, -W, -H crop area values */
    public function cropArea(?int $x, ?int $y, ?int $width, ?int $height): self
    {
        return $this
            ->cropX($x)
            ->cropY($y)
            ->cropWidth($width)
            ->cropHeight($height);
    }

    /** Set -layout maintain original physical layout */
    public function layout(bool $layout = true): self
    {
        $this->command['-layout'] = $layout;

        return $this;
    }

    /** Set -fixed <fp> assume fixed-pitch (or tabular) text */
    public function fixedPitch(?float $pitch): self
    {
        $this->command['-fixed'] = $pitch;

        return $this;
    }

    /** Set -raw keep strings in content stream order */
    public function raw(bool $raw = true): self
    {
        $this->command['-raw'] = $raw;

        return $this;
    }

    /** Set -remove-hyphens <string> end-of-line hyphen handling: none, soft, or all (default: all) */
    public function removeHyphens(?string $mode = self::HYPHENS_ALL): self
    {
        $this->command['-remove-hyphens'] = $mode;

        return $this;
    }

    /** Set -nodiag discard diagonal text */
    public function noDiagonalText(bool $noDiagonalText = true): self
    {
        $this->command['-nodiag'] = $noDiagonalText;

        return $this;
    }

    /** Set -htmlmeta generate a simple HTML file, including the meta information */
    public function htmlMeta(bool $html = true): self
    {
        $this->command['-htmlmeta'] = $html;

        return $this;
    }

    /** Set -tsv generate a simple TSV file, including the meta information for bounding boxes */
    public function tsv(bool $tsv = true): self
    {
        $this->command['-tsv'] = $tsv;

        return $this;
    }

    /** Set -enc <string> output text encoding name */
    public function encoding(?string $encoding): self
    {
        $this->command['-enc'] = $encoding;

        return $this;
    }

    /** Set -eol <string> output end-of-line convention (unix, dos, or mac) */
    public function endOfLine(?string $eol): self
    {
        $this->command['-eol'] = $eol;

        return $this;
    }

    /** Set -nopgbrk don't insert page breaks between pages */
    public function noPageBreaks(bool $noBreaks = true): self
    {
        $this->command['-nopgbrk'] = $noBreaks;

        return $this;
    }

    /** Set -bbox output bounding box for each word and page size to html */
    public function boundingBox(bool $bbox = true): self
    {
        $this->command['-bbox'] = $bbox;

        return $this;
    }

    /** Set -bbox-layout like -bbox but with extra layout bounding box data */
    public function boundingBoxLayout(bool $bbox = true): self
    {
        $this->command['-bbox-layout'] = $bbox;

        return $this;
    }

    /** Set -cropbox use the crop box rather than media box */
    public function cropBox(bool $crop = true): self
    {
        $this->command['-cropbox'] = $crop;

        return $this;
    }

    /** Set -colspacing <fp> how much spacing we allow after a word before considering adjacent text to be a new column */
    public function columnSpacing(?float $spacing): self
    {
        $this->command['-colspacing'] = $spacing;

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

    /** Set -q don't print any messages or errors */
    public function quiet(bool $quiet = true): self
    {
        $this->command['-q'] = $quiet;

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

        if ($this->textFile !== null) {
            $command[] = $this->textFile;
        }

        return $command;
    }

    /** Save extracted text to the original PDF file name with .txt extension */
    public function save(): true
    {
        $this->textFile(null)->run();

        return true;
    }

    /** Save extracted text to a specific file path */
    public function saveAs(string $path): true
    {
        $this->textFile($path)->run();

        return true;
    }

    /** Extract text and return it as a string (outputs to stdout) */
    public function extract(): string
    {
        return $this->textFile('-')->run();
    }

    public function process(): Process
    {
        Binary::require(self::BINARY);

        return new Process($this->buildCommand());
    }

    /** Execute the pdftotext command and return the output */
    public function run(): string
    {
        $process = $this->process();

        $process->run();

        if ($process->isSuccessful()) {
            return $process->getOutput();
        }

        ExceptionHandler::fromProcess($process);
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

    public function toArray(): array
    {
        return array_merge(
            $this->command,
            [
                'input' => $this->pdf,
                'output' => $this->textFile,
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
