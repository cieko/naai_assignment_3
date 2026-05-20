<?php

require __DIR__ . '/config/database.php';
require __DIR__ . '/partials/logic/helpers.php';
require __DIR__ . '/partials/logic/book-repository.php';
require __DIR__ . '/partials/logic/book-actions.php';

$books = [];
$currentView = 'table';
$flash = null;
$errors = [];
$formData = get_default_book_form();
$editingBook = null;
$deletingBook = null;
$pageError = null;

try {
    $connection = get_database_connection();
    ensure_database_ready($connection);

    $requestState = handle_book_request($connection);

    $books = fetch_all_books($connection);
    $currentView = $requestState['currentView'];
    $flash = $requestState['flash'];
    $errors = $requestState['errors'];
    $formData = $requestState['formData'];
    $editingBook = $requestState['editingBook'];
    $deletingBook = $requestState['deletingBook'];
} catch (Throwable $exception) {
    $pageError = 'Database connection failed....';
}

require __DIR__ . '/partials/ui/header.php';

if ($pageError !== null) {
    $flash = ['type' => 'error', 'message' => $pageError];
}

require __DIR__ . '/partials/ui/flash-message.php';
?>
<?php if ($pageError === null): ?>
    <?php require __DIR__ . '/partials/ui/book-toolbar.php'; ?>
    <?php require __DIR__ . '/partials/ui/delete-modal.php'; ?>

    <?php
    if ($currentView === 'card') {
        require __DIR__ . '/partials/ui/books-cards.php';
    } else {
        require __DIR__ . '/partials/ui/books-table.php';
    }
    ?>

    <?php require __DIR__ . '/partials/ui/book-form.php'; ?>
<?php endif; ?>
<?php
require __DIR__ . '/partials/ui/footer.php';
