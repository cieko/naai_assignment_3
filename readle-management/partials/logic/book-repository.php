<?php

function fetch_all_books($connection)
{
    $sql = 'SELECT id, book_name, author_name, price, category, quantity, image_name, image_mime, 1 AS has_image, created_at, updated_at FROM books ORDER BY id DESC';
    $result = mysqli_query($connection, $sql);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function find_book_by_id($connection, $bookId)
{
    $bookId = mysqli_real_escape_string($connection, $bookId);
    $sql = "SELECT id, book_name, author_name, price, category, quantity, image_name, image_mime, 1 AS has_image, created_at, updated_at FROM books WHERE id = '{$bookId}' LIMIT 1";
    $result = mysqli_query($connection, $sql);
    $book = mysqli_fetch_assoc($result);

    return $book ?: null;
}

function fetch_book_image($connection, $bookId)
{
    $bookId = mysqli_real_escape_string($connection, $bookId);
    $sql = "SELECT image_name, image_mime, book_image FROM books WHERE id = '{$bookId}' LIMIT 1";
    $result = mysqli_query($connection, $sql);
    $image = mysqli_fetch_assoc($result);

    return $image ?: null;
}

function insert_book($connection, $bookData, $imageData)
{
    $bookName = mysqli_real_escape_string($connection, $bookData['book_name']);
    $authorName = mysqli_real_escape_string($connection, $bookData['author_name']);
    $price = mysqli_real_escape_string($connection, $bookData['price']);
    $category = mysqli_real_escape_string($connection, $bookData['category']);
    $quantity = mysqli_real_escape_string($connection, $bookData['quantity']);
    $imageBlob = mysqli_real_escape_string($connection, $imageData['content']);
    $imageName = mysqli_real_escape_string($connection, $imageData['name']);
    $imageMime = mysqli_real_escape_string($connection, $imageData['mime']);
    $sql = "INSERT INTO books (book_name, author_name, price, category, quantity, book_image, image_name, image_mime) VALUES ('{$bookName}', '{$authorName}', '{$price}', '{$category}', '{$quantity}', '{$imageBlob}', '{$imageName}', '{$imageMime}')";
    mysqli_query($connection, $sql);

    return mysqli_insert_id($connection);
}

function update_book($connection, $bookId, $bookData, $imageData = null)
{
    $bookId = mysqli_real_escape_string($connection, $bookId);
    $bookName = mysqli_real_escape_string($connection, $bookData['book_name']);
    $authorName = mysqli_real_escape_string($connection, $bookData['author_name']);
    $price = mysqli_real_escape_string($connection, $bookData['price']);
    $category = mysqli_real_escape_string($connection, $bookData['category']);
    $quantity = mysqli_real_escape_string($connection, $bookData['quantity']);

    if ($imageData !== null) {
        $imageBlob = mysqli_real_escape_string($connection, $imageData['content']);
        $imageName = mysqli_real_escape_string($connection, $imageData['name']);
        $imageMime = mysqli_real_escape_string($connection, $imageData['mime']);
        $sql = "UPDATE books SET book_name = '{$bookName}', author_name = '{$authorName}', price = '{$price}', category = '{$category}', quantity = '{$quantity}', book_image = '{$imageBlob}', image_name = '{$imageName}', image_mime = '{$imageMime}' WHERE id = '{$bookId}'";
        mysqli_query($connection, $sql);

        return;
    }

    $sql = "UPDATE books SET book_name = '{$bookName}', author_name = '{$authorName}', price = '{$price}', category = '{$category}', quantity = '{$quantity}' WHERE id = '{$bookId}'";
    mysqli_query($connection, $sql);
}

function delete_book($connection, $bookId)
{
    $bookId = mysqli_real_escape_string($connection, $bookId);
    $sql = "DELETE FROM books WHERE id = '{$bookId}'";
    mysqli_query($connection, $sql);
}
