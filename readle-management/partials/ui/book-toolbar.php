<?php

$bookCount = count($books);
?>
<section class="panel panel--compact">
    <div class="toolbar">
        <div class="toolbar__meta">
            <p class="panel__eyebrow">Book Records</p>
            <h2 class="panel__title">Available Books</h2>
            <p class="panel__text">
                <?= $bookCount ?> <?= $bookCount === 1 ? 'book' : 'books' ?> found in the database.
            </p>
        </div>

        <div class="toolbar__actions">
            <a class="button button--primary" href="<?= e(build_index_url($currentView)) ?>#book-modal">
                Add New Book
            </a>

            <?php if ($editingBook !== null): ?>
                <a class="button button--ghost" href="<?= e(build_index_url($currentView)) ?>">
                    Cancel Edit
                </a>
            <?php endif; ?>

            <div class="toolbar__switches">
                <a
                    class="toolbar__link<?= $currentView === 'table' ? ' toolbar__link--active' : '' ?>"
                    href="<?= e(build_index_url('table')) ?>"
                >
                    Table View
                </a>
                <a
                    class="toolbar__link<?= $currentView === 'card' ? ' toolbar__link--active' : '' ?>"
                    href="<?= e(build_index_url('card')) ?>"
                >
                    Card View
                </a>
            </div>
        </div>
    </div>
</section>
