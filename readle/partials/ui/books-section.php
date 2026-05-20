<section class="books section" id="books">
    <div class="container">
        <div class="section-heading">
            <p class="section-heading__eyebrow">Featured collection</p>
            <h2 class="section-heading__title">Featured books from Readle</h2>
            <p class="section-heading__text">
                Browse a handpicked selection of titles available at Readle, from reader favorites to everyday essentials.
            </p>
        </div>

        <?php if ($dbError !== '') : ?>
            <div class="status-message status-message--error"><?php echo escape($dbError); ?></div>
        <?php elseif ($books === []) : ?>
            <div class="status-message status-message--empty">Our shelves are being refreshed. Featured books will appear here soon.</div>
        <?php else : ?>
            <div class="books__grid">
                <?php foreach ($books as $book) : ?>
                    <article class="book-card">
                        <div class="book-card__media">
                            <?php if ($book['image_src'] !== '') : ?>
                                <img
                                    class="book-card__image"
                                    src="<?php echo escape($book['image_src']); ?>"
                                    alt="<?php echo escape($book['book_name']); ?>"
                                    loading="lazy"
                                >
                            <?php else : ?>
                                <div class="book-card__image book-card__image--placeholder">
                                    <span>Readle Pick</span>
                                </div>
                            <?php endif; ?>
                            <span class="book-card__badge"><?php echo escape($book['category']); ?></span>
                        </div>

                        <div class="book-card__content">
                            <h3 class="book-card__title"><?php echo escape($book['book_name']); ?></h3>
                            <p class="book-card__author">By <?php echo escape($book['author_name']); ?></p>

                            <div class="book-card__meta">
                                <span class="book-card__price">Rs. <?php echo escape(number_format($book['price'], 2)); ?></span>
                                <span class="book-card__stock"><?php echo escape($book['quantity']); ?> in stock</span>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
