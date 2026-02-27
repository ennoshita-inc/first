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

  <!-- CTA -->
  <section class="cta">
    <div class="container cta__inner">
      <h2 class="cta__title"><?php echo esc_html(get_theme_mod('ennoshita_cta_title', '組織の課題、一緒に解決しませんか？')); ?></h2>
      <p class="cta__text"><?php echo esc_html(get_theme_mod('ennoshita_cta_text', 'まずはお気軽にご相談ください。貴社の状況をお伺いし、最適なアプローチをご提案します。')); ?></p>
      <div class="cta__buttons">
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--white btn--large">
          無料相談のお申し込み
          <svg class="btn__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
        <a href="<?php echo esc_url(home_url('/#services')); ?>" class="btn btn--outline-white btn--large">
          サービス一覧を見る
        </a>
      </div>
    </div>
  </section>

<?php get_footer(); ?>
