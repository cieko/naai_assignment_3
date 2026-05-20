<?php

require __DIR__ . '/config/database.php';
require __DIR__ . '/partials/logic/book-repository.php';

$bookId = $_GET['id'] ?? 0;

if ($bookId <= 0) {
    http_response_code(404);
    exit('Image not found.');
}

try {
    $connection = get_database_connection();
    ensure_database_ready($connection);

    $image = fetch_book_image($connection, $bookId);

    if ($image === null) {
        http_response_code(404);
        exit('Image not found.');
    }

    $fileName = str_replace('"', '', $image['image_name']);

    header('Content-Type: ' . $image['image_mime']);
    header('Content-Length: ' . strlen($image['book_image']));
    header('Content-Disposition: inline; filename="' . $fileName . '"');

    echo $image['book_image'];
} catch (Throwable $exception) {
    http_response_code(500);
    exit('Unable to load image.');
}
