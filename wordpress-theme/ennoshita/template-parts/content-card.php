<?php
/**
 * ブログカード パーツ (一覧・関連記事で共通利用)
 * v3.2 — アクセシビリティ改善: タイトルのみリンク、カード全体はCSS ::afterでクリック可能
 */
?>
<article class="blog-card reveal">
  <div class="blog-card__image">
    <?php if (has_post_thumbnail()) : ?>
      <?php the_post_thumbnail('blog-card', [
        'loading' => 'lazy',
        'alt'     => get_the_title(),
      ]); ?>
    <?php else : ?>
      <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/no-image.jpg"
           alt="" width="400" height="225" loading="lazy">
    <?php endif; ?>
  </div>
  <div class="blog-card__body">
    <?php $categories = get_the_category(); if ($categories) : ?>
      <span class="blog-card__category"><?php echo esc_html($categories[0]->name); ?></span>
    <?php endif; ?>
    <h3 class="blog-card__title">
      <a href="<?php the_permalink(); ?>" class="blog-card__link"><?php the_title(); ?></a>
    </h3>
    <p class="blog-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 40, '…')); ?></p>
    <div class="blog-card__meta">
      <span class="blog-card__author"><?php the_author(); ?></span>
      <time class="blog-card__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
        <?php echo esc_html(get_the_date('Y.m.d')); ?>
      </time>
    </div>
  </div>
</article>
