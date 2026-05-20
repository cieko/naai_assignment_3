<?php

if ($flash !== null && $flash['type'] === 'success'):
?>
    <div class="toast toast--success">
        <p class="toast__text"><?= e($flash['message']) ?></p>
    </div>
<?php elseif ($flash !== null): ?>
    <div class="notice notice--error">
        <p class="notice__text"><?= e($flash['message']) ?></p>
    </div>
<?php endif; ?>
