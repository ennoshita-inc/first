<?php
/**
 * 検索結果テンプレート
 */
get_header();
?>

  <div class="archive-header">
    <div class="container">
      <h1 class="archive-header__title">
        「<?php echo esc_html(get_search_query()); ?>」の検索結果
      </h1>
      <p class="archive-header__description">
        <?php
        global $wp_query;
        printf('%d件の記事が見つかりました', $wp_query->found_posts);
        ?>
      </p>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <div class="archive-content">
    <div class="container">
      <div style="margin-bottom: var(--space-2xl);">
        <?php get_search_form(); ?>
      </div>

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
