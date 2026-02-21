<?php
/**
 * アーカイブ (カテゴリ / タグ / 日付) テンプレート
 */
get_header();
?>

  <div class="archive-header">
    <div class="container">
      <h1 class="archive-header__title"><?php the_archive_title(); ?></h1>
      <?php if (get_the_archive_description()) : ?>
        <p class="archive-header__description"><?php echo wp_strip_all_tags(get_the_archive_description()); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <div class="archive-content">
    <div class="container">
      <?php if (have_posts()) : ?>
        <div class="blog__grid">
          <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-parts/content', 'card'); ?>
          <?php endwhile; ?>
        </div>

        <div class="pagination">
          <?php
          the_posts_pagination([
            'mid_size'  => 2,
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
          ]);
          ?>
        </div>
      <?php else : ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
      <?php endif; ?>
    </div>
  </div>

<?php get_footer(); ?>
