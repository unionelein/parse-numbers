<?php declare(strict_types=1);

class NumbersParser
{
    /**
     * @param string $path
     *
     * @return array [[number => matches], [number => matches]]
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function parse(string $path): array
    {
        $file = new File($path);
        $file->open();

        $numbers = $this->parseNumbers($file);

        if (!$file->isEnd()) {
            $file->close();
            throw new \RuntimeException('Error while reading a file');
        }

        $file->close();

        return $numbers;
    }

    /**
     * @param File $file
     *
     * @return array
     */
    private function parseNumbers(File $file): array
    {
        $numbers = [];
        while ($buffer = $file->read(4096)) {
            $lastChar = \mb_substr($buffer, -1);

            if (\is_numeric($lastChar)) {
                $buffer .= $this->readByeNumbers($file); // to prevent splitting number
            }

            \preg_match_all('/\d+/', $buffer, $matches);

            foreach ($matches[0] as $number) {
                $numbers[$number] = $numbers[$number] ?? 0;
                $numbers[$number]++;
            }
        }

        return $numbers;
    }

    /**
     * @param File $file
     *
     * @return string
     */
    private function readByeNumbers(File $file): string
    {
        $buffer = '';
        while ($char = $file->read(1)) {
            if (!\is_numeric($char)) {
                break;
            }

            $buffer .= $char;
        }

        return $buffer;
    }
}
