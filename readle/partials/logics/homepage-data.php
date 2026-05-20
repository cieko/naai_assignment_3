<?php
declare(strict_types=1);

if (!function_exists('escape')) {
    function escape(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

$pageTitle = 'Readle | Company Homepage';
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'readle_management';

$books = [];
$stats = [
    'total_books' => 0,
    'total_stock' => 0,
    'total_categories' => 0,
];
$brandStats = [
    'total_customers' => '12,500+',
    'total_buys' => '28,000+',
    'launch_year' => '2026',
];
$dbError = '';

$connection = @new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($connection->connect_error) {
    $dbError = 'Our featured collection is unavailable right now. Please check back shortly.';
} else {
    $connection->set_charset('utf8mb4');

    $statsResult = $connection->query(
        'SELECT 
            COUNT(*) AS total_books,
            COALESCE(SUM(quantity), 0) AS total_stock,
            COUNT(DISTINCT category) AS total_categories
        FROM books'
    );

    if ($statsResult instanceof mysqli_result) {
        $statsRow = $statsResult->fetch_assoc();

        if ($statsRow) {
            $stats['total_books'] = (int) $statsRow['total_books'];
            $stats['total_stock'] = (int) $statsRow['total_stock'];
            $stats['total_categories'] = (int) $statsRow['total_categories'];
        }
    }

    $booksResult = $connection->query(
        'SELECT id, book_name, author_name, price, category, quantity, book_image, image_name, image_mime
        FROM books
        ORDER BY created_at DESC
        LIMIT 6'
    );

    if ($booksResult instanceof mysqli_result) {
        while ($book = $booksResult->fetch_assoc()) {
            $bookImageSource = '';

            if (!empty($book['book_image']) && !empty($book['image_mime'])) {
                $bookImageSource = 'data:' . $book['image_mime'] . ';base64,' . base64_encode($book['book_image']);
            }

            $books[] = [
                'id' => (int) $book['id'],
                'book_name' => $book['book_name'],
                'author_name' => $book['author_name'],
                'price' => (float) $book['price'],
                'category' => $book['category'],
                'quantity' => (int) $book['quantity'],
                'image_name' => $book['image_name'],
                'image_src' => $bookImageSource,
            ];
        }
    }

    $connection->close();
}
