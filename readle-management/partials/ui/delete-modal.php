<?php

if ($deletingBook === null) {
    return;
}

$shouldOpenDeleteModal = $deletingBook !== null;
?>
<div class="modal<?= $shouldOpenDeleteModal ? ' modal--open' : '' ?>" id="delete-modal">
    <a class="modal__backdrop" href="<?= e(build_index_url($currentView)) ?>" aria-label="Close"></a>
    <div class="modal__dialog">
        <section class="modal__panel">
            <div class="modal__header">
                <div>
                    <p class="panel__eyebrow">Delete Record</p>
                    <h2 class="panel__title">Confirm Delete</h2>
                </div>
                <a class="modal__close" href="<?= e(build_index_url($currentView)) ?>">Close</a>
            </div>

            <p class="panel__text">
                Are you sure you want to delete <strong><?= e($deletingBook['book_name']) ?></strong>
                by <?= e($deletingBook['author_name']) ?>?
            </p>

            <form class="book-form__actions" action="<?= e(build_index_url($currentView)) ?>" method="post">
                <input type="hidden" name="form_action" value="delete">
                <input type="hidden" name="book_id" value="<?= $deletingBook['id'] ?>">
                <input type="hidden" name="current_view" value="<?= e($currentView) ?>">
                <button class="button button--danger" type="submit">Yes, Delete</button>
                <a class="button button--ghost" href="<?= e(build_index_url($currentView)) ?>">Cancel</a>
            </form>
        </section>
    </div>
</div>
