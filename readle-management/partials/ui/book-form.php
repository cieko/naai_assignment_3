<?php

$isEditing = $formData['book_id'] > 0;
$shouldOpenBookModal = $editingBook !== null || $errors !== [];
$bookCategories = get_book_categories();
?>
<div class="modal<?= $shouldOpenBookModal ? ' modal--open' : '' ?>" id="book-modal">
    <a class="modal__backdrop" href="<?= e(build_index_url($currentView)) ?>" aria-label="Close"></a>
    <div class="modal__dialog modal__dialog--large">
        <section class="modal__panel">
            <div class="modal__header">
                <div>
                    <p class="panel__eyebrow"><?= $isEditing ? 'Update Record' : 'Create Record' ?></p>
                    <h2 class="panel__title"><?= $isEditing ? 'Edit Book Details' : 'Add New Book' ?></h2>
                </div>
                <a class="modal__close" href="<?= e(build_index_url($currentView)) ?>">Close</a>
            </div>

            <p class="panel__text">
                <?= $isEditing ? 'Change the fields you need and upload a new image only if you want to replace the current one.' : 'Fill in the details below to save a new book record directly into the database.' ?>
            </p>

            <?php if ($errors !== []): ?>
                <div class="book-form__summary">
                    Please correct the highlighted fields and submit the form again.
                </div>
            <?php endif; ?>

            <form class="book-form" action="<?= e(build_index_url($currentView)) ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="form_action" value="<?= $isEditing ? 'update' : 'create' ?>">
                <input type="hidden" name="book_id" value="<?= $formData['book_id'] ?>">
                <input type="hidden" name="current_view" value="<?= e($currentView) ?>">

                <div class="book-form__grid">
                    <div class="book-form__field">
                        <label class="book-form__label" for="book_name">Book Name</label>
                        <input
                            class="book-form__input<?= isset($errors['book_name']) ? ' book-form__input--error' : '' ?>"
                            type="text"
                            id="book_name"
                            name="book_name"
                            value="<?= e($formData['book_name']) ?>"
                        >
                        <?php if (isset($errors['book_name'])): ?>
                            <p class="book-form__error"><?= e($errors['book_name']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="book-form__field">
                        <label class="book-form__label" for="author_name">Author Name</label>
                        <input
                            class="book-form__input<?= isset($errors['author_name']) ? ' book-form__input--error' : '' ?>"
                            type="text"
                            id="author_name"
                            name="author_name"
                            value="<?= e($formData['author_name']) ?>"
                        >
                        <?php if (isset($errors['author_name'])): ?>
                            <p class="book-form__error"><?= e($errors['author_name']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="book-form__field">
                        <label class="book-form__label" for="price">Price</label>
                        <input
                            class="book-form__input<?= isset($errors['price']) ? ' book-form__input--error' : '' ?>"
                            type="number"
                            id="price"
                            name="price"
                            step="0.01"
                            min="0"
                            value="<?= e($formData['price']) ?>"
                        >
                        <?php if (isset($errors['price'])): ?>
                            <p class="book-form__error"><?= e($errors['price']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="book-form__field">
                        <label class="book-form__label" for="category">Category</label>
                        <select
                            class="book-form__input<?= isset($errors['category']) ? ' book-form__input--error' : '' ?>"
                            id="category"
                            name="category"
                        >
                            <option value="">Select Category</option>
                            <?php foreach ($bookCategories as $categoryOption): ?>
                                <option
                                    value="<?= e($categoryOption) ?>"
                                    <?= $formData['category'] === $categoryOption ? 'selected' : '' ?>
                                >
                                    <?= e($categoryOption) ?>
                                </option>
                            <?php endforeach; ?>
                            <?php if ($formData['category'] !== '' && !in_array($formData['category'], $bookCategories, true)): ?>
                                <option value="<?= e($formData['category']) ?>" selected>
                                    <?= e($formData['category']) ?>
                                </option>
                            <?php endif; ?>
                        </select>
                        <?php if (isset($errors['category'])): ?>
                            <p class="book-form__error"><?= e($errors['category']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="book-form__field">
                        <label class="book-form__label" for="quantity">Quantity</label>
                        <input
                            class="book-form__input<?= isset($errors['quantity']) ? ' book-form__input--error' : '' ?>"
                            type="number"
                            id="quantity"
                            name="quantity"
                            min="0"
                            value="<?= e($formData['quantity']) ?>"
                        >
                        <?php if (isset($errors['quantity'])): ?>
                            <p class="book-form__error"><?= e($errors['quantity']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="book-form__field">
                        <label class="book-form__label" for="book_image">Book Image</label>
                        <input
                            class="book-form__input<?= isset($errors['book_image']) ? ' book-form__input--error' : '' ?>"
                            type="file"
                            id="book_image"
                            name="book_image"
                            accept=".jpg,.jpeg,.png,.webp,.gif"
                        >
                        <p class="book-form__hint">Accepted: JPG, PNG, WEBP, GIF. Max 5MB.</p>
                        <?php if (isset($errors['book_image'])): ?>
                            <p class="book-form__error"><?= e($errors['book_image']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="book-form__preview<?= $isEditing && $editingBook !== null ? '' : ' book-form__preview--hidden' ?>">
                    <p class="book-form__preview-label">Current Image</p>
                    <img
                        class="book-form__preview-image"
                        src="<?= $isEditing && $editingBook !== null ? e(get_book_image_url($editingBook['id'])) : '' ?>"
                        alt="<?= $isEditing && $editingBook !== null ? e($editingBook['book_name']) : '' ?>"
                    >
                </div>

                <div class="book-form__actions">
                    <button class="button button--primary" type="submit">
                        <?= $isEditing ? 'Update Book' : 'Add Book' ?>
                    </button>
                    <a class="button button--ghost" href="<?= e(build_index_url($currentView)) ?>">
                        <?= $isEditing ? 'Cancel Edit' : 'Clear Form' ?>
                    </a>
                </div>
            </form>
        </section>
    </div>
</div>
