<section class="hero" id="home">
    <div class="hero__inner container">
        <div class="hero__content">
            <p class="hero__eyebrow">Online bookstore</p>
            <h1 class="hero__title">A clean digital shelf for readers, schools, and growing book collections.</h1>
            <p class="hero__text">
                Readle brings together featured titles, trusted authors, and curated collections in a warm online bookstore experience.
                Visitors can explore standout books, discover new categories, and connect with your team through a polished, professional storefront.
            </p>

            <div class="hero__actions">
                <a class="button button--accent" href="#books">Explore Books</a>
                <a class="button button--light" href="#about">Why Readle</a>
            </div>
        </div>

        <div class="hero__panel">
            <div class="hero__panel-card">
                <p class="hero__panel-label">Collection overview</p>
                <div class="hero__overview-grid">
                    <div class="hero__stat">
                        <span class="hero__stat-number"><?php echo escape($stats['total_books']); ?></span>
                        <span class="hero__stat-text">Titles listed</span>
                    </div>
                    <div class="hero__stat">
                        <span class="hero__stat-number"><?php echo escape($stats['total_stock']); ?></span>
                        <span class="hero__stat-text">Books in stock</span>
                    </div>
                    <div class="hero__stat">
                        <span class="hero__stat-number"><?php echo escape($stats['total_categories']); ?></span>
                        <span class="hero__stat-text">Categories</span>
                    </div>
                </div>

                <div class="hero__customer-card">
                    <span class="hero__customer-label">Total customers</span>
                    <strong class="hero__customer-value"><?php echo escape($brandStats['total_customers']); ?></strong>
                </div>
            </div>

            <div class="hero__tile-grid">
                <div class="hero__tile">
                    <span class="hero__tile-value"><?php echo escape($brandStats['total_buys']); ?></span>
                    <span class="hero__tile-label">Book purchases</span>
                </div>
                <div class="hero__tile">
                    <span class="hero__tile-value"><?php echo escape($brandStats['launch_year']); ?></span>
                    <span class="hero__tile-label">Launched in</span>
                </div>
            </div>
        </div>
    </div>
</section>
