<?php
/**
 * トップページテンプレート
 *
 * 改善ポイント:
 * - ヒーローセクションの訴求力強化（改善14）
 * - 適切な見出し階層（改善8）
 * - CTAの強化（改善12）
 * - 画像最適化（改善5）
 * - アクセシビリティ対応
 */

get_header();
?>

  <!-- ===== ヒーローセクション ===== -->
  <section class="hero">
    <div class="container hero__inner">
      <div class="hero__content">
        <h1 class="hero__title">
          <span>CONSULTING FOR GROWTH</span>
          人・職場・組織を支え、<br>リーダーの心技体を育む
        </h1>
        <p class="hero__description">
          株式会社えんのしたは、岡山を拠点に人材育成・人事制度構築・組織開発の3つの柱で、
          組織の持続的な成長を支援するコンサルティング会社です。
        </p>
        <div class="hero__buttons">
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--primary btn--large">
            無料相談はこちら
          </a>
          <a href="#services" class="btn btn--outline btn--large">
            サービスを見る
          </a>
        </div>
      </div>
      <div class="hero__image">
        <?php
        // カスタマイザーまたはACFで画像を管理する場合
        $hero_image_id = get_theme_mod('ennoshita_hero_image');
        if ($hero_image_id) :
        ?>
          <picture>
            <?php
            $webp_url = wp_get_attachment_image_url($hero_image_id, 'hero');
            // WebP変換はプラグイン（EWWW等）で自動化推奨
            ?>
            <img
              src="<?php echo esc_url(wp_get_attachment_image_url($hero_image_id, 'hero')); ?>"
              alt="<?php echo esc_attr(get_post_meta($hero_image_id, '_wp_attachment_image_alt', true) ?: 'チームで会議をしているビジネスパーソン'); ?>"
              width="480"
              height="360"
              fetchpriority="high"
            >
          </picture>
        <?php else : ?>
          <img
            src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/hero-default.jpg"
            alt="チームで会議をしているビジネスパーソン"
            width="480"
            height="360"
            fetchpriority="high"
          >
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ===== サービス紹介（改善8: 適切な見出し階層 h1→h2→h3） ===== -->
  <section class="features" id="services" aria-labelledby="services-title">
    <div class="container">
      <div class="section-header">
        <p class="section-header__label">Services</p>
        <h2 class="section-header__title" id="services-title">3つの支援で組織の成長を実現</h2>
        <p class="section-header__description">
          「頭脳」「背骨」「筋力」の3つの観点から、組織の課題を多角的に解決します。
        </p>
      </div>
      <div class="features__grid">

        <article class="feature-card">
          <div class="feature-card__icon" aria-hidden="true">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
              <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            </svg>
          </div>
          <h3 class="feature-card__title">組織の頭脳を育む</h3>
          <p class="feature-card__subtitle">人材育成サービス</p>
          <p class="feature-card__text">
            多様な学びの場を提供し、次世代リーダーに必要な知識・スキル・マインドを体系的に育成します。
          </p>
          <a href="<?php echo esc_url(home_url('/service/training/')); ?>" class="feature-card__link">
            詳しく見る <span aria-hidden="true">&rarr;</span>
          </a>
        </article>

        <article class="feature-card">
          <div class="feature-card__icon" aria-hidden="true">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
              <line x1="3" y1="9" x2="21" y2="9"/>
              <line x1="9" y1="21" x2="9" y2="9"/>
            </svg>
          </div>
          <h3 class="feature-card__title">組織の背骨を整える</h3>
          <p class="feature-card__subtitle">人事制度構築支援</p>
          <p class="feature-card__text">
            評価制度・等級制度・報酬制度など、公正で納得感のある人事制度の構築・運用を支援します。
          </p>
          <a href="<?php echo esc_url(home_url('/service/hr-system/')); ?>" class="feature-card__link">
            詳しく見る <span aria-hidden="true">&rarr;</span>
          </a>
        </article>

        <article class="feature-card">
          <div class="feature-card__icon" aria-hidden="true">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </div>
          <h3 class="feature-card__title">組織の筋力を鍛える</h3>
          <p class="feature-card__subtitle">組織開発支援</p>
          <p class="feature-card__text">
            チームの関係性を強化し、自律的に課題を解決できる強い組織づくりをサポートします。
          </p>
          <a href="<?php echo esc_url(home_url('/service/organization/')); ?>" class="feature-card__link">
            詳しく見る <span aria-hidden="true">&rarr;</span>
          </a>
        </article>

      </div>
    </div>
  </section>

  <!-- ===== 実績セクション（改善14: 信頼性の訴求） ===== -->
  <section class="trust" aria-labelledby="trust-title">
    <div class="container">
      <div class="section-header">
        <p class="section-header__label">Results</p>
        <h2 class="section-header__title" id="trust-title">えんのしたの実績</h2>
      </div>
      <div class="trust__grid">
        <?php
        // カスタマイザーまたはACFで管理推奨（以下はデフォルト値）
        $trust_items = [
          ['number' => '10',  'suffix' => '年以上', 'label' => 'コンサルティング実績'],
          ['number' => '100', 'suffix' => '社+',   'label' => '支援企業数'],
          ['number' => '500', 'suffix' => '名+',   'label' => '研修受講者数'],
          ['number' => '95',  'suffix' => '%',     'label' => '顧客満足度'],
        ];
        foreach ($trust_items as $item) :
        ?>
          <div class="trust__item">
            <p class="trust__item-number">
              <?php echo esc_html($item['number']); ?><small><?php echo esc_html($item['suffix']); ?></small>
            </p>
            <p class="trust__item-label"><?php echo esc_html($item['label']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ===== ブログセクション ===== -->
  <section class="blog-section" aria-labelledby="blog-title">
    <div class="container">
      <div class="section-header">
        <p class="section-header__label">Blog</p>
        <h2 class="section-header__title" id="blog-title">最新のコラム</h2>
        <p class="section-header__description">
          人材育成・組織開発に関する知見をお届けします。
        </p>
      </div>
      <div class="blog__grid">
        <?php
        $blog_query = new WP_Query([
          'posts_per_page' => 3,
          'post_status'    => 'publish',
        ]);

        if ($blog_query->have_posts()) :
          while ($blog_query->have_posts()) :
            $blog_query->the_post();
        ?>
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
                  <h3 class="blog-card__title"><?php the_title(); ?></h3>
                  <time class="blog-card__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo esc_html(get_the_date('Y.m.d')); ?>
                  </time>
                </div>
              </a>
            </article>
        <?php
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>
      <div class="blog-section__more">
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn--outline">
          コラム一覧を見る
        </a>
      </div>
    </div>
  </section>

  <!-- ===== CTA セクション（改善12: CTA強化） ===== -->
  <section class="cta">
    <div class="container">
      <h2 class="cta__title">組織の課題、一緒に解決しませんか？</h2>
      <p class="cta__text">
        まずはお気軽にご相談ください。<br class="sp-only">
        貴社の状況をお伺いし、最適なアプローチをご提案します。
      </p>
      <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--primary btn--large">
        無料相談のお申し込み
      </a>
    </div>
  </section>

<?php get_footer(); ?>
