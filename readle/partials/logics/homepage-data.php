<?php
declare(strict_types=1);

if (!function_exists('escape')) {
    function escape($value)
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

$conn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
} else {
    mysqli_set_charset($conn, 'utf8mb4');

    $statsResult = mysqli_query(
        $conn,
        'SELECT 
            COUNT(*) AS total_books,
            COALESCE(SUM(quantity), 0) AS total_stock,
            COUNT(DISTINCT category) AS total_categories
        FROM books'
    );

    if ($statsResult instanceof mysqli_result) {
        $statsRow = mysqli_fetch_assoc($statsResult);

        if ($statsRow) {
            $stats['total_books'] = $statsRow['total_books'];
            $stats['total_stock'] = $statsRow['total_stock'];
            $stats['total_categories'] = $statsRow['total_categories'];
        }
    }

    $booksResult = mysqli_query(
        $conn,
        'SELECT id, book_name, author_name, price, category, quantity, book_image, image_name, image_mime
        FROM books
        ORDER BY created_at DESC
        LIMIT 6'
    );

    if ($booksResult instanceof mysqli_result) {
        while ($book = mysqli_fetch_assoc($booksResult)) {
            $bookImageSource = '';

            if (!empty($book['book_image']) && !empty($book['image_mime'])) {
                $bookImageSource = 'data:' . $book['image_mime'] . ';base64,' . base64_encode($book['book_image']);
            }

            $books[] = [
                'id' => $book['id'],
                'book_name' => $book['book_name'],
                'author_name' => $book['author_name'],
                'price' => $book['price'],
                'category' => $book['category'],
                'quantity' => $book['quantity'],
                'image_name' => $book['image_name'],
                'image_src' => $bookImageSource,
            ];
        }
    }

    mysqli_close($conn);
}
