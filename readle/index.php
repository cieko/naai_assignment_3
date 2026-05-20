<?php
declare(strict_types=1);

require_once __DIR__ . '/partials/logics/homepage-data.php';

$uiPath = __DIR__ . '/partials/ui';
?>
<!DOCTYPE html>
<html lang="en">
<?php require $uiPath . '/document-head.php'; ?>
<body class="page">
    <?php require $uiPath . '/site-header.php'; ?>

    <main>
        <?php require $uiPath . '/hero-section.php'; ?>
        <?php require $uiPath . '/books-section.php'; ?>
        <?php require $uiPath . '/services-section.php'; ?>
        <?php require $uiPath . '/about-section.php'; ?>
        <?php require $uiPath . '/contact-section.php'; ?>
    </main>

    <?php require $uiPath . '/site-footer.php'; ?>
</body>
</html>
