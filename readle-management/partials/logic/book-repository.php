<?php

function fetch_all_books($connection)
{
    $result = $connection->query(
        <<<SQL
        SELECT
            id,
            book_name,
            author_name,
            price,
            category,
            quantity,
            image_name,
            image_mime,
            1 AS has_image,
            created_at,
            updated_at
        FROM books
        ORDER BY id DESC
        SQL
    );

    return $result->fetch_all(MYSQLI_ASSOC);
}

function find_book_by_id($connection, $bookId)
{
    $statement = $connection->prepare(
        <<<SQL
        SELECT
            id,
            book_name,
            author_name,
            price,
            category,
            quantity,
            image_name,
            image_mime,
            1 AS has_image,
            created_at,
            updated_at
        FROM books
        WHERE id = ?
        LIMIT 1
        SQL
    );
    $statement->bind_param('i', $bookId);
    $statement->execute();

    $result = $statement->get_result();
    $book = $result->fetch_assoc();

    return $book ?: null;
}

function fetch_book_image($connection, $bookId)
{
    $statement = $connection->prepare(
        'SELECT image_name, image_mime, book_image FROM books WHERE id = ? LIMIT 1'
    );
    $statement->bind_param('i', $bookId);
    $statement->execute();

    $result = $statement->get_result();
    $image = $result->fetch_assoc();

    return $image ?: null;
}

function insert_book($connection, $bookData, $imageData)
{
    $statement = $connection->prepare(
        <<<SQL
        INSERT INTO books (
            book_name,
            author_name,
            price,
            category,
            quantity,
            book_image,
            image_name,
            image_mime
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        SQL
    );

    $bookName = $bookData['book_name'];
    $authorName = $bookData['author_name'];
    $price = $bookData['price'];
    $category = $bookData['category'];
    $quantity = $bookData['quantity'];
    $imageBlob = null;
    $imageName = $imageData['name'];
    $imageMime = $imageData['mime'];

    $statement->bind_param(
        'ssdsibss',
        $bookName,
        $authorName,
        $price,
        $category,
        $quantity,
        $imageBlob,
        $imageName,
        $imageMime
    );
    $statement->send_long_data(5, $imageData['content']);
    $statement->execute();

    return $statement->insert_id;
}

function update_book($connection, $bookId, $bookData, $imageData = null)
{
    if ($imageData !== null) {
        $statement = $connection->prepare(
            <<<SQL
            UPDATE books
            SET
                book_name = ?,
                author_name = ?,
                price = ?,
                category = ?,
                quantity = ?,
                book_image = ?,
                image_name = ?,
                image_mime = ?
            WHERE id = ?
            SQL
        );

        $bookName = $bookData['book_name'];
        $authorName = $bookData['author_name'];
        $price = $bookData['price'];
        $category = $bookData['category'];
        $quantity = $bookData['quantity'];
        $imageBlob = null;
        $imageName = $imageData['name'];
        $imageMime = $imageData['mime'];

        $statement->bind_param(
            'ssdsibssi',
            $bookName,
            $authorName,
            $price,
            $category,
            $quantity,
            $imageBlob,
            $imageName,
            $imageMime,
            $bookId
        );
        $statement->send_long_data(5, $imageData['content']);
        $statement->execute();

        return;
    }

    $statement = $connection->prepare(
        <<<SQL
        UPDATE books
        SET
            book_name = ?,
            author_name = ?,
            price = ?,
            category = ?,
            quantity = ?
        WHERE id = ?
        SQL
    );

    $bookName = $bookData['book_name'];
    $authorName = $bookData['author_name'];
    $price = $bookData['price'];
    $category = $bookData['category'];
    $quantity = $bookData['quantity'];

    $statement->bind_param(
        'ssdsii',
        $bookName,
        $authorName,
        $price,
        $category,
        $quantity,
        $bookId
    );
    $statement->execute();
}

function delete_book($connection, $bookId)
{
    $statement = $connection->prepare('DELETE FROM books WHERE id = ?');
    $statement->bind_param('i', $bookId);
    $statement->execute();
}
