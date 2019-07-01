<?php

include './components/File.php';
include './components/NumbersParser.php';

$params = [
    'f::' => 'file::',
];

$options  = \getopt(\implode('', \array_keys($params)), $params);
$filePath = $options['f'] ?? $options['file'] ?? null;

if (!$filePath) {
    $help = 'File is required. Use -f (--file) to provide it.';

    die($help);
}

$parser  = new NumbersParser();
$numbers = $parser->parse($filePath);

$result = [];
foreach ($numbers as $number => $matches) {
    $result[] = [
        'number' => $number,
        'matches' => $matches,
    ];
}

\usort($result, function (array $row1, array $row2) {
    return $row1['matches'] < $row2['matches'];
});

foreach ($result as $row) {
    echo "{$row['number']} - {$row['matches']}\n";
}
