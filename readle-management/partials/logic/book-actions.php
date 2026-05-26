<?php

function handle_book_request($connection)
{
    $currentView = get_requested_view($_GET['view'] ?? 'table');
    $flash = get_status_flash($_GET['status'] ?? null);
    $errors = [];
    $formData = get_default_book_form();
    $editingBook = null;
    $deletingBook = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currentView = get_requested_view($_POST['current_view'] ?? $currentView);
        $formAction = $_POST['form_action'] ?? 'create';

        if ($formAction === 'delete') {
            $bookId = $_POST['book_id'] ?? 0;

            if ($bookId > 0 && find_book_by_id($connection, $bookId) !== null) {
                delete_book($connection, $bookId);
                redirect_to_index($currentView, ['status' => 'deleted']);
            }

            redirect_to_index($currentView, ['status' => 'missing']);
        }

        $formData = normalize_book_form($_POST);
        $errors = validate_book_form($formData);

        $imageRequired = $formAction === 'create';
        $imageData = extract_uploaded_image($_FILES['book_image'] ?? null, $imageRequired, $errors);

        if ($formAction === 'update' && $formData['book_id'] <= 0) {
            $errors['book_id'] = 'Invalid book record selected for update.';
        }

        if ($formAction === 'update' && $formData['book_id'] > 0) {
            $editingBook = find_book_by_id($connection, $formData['book_id']);

            if ($editingBook === null) {
                $errors['book_id'] = 'The selected book record was not found.';
            }
        }

        if ($errors === []) {
            if ($formAction === 'update') {
                update_book($connection, $formData['book_id'], $formData, $imageData);
                redirect_to_index($currentView, ['status' => 'updated']);
            }

            insert_book($connection, $formData, $imageData ?? []);
            redirect_to_index($currentView, ['status' => 'created']);
        }
    }

    if ($editingBook === null) {
        $editId = $_GET['edit'] ?? 0;

        if ($editId > 0) {
            $editingBook = find_book_by_id($connection, $editId);

            if ($editingBook === null) {
                $flash = ['type' => 'error', 'message' => 'The selected book record was not found.'];
            }
        }
    }

    if ($editingBook !== null && $_SERVER['REQUEST_METHOD'] !== 'POST') {
        $formData = fill_form_from_book($editingBook);
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $editingBook === null) {
        $deleteId = $_GET['delete'] ?? 0;

        if ($deleteId > 0) {
            $deletingBook = find_book_by_id($connection, $deleteId);

            if ($deletingBook === null) {
                $flash = ['type' => 'error', 'message' => 'The selected book record was not found.'];
            }
        }
    }

    return [
        'currentView' => $currentView,
        'flash' => $flash,
        'errors' => $errors,
        'formData' => $formData,
        'editingBook' => $editingBook,
        'deletingBook' => $deletingBook,
    ];
}

function validate_book_form($formData)
{
    $errors = [];

    if ($formData['book_name'] === '') {
        $errors['book_name'] = 'Book name is required.';
    }

    if ($formData['author_name'] === '') {
        $errors['author_name'] = 'Author name is required.';
    }

    if ($formData['category'] === '') {
        $errors['category'] = 'Category is required.';
    }

    if ($formData['price'] === '') {
        $errors['price'] = 'Price is required.';
    } elseif (!is_numeric($formData['price']) || $formData['price'] < 0) {
        $errors['price'] = 'Price must be a valid positive number.';
    }

    if ($formData['quantity'] === '') {
        $errors['quantity'] = 'Quantity is required.';
    } elseif (filter_var($formData['quantity'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false) {
        $errors['quantity'] = 'Quantity must be a valid whole number.';
    }

    return $errors;
}

function extract_uploaded_image($uploadedFile, $imageRequired, &$errors)
{
    if ($uploadedFile === null || ($uploadedFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        if ($imageRequired) {
            $errors['book_image'] = 'Book image is required.';
        }

        return null;
    }

    if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
        $errors['book_image'] = 'Image upload failed. Please try again.';

        return null;
    }

    if (($uploadedFile['size'] ?? 0) > 5 * 1024 * 1024) {
        $errors['book_image'] = 'Image size must be 5MB or smaller.';

        return null;
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $uploadedFile['tmp_name']);
    finfo_close($finfo);
    $allowedMimeTypes = ['image/jpeg', 'image/png'];

    if (!in_array($mimeType, $allowedMimeTypes, true)) {
        $errors['book_image'] = 'Please upload a valid image file! (JPEG or PNG)';

        return null;
    }

    $content = file_get_contents($uploadedFile['tmp_name']);

    if ($content === false) {
        $errors['book_image'] = 'Image file could not be read.';

        return null;
    }

    return [
        'content' => $content,
        'name' => basename($uploadedFile['name']),
        'mime' => $mimeType,
    ];
}

function redirect_to_index($currentView, $params = [])
{
    header('Location: ' . build_index_url($currentView, $params));
    exit;
}
