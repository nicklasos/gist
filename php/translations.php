<?php

function csv_to_array($filename)
{
    if (!file_exists($filename) || !is_readable($filename)) {
        throw new InvalidArgumentException('File does not exists or not readable');
    }

    $headers = null;
    $data = [];
    if (($handle = fopen($filename, 'r')) !== false) {
        while (($row = fgetcsv($handle)) !== false) {
            if (!$headers) {
                $headers = $row;
            } else {
                $data[] = $row;
            }
        }

        fclose($handle);
    }

    return [$headers, $data];
}

function to_header($header)
{
    $headers = [
        'English' => 'en',
        'Русский' => 'ru',
        'Ukrainian' => 'uk',
        'Spanish (LatAm)' => 'es',
        'Portuguese (Br)' => 'pt',
        'German' => 'de',
        'French' => 'fr',
        'Italian' => 'it',
        'Chinese' => 'zh',
        'Korean' => 'ko',
        'Japanese' => 'ja',
    ];

    return $headers[$header];
}

function convert($headers, $data)
{
    unset($headers[0], $headers[1]);

    $result = [];
    foreach ($headers as $index => $header) {
        foreach ($data as $translations) {
            if (isset($translations[1]) && $translations[1]) {
                if (!isset($translations[$index])) {
                    $translations[$index] = $translations[1];
                }

                $result[to_header($header)][$translations[1]] = $translations[$index];
            }
        }
    }

    return $result;
}

list($headers, $data) = csv_to_array(__DIR__ . '/translations.csv');
$result = convert($headers, $data);

file_put_contents('translations.json', json_encode($result));
