<?php
/**
 * ブログ記事テンプレート
 */
get_header();

if (have_posts()) : the_post();
?>

  <?php ennoshita_breadcrumb(); ?>

  <div class="post-header">
    <div class="container container--narrow">
      <div class="post-header__meta">
        <?php $categories = get_the_category(); if ($categories) : ?>
          <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="post-header__category">
            <?php echo esc_html($categories[0]->name); ?>
          </a>
        <?php endif; ?>
        <time class="post-header__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
          <?php echo esc_html(get_the_date('Y年n月j日')); ?>
        </time>
        <span class="post-header__date">約<?php echo ennoshita_reading_time(); ?>分で読めます</span>
      </div>
      <h1 class="post-header__title"><?php the_title(); ?></h1>
    </div>
  </div>

  <div class="post-content">
    <div class="container container--narrow">
      <?php if (has_post_thumbnail()) : ?>
        <figure class="post-thumbnail">
          <?php the_post_thumbnail('large', [
            'loading'  => 'eager',
          ]); ?>
        </figure>
      <?php endif; ?>

      <div class="post-content__body entry-content">
        <?php the_content(); ?>
      </div>

      <?php
      // タグ表示
      $tags = get_the_tags();
      if ($tags) : ?>
        <div class="post-tags">
          <div class="post-tags__list">
            <?php foreach ($tags as $tag) : ?>
              <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="post-tags__link">
                #<?php echo esc_html($tag->name); ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <!-- SNSシェアボタン -->
      <div class="share-buttons">
        <p class="share-buttons__label">この記事をシェア</p>
        <div class="share-buttons__list">
          <a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode(get_permalink()); ?>&amp;text=<?php echo rawurlencode(get_the_title()); ?>"
             class="share-buttons__item share-buttons__item--x"
             target="_blank" rel="noopener noreferrer" aria-label="Xでシェア">X</a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode(get_permalink()); ?>"
             class="share-buttons__item share-buttons__item--fb"
             target="_blank" rel="noopener noreferrer" aria-label="Facebookでシェア">Facebook</a>
          <a href="https://b.hatena.ne.jp/add?mode=confirm&amp;url=<?php echo rawurlencode(get_permalink()); ?>"
             class="share-buttons__item share-buttons__item--hatena"
             target="_blank" rel="noopener noreferrer" aria-label="はてなブックマークに追加">はてブ</a>
          <a href="https://social-plugins.line.me/lineit/share?url=<?php echo rawurlencode(get_permalink()); ?>"
             class="share-buttons__item share-buttons__item--line"
             target="_blank" rel="noopener noreferrer" aria-label="LINEで送る">LINE</a>
        </div>
      </div>

      <!-- 著者情報 -->
      <aside class="author-box" aria-label="この記事を書いた人">
        <div class="author-box__inner">
          <?php echo get_avatar(get_the_author_meta('ID'), 80, '', get_the_author(), ['class' => 'author-box__avatar']); ?>
          <div class="author-box__content">
            <p class="author-box__label">この記事を書いた人</p>
            <p class="author-box__name"><?php the_author(); ?></p>
            <?php $author_desc = get_the_author_meta('description');
            if ($author_desc) : ?>
              <p class="author-box__desc"><?php echo esc_html($author_desc); ?></p>
            <?php else : ?>
              <p class="author-box__desc">株式会社えんのした｜岡山を拠点に人材育成・人事制度構築・組織開発の3つの柱で、企業の持続的な成長を支援しています。</p>
            <?php endif; ?>
            <div class="author-box__links">
              <a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn btn--small btn--outline">会社概要</a>
              <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--small btn--primary">お問い合わせ</a>
            </div>
          </div>
        </div>
      </aside>

      <!-- 前後の記事ナビ -->
      <?php
      $prev = get_previous_post();
      $next = get_next_post();
      if ($prev || $next) :
      ?>
        <nav class="post-nav" aria-label="前後の記事">
          <div class="post-nav__item">
            <?php if ($prev) : ?>
              <span class="post-nav__label">前の記事</span>
              <a href="<?php echo esc_url(get_permalink($prev)); ?>" class="post-nav__title">
                <?php echo esc_html($prev->post_title); ?>
              </a>
            <?php endif; ?>
          </div>
          <div class="post-nav__item post-nav__item--next">
            <?php if ($next) : ?>
              <span class="post-nav__label">次の記事</span>
              <a href="<?php echo esc_url(get_permalink($next)); ?>" class="post-nav__title">
                <?php echo esc_html($next->post_title); ?>
              </a>
            <?php endif; ?>
          </div>
        </nav>
      <?php endif; ?>
    </div>
  </div>

  <!-- 関連記事 -->
  <?php
  $related_args = [
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
    'post_status'    => 'publish',
  ];
  if ($categories) {
    $related_args['category__in'] = [$categories[0]->term_id];
  }
  $related = new WP_Query($related_args);

  if ($related->have_posts()) :
  ?>
    <section class="related-posts" aria-labelledby="related-title">
      <div class="container">
        <div class="section-header">
          <p class="section-header__label">Related</p>
          <h2 class="section-header__title" id="related-title">関連記事</h2>
          <span class="section-header__line" aria-hidden="true"></span>
        </div>
        <div class="blog__grid">
          <?php while ($related->have_posts()) : $related->the_post(); ?>
            <?php get_template_part('template-parts/content', 'card'); ?>
          <?php endwhile; ?>
        </div>
      </div>
    </section>
  <?php
    wp_reset_postdata();
  endif;
  ?>

  <div class="container">
    <?php get_template_part('template-parts/section', 'lead-magnet'); ?>
  </div>

  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php
endif;
get_footer();
?>
