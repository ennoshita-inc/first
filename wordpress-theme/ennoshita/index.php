<?php
/**
 * ブログ一覧テンプレート (index.php)
 * コラム一覧ページ — ダークヘッダー + カテゴリフィルタ + CTA
 */
get_header();
?>

  <!-- ページヘッダー（他ページと統一されたダークグラデーション） -->
  <div class="page-header">
    <div class="container">
      <p class="page-header__label">Column</p>
      <h1 class="page-header__title">コラム</h1>
      <p class="page-header__subtitle">人材育成・組織開発に関する知見をお届けします。</p>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <!-- カテゴリフィルタ -->
  <?php
  $categories = get_categories(['hide_empty' => true]);
  if ($categories) :
  ?>
  <div class="blog-filter">
    <div class="container">
      <ul class="blog-filter__list">
        <li>
          <a href="<?php echo esc_url(ennoshita_get_blog_url()); ?>"
             class="blog-filter__item blog-filter__item--active">すべて</a>
        </li>
        <?php foreach ($categories as $cat) : ?>
          <li>
            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
               class="blog-filter__item"><?php echo esc_html($cat->name); ?>
              <span class="blog-filter__count"><?php echo esc_html($cat->count); ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <?php endif; ?>

  <!-- 記事一覧 -->
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

  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php get_footer(); ?>
