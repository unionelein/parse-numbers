<?php declare(strict_types=1);

function generateRandomString(int $length = 5000): string
{
    $chars       = '0123456789абвгдеёАБВГДabcdeABCDE|(;"';
    $charsLength = strlen($chars);

    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $chars[\random_int(0, $charsLength - 1)];
    }

    return $randomString;
}

$filename = __DIR__ . '/random_text.txt';

if (\is_file($filename)) {
    \unlink($filename);
}

for ($i = 0; $i < 5; $i++) {
    $text = generateRandomString() . "\n";

    file_put_contents($filename, $text, FILE_APPEND);
}

echo 'ok';

