<section class="about section" id="about">
    <div class="container about__grid">
        <div class="about__content">
            <div class="section-heading section-heading--left">
                <p class="section-heading__eyebrow">About Readle</p>
                <h2 class="section-heading__title">Simple presentation for a growing reading brand.</h2>
                <p class="section-heading__text">
                    Readle is a modern online bookstore created for readers who value thoughtful selection, clear presentation, and a smooth browsing experience.
                    From bestselling fiction to academic essentials, the collection is arranged to help visitors discover titles that match their interests.
                </p>
                <p class="section-heading__text">
                    Whether someone is searching for everyday reading, gift ideas, or classroom resources, Readle presents each title with care and clarity.
                    The result is a welcoming storefront that feels professional, trustworthy, and easy to explore.
                </p>
            </div>

            <div class="about__points">
                <div class="about__point">
                    <h3 class="about__point-title">Curated experience</h3>
                    <p class="about__point-text">Each section is organized to guide visitors from discovery to enquiry with a clear and comfortable shopping journey.</p>
                </div>
                <div class="about__point">
                    <h3 class="about__point-title">Trusted selection</h3>
                    <p class="about__point-text">Featured books, pricing, and availability are presented clearly so readers can browse with confidence.</p>
                </div>
            </div>
        </div>

        <div class="about__panel">
            <div class="about__card">
                <h3 class="about__card-title">Readle at a glance</h3>
                <div class="about__bento">
                    <div class="about__stat-item">
                        <span class="about__stat-value"><?php echo escape($stats['total_books']); ?></span>
                        <span class="about__stat-label">Books listed</span>
                    </div>
                    <div class="about__stat-item">
                        <span class="about__stat-value"><?php echo escape($stats['total_categories']); ?></span>
                        <span class="about__stat-label">Active categories</span>
                    </div>
                    <div class="about__stat-item">
                        <span class="about__stat-value"><?php echo escape($stats['total_stock']); ?></span>
                        <span class="about__stat-label">Books in stock</span>
                    </div>
                    <div class="about__stat-item about__stat-item--wide">
                        <span class="about__stat-label about__stat-label--wide">Growing reader community</span>
                        <span class="about__stat-value about__stat-value--wide"><?php echo escape($brandStats['total_customers']); ?></span>
                    </div>
                </div>
            </div>

            <div class="about__tile-grid">
                <div class="about__tile">
                    <span class="about__tile-value"><?php echo escape($brandStats['total_buys']); ?></span>
                    <span class="about__tile-label">Book purchases</span>
                </div>
                <div class="about__tile">
                    <span class="about__tile-value"><?php echo escape($brandStats['launch_year']); ?></span>
                    <span class="about__tile-label">Launched in</span>
                </div>
            </div>
        </div>
    </div>
</section>
