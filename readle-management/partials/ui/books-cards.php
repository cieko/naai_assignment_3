<?php
?>
<section class="panel">
    <?php if ($books === []): ?>
        <div class="empty-state">
            <h3 class="empty-state__title">No books available</h3>
            <p class="empty-state__text">Use the Add New Book button to create your first record.</p>
        </div>
    <?php else: ?>
        <div class="book-card-grid">
            <?php foreach ($books as $book): ?>
                <article class="book-card">
                    <img
                        class="book-card__image"
                        src="<?= e(get_book_image_url($book['id'])) ?>"
                        alt="<?= e($book['book_name']) ?>"
                    >

                    <div class="book-card__content">
                        <p class="book-card__category"><?= e($book['category']) ?></p>
                        <h3 class="book-card__title"><?= e($book['book_name']) ?></h3>
                        <p class="book-card__author">by <?= e($book['author_name']) ?></p>

                        <div class="book-card__stats">
                            <p class="book-card__price">Rs. <?= e(format_price($book['price'])) ?></p>
                            <p class="book-card__quantity">Qty: <?= $book['quantity'] ?></p>
                        </div>

                        <div class="book-card__actions">
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
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
