<?php
?>
<section class="panel">
    <?php if ($books === []): ?>
        <div class="empty-state">
            <h3 class="empty-state__title">No books available</h3>
            <p class="empty-state__text">Use the Add New Book button to create your first record.</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="book-table">
                <thead class="book-table__head">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Book Name</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr class="book-table__row">
                            <td>#<?= $book['id'] ?></td>
                            <td>
                                <img
                                    class="book-table__image"
                                    src="<?= e(get_book_image_url($book['id'])) ?>"
                                    alt="<?= e($book['book_name']) ?>"
                                >
                            </td>
                            <td><?= e($book['book_name']) ?></td>
                            <td><?= e($book['author_name']) ?></td>
                            <td><?= e($book['category']) ?></td>
                            <td>Rs. <?= e(format_price($book['price'])) ?></td>
                            <td><?= $book['quantity'] ?></td>
                            <td>
                                <div class="book-table__actions">
                                    <a
                                        class="button button--secondary"
                                        href="<?= e(build_index_url($currentView, ['edit' => $book['id']])) ?>#book-modal"
                                    >
                                        Edit
                                    </a>
                                    <a
                                        class="button button--danger"
                                        href="<?= e(build_index_url($currentView, ['delete' => $book['id']])) ?>#delete-modal"
                                    >
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
