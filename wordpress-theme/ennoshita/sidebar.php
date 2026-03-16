<?php
/**
 * サイドバーテンプレート
 */
?>

<aside class="sidebar" role="complementary" aria-label="サイドバー">
  <?php if (is_active_sidebar('sidebar-blog')) : ?>
    <?php dynamic_sidebar('sidebar-blog'); ?>
  <?php endif; ?>

  <?php get_template_part('template-parts/section', 'newsletter'); ?>
</aside>
