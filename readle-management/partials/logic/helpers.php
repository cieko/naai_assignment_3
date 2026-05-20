<?php

function e($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function get_default_book_form()
{
    return [
        'book_id' => 0,
        'book_name' => '',
        'author_name' => '',
        'price' => '',
        'category' => '',
        'quantity' => '',
    ];
}

function get_book_categories()
{
    return [
        'Fiction',
        'Non-Fiction',
        'Science',
        'History',
        'Biography',
        'Technology',
        'Education',
        'Children',
        'Comics',
        'Mystery',
    ];
}

function normalize_book_form($source)
{
    return [
        'book_id' => $source['book_id'] ?? 0,
        'book_name' => trim($source['book_name'] ?? ''),
        'author_name' => trim($source['author_name'] ?? ''),
        'price' => trim($source['price'] ?? ''),
        'category' => trim($source['category'] ?? ''),
        'quantity' => trim($source['quantity'] ?? ''),
    ];
}

function fill_form_from_book($book)
{
    return [
        'book_id' => $book['id'],
        'book_name' => $book['book_name'],
        'author_name' => $book['author_name'],
        'price' => number_format($book['price'], 2, '.', ''),
        'category' => $book['category'],
        'quantity' => $book['quantity'],
    ];
}

function get_requested_view($view)
{
    return $view === 'card' ? 'card' : 'table';
}

function build_index_url($view, $params = [])
{
    $query = array_merge(['view' => get_requested_view($view)], $params);

    return 'index.php?' . http_build_query($query);
}

function get_status_flash($status)
{
    return match ($status) {
        'created' => ['type' => 'success', 'message' => 'Book record added successfully.'],
        'updated' => ['type' => 'success', 'message' => 'Book record updated successfully.'],
        'deleted' => ['type' => 'success', 'message' => 'Book record deleted successfully.'],
        'missing' => ['type' => 'error', 'message' => 'The selected book record was not found.'],
        default => null,
    };
}

function format_price($price)
{
    return number_format($price, 2);
}

function get_book_image_url($bookId)
{
    return 'book-image.php?id=' . $bookId;
}
