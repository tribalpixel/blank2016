<?php if (is_active_sidebar('sidebar-primary')) : ?>
    <ul id="sidebar-primary">
        <?php dynamic_sidebar('sidebar-primary'); ?>
    </ul>
<?php endif; ?>

<?php if (is_active_sidebar('sidebar-secondary')) : ?>
    <ul id="sidebar-secondary">
        <?php dynamic_sidebar('sidebar-secondary'); ?>
    </ul>
<?php endif; ?>