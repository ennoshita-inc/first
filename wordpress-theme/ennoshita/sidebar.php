<?php
/**
 * サイドバーテンプレート
 */
if (!is_active_sidebar('sidebar-blog')) return;
?>

<aside class="sidebar" role="complementary" aria-label="サイドバー">
  <?php dynamic_sidebar('sidebar-blog'); ?>
</aside>
