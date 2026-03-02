<?php
/**
 * アーカイブ (カテゴリ / タグ / 日付) テンプレート
 * ダークヘッダー + カテゴリフィルタ + CTA
 */
get_header();
?>

  <!-- ページヘッダー（ダークグラデーション） -->
  <div class="page-header">
    <div class="container">
      <p class="page-header__label">Column</p>
      <h1 class="page-header__title"><?php the_archive_title(); ?></h1>
      <?php if (get_the_archive_description()) : ?>
        <p class="page-header__subtitle"><?php echo wp_strip_all_tags(get_the_archive_description()); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <!-- カテゴリフィルタ -->
  <?php
  $categories = get_categories(['hide_empty' => true]);
  if ($categories) :
    $current_cat_id = is_category() ? get_queried_object_id() : 0;
  ?>
  <div class="blog-filter">
    <div class="container">
      <ul class="blog-filter__list">
        <li>
          <a href="<?php echo esc_url(ennoshita_get_blog_url()); ?>"
             class="blog-filter__item<?php echo !$current_cat_id ? ' blog-filter__item--active' : ''; ?>">すべて</a>
        </li>
        <?php foreach ($categories as $cat) : ?>
          <li>
            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
               class="blog-filter__item<?php echo ($current_cat_id === $cat->term_id) ? ' blog-filter__item--active' : ''; ?>"><?php echo esc_html($cat->name); ?>
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
