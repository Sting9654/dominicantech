<?php
function loadEnvFile($path)
{
    if (!file_exists($path)) {
        throw new Exception("El archivo no existe.");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        $_ENV[$key] = $value;
    }

    return $_ENV;
}

//Manage DB Necessary Values
function getDbParams(): array
{
    $global = loadEnvFile('config.env');
    $params = [
        'DB_HOST' => $global['DB_HOST'],
        'DB_USERNAME' => $global['DB_USERNAME'],
        'DB_PASSWORD' => $global['DB_PASSWORD'],
        'DB_NAME' => $global['DB_NAME']
    ];
    return $params;
}
