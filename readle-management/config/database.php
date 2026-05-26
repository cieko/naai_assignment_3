<?php

const DB_HOST = '127.0.0.1';
const DB_PORT = 3306;
const DB_NAME = 'readle_management';
const DB_USER = 'root';
const DB_PASSWORD = '';

function get_database_connection()
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $host = getenv('DB_HOST') ?: DB_HOST;
    $port = getenv('DB_PORT') ?: DB_PORT;
    $user = getenv('DB_USER') ?: DB_USER;
    $password = getenv('DB_PASSWORD');
    $password = $password === false ? DB_PASSWORD : $password;

    $connection = mysqli_connect($host, $user, $password, '', $port);
    mysqli_set_charset($connection, 'utf8mb4');

    return $connection;
}

function ensure_database_ready($connection)
{
    $databaseName = getenv('DB_NAME') ?: DB_NAME;
    $safeDatabaseName = preg_replace('/[^a-zA-Z0-9_]/', '', $databaseName);

    if ($safeDatabaseName === null || $safeDatabaseName === '') {
        throw new RuntimeException('Database name is not valid.');
    }

    $createDatabaseSql = "CREATE DATABASE IF NOT EXISTS `{$safeDatabaseName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $createTableSql = 'CREATE TABLE IF NOT EXISTS books (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, book_name VARCHAR(180) NOT NULL, author_name VARCHAR(180) NOT NULL, price DECIMAL(10, 2) NOT NULL, category VARCHAR(120) NOT NULL, quantity INT UNSIGNED NOT NULL, book_image LONGBLOB NOT NULL, image_name VARCHAR(255) NOT NULL, image_mime VARCHAR(100) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';

    mysqli_query($connection, $createDatabaseSql);
    mysqli_select_db($connection, $safeDatabaseName);
    mysqli_query($connection, $createTableSql);
}
