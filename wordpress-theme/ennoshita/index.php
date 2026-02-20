<?php
/**
 * メインテンプレート（WordPress必須ファイル）
 * ブログ一覧やアーカイブページのフォールバック
 */
get_header();
?>

<section class="blog-section" aria-labelledby="archive-title">
  <div class="container">
    <div class="section-header">
      <p class="section-header__label">Blog</p>
      <h1 class="section-header__title" id="archive-title">
        <?php
        if (is_category()) {
            single_cat_title();
        } elseif (is_tag()) {
            single_tag_title();
        } elseif (is_search()) {
            printf('「%s」の検索結果', esc_html(get_search_query()));
        } else {
            echo 'コラム一覧';
        }
        ?>
      </h1>
    </div>

    <?php if (have_posts()) : ?>
      <div class="blog__grid">
        <?php while (have_posts()) : the_post(); ?>
          <article class="blog-card">
            <a href="<?php the_permalink(); ?>">
              <div class="blog-card__image">
                <?php if (has_post_thumbnail()) : ?>
                  <?php the_post_thumbnail('blog-card', [
                    'loading' => 'lazy',
                    'alt'     => get_the_title() . 'のイメージ',
                  ]); ?>
                <?php else : ?>
                  <img
                    src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/no-image.jpg"
                    alt=""
                    width="400"
                    height="225"
                    loading="lazy"
                  >
                <?php endif; ?>
              </div>
              <div class="blog-card__body">
                <?php
                $categories = get_the_category();
                if ($categories) :
                ?>
                  <span class="blog-card__category"><?php echo esc_html($categories[0]->name); ?></span>
                <?php endif; ?>
                <h2 class="blog-card__title"><?php the_title(); ?></h2>
                <time class="blog-card__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                  <?php echo esc_html(get_the_date('Y.m.d')); ?>
                </time>
              </div>
            </a>
          </article>
        <?php endwhile; ?>
      </div>

      <nav class="pagination" aria-label="ページナビゲーション">
        <?php
        the_posts_pagination([
          'mid_size'  => 2,
          'prev_text' => '&laquo; 前へ',
          'next_text' => '次へ &raquo;',
        ]);
        ?>
      </nav>
    <?php else : ?>
      <p>記事が見つかりませんでした。</p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
