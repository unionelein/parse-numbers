<?php declare(strict_types=1);

class File
{
    /** @var string */
    private $path;

    /** @var resource */
    private $file;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function open(): void
    {
        if ($this->file) {
            return; // already opened
        }

        if (!\is_file($this->path)) {
            throw new \InvalidArgumentException("File '{$this->path}' not found");
        }

        $this->file = \fopen($this->path, 'rb'); // respublika belarus

        if (!$this->file) {
            throw new \InvalidArgumentException("Unable to open file at path {$this->path}");
        }
    }

    public function close(): void
    {
        if ($this->file) {
            \fclose($this->file);

            $this->file = null;
        }
    }

    /**
     * @param null|int $length
     *
     * @return null|string
     */
    public function read(int $length = null): ?string
    {
        $buffer = null !== $length
            ? \fgets($this->file, $length + 1) // fgets reads length - 1, so we fix it
            : \fgets($this->file);

        if ($buffer) {
            return $buffer;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isEnd(): bool
    {
        return \feof($this->file);
    }
}
