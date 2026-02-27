<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

function get_db_dsn(): string
{
    $host = DB_HOST;
    $name = DB_NAME;
    $charset = DB_CHARSET;

    return "mysql:host={$host};dbname={$name};charset={$charset}";
}

function get_db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $pdo = new PDO(
        get_db_dsn(),
        DB_USER,
        DB_PASSWORD,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    return $pdo;
}

