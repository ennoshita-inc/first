<?php
/**
 * トップページテンプレート v3.0
 *
 * セクション構成:
 * 1. ヒーロー (改善14: ファーストビュー)
 * 2. サービス紹介 (改善8: 見出し階層, 改善9: alt属性)
 * 3. 実績・数字 (改善14: 信頼性)
 * 4. 理念 / 私たちについて
 * 5. 導入の流れ
 * 6. ブログ
 * 7. CTA (改善12: CTA強化)
 */
get_header();
?>

  <!-- ===== 1. ヒーローセクション ===== -->
  <section class="hero">
    <div class="hero__decoration" aria-hidden="true">
      <span></span><span></span><span></span>
    </div>

    <div class="container hero__inner">
      <div class="hero__content">
        <p class="hero__label">Consulting for Growth</p>
        <h1 class="hero__title">
          <?php
          $hero_title = get_theme_mod('ennoshita_hero_title', "人・職場・組織を支え、\nリーダーの心技体を育む");
          echo nl2br(esc_html($hero_title));
          ?>
        </h1>
        <p class="hero__description">
          <?php echo esc_html(get_theme_mod('ennoshita_hero_description', '株式会社えんのしたは、岡山を拠点に人材育成・人事制度構築・組織開発の3つの柱で、組織の持続的な成長を支援するコンサルティング会社です。')); ?>
        </p>
        <div class="hero__buttons">
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--white btn--large">
            無料相談はこちら
            <svg class="btn__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
          <a href="#services" class="btn btn--outline-white btn--large">
            サービスを見る
          </a>
        </div>
      </div>

      <div class="hero__image">
        <?php
        $hero_image = get_theme_mod('ennoshita_hero_image');
        if ($hero_image) : ?>
          <img src="<?php echo esc_url($hero_image); ?>"
               alt="チームで会議をしているビジネスパーソン"
               width="480" height="360" fetchpriority="high">
        <?php else : ?>
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/hero.jpg"
               alt="チームで会議をしているビジネスパーソン"
               width="480" height="360" fetchpriority="high">
        <?php endif; ?>
      </div>
    </div>

    <div class="hero__scroll" aria-hidden="true">
      <span>SCROLL</span>
      <span class="hero__scroll-line"></span>
    </div>
  </section>


  <!-- ===== 2. サービス紹介 ===== -->
  <section class="section section--gray" id="services" aria-labelledby="services-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Services</p>
        <h2 class="section-header__title" id="services-title">3つの支援で組織の成長を実現</h2>
        <span class="section-header__line" aria-hidden="true"></span>
        <p class="section-header__description">
          「頭脳」「背骨」「筋力」の3つの観点から、組織の課題を多角的に解決します。
        </p>
      </div>

      <div class="services__grid">
        <article class="service-card reveal reveal--delay-1">
          <span class="service-card__number">SERVICE 01</span>
          <div class="service-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
              <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            </svg>
          </div>
          <h3 class="service-card__title">組織の頭脳を育む</h3>
          <p class="service-card__subtitle">人材育成サービス</p>
          <p class="service-card__text">多様な学びの場を提供し、次世代リーダーに必要な知識・スキル・マインドを体系的に育成します。</p>
          <a href="<?php echo esc_url(home_url('/service/training/')); ?>" class="service-card__link">
            詳しく見る
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
        </article>

        <article class="service-card reveal reveal--delay-2">
          <span class="service-card__number">SERVICE 02</span>
          <div class="service-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
              <line x1="3" y1="9" x2="21" y2="9"/>
              <line x1="9" y1="21" x2="9" y2="9"/>
            </svg>
          </div>
          <h3 class="service-card__title">組織の背骨を整える</h3>
          <p class="service-card__subtitle">人事制度構築支援</p>
          <p class="service-card__text">評価制度・等級制度・報酬制度など、公正で納得感のある人事制度の構築・運用を支援します。</p>
          <a href="<?php echo esc_url(home_url('/service/hr-system/')); ?>" class="service-card__link">
            詳しく見る
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
        </article>

        <article class="service-card reveal reveal--delay-3">
          <span class="service-card__number">SERVICE 03</span>
          <div class="service-card__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </div>
          <h3 class="service-card__title">組織の筋力を鍛える</h3>
          <p class="service-card__subtitle">組織開発支援</p>
          <p class="service-card__text">チームの関係性を強化し、自律的に課題を解決できる強い組織づくりをサポートします。</p>
          <a href="<?php echo esc_url(home_url('/service/organization/')); ?>" class="service-card__link">
            詳しく見る
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
        </article>
      </div>
    </div>
  </section>


  <!-- ===== 3. 実績セクション ===== -->
  <section class="section section--dark" aria-labelledby="trust-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Results</p>
        <h2 class="section-header__title" id="trust-title">えんのしたが選ばれる理由</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>

      <div class="trust__grid">
        <?php
        $trust_items = [
          ['number' => '10',  'suffix' => '年以上', 'label' => 'コンサルティング実績'],
          ['number' => '100', 'suffix' => '社+',   'label' => '支援企業数'],
          ['number' => '500', 'suffix' => '名+',   'label' => '研修受講者数'],
          ['number' => '95',  'suffix' => '%',     'label' => '顧客満足度'],
        ];
        foreach ($trust_items as $i => $item) :
        ?>
          <div class="trust__item reveal reveal--delay-<?php echo $i + 1; ?>">
            <p class="trust__number" data-count="<?php echo esc_attr($item['number']); ?>">
              0<small><?php echo esc_html($item['suffix']); ?></small>
            </p>
            <p class="trust__label"><?php echo esc_html($item['label']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>


  <!-- ===== 4. 理念セクション ===== -->
  <section class="section" aria-labelledby="philosophy-title">
    <div class="container">
      <div class="philosophy__inner">
        <div class="philosophy__image reveal reveal--left">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/hero.jpg"
               alt="えんのしたのコンサルティング風景"
               width="540" height="405" loading="lazy">
        </div>
        <div class="philosophy__text reveal reveal--right">
          <p class="section-header__label">Philosophy</p>
          <h2 class="section-header__title" id="philosophy-title">人と組織の<br>可能性を信じて</h2>
          <span class="section-header__line" style="margin: var(--space-md) 0;" aria-hidden="true"></span>
          <p>
            私たちは「人が変われば組織が変わり、組織が変われば社会が変わる」と信じています。
          </p>
          <p>
            2012年の創業以来、岡山を拠点に多くの企業様の組織課題に向き合ってきました。
            一つひとつの企業に寄り添い、その組織にとって最適な解決策を一緒に考え、実行します。
          </p>
          <a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn btn--outline">
            会社概要を見る
            <svg class="btn__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
        </div>
      </div>
    </div>
  </section>


  <!-- ===== 5. 導入の流れ ===== -->
  <section class="section section--gray" aria-labelledby="process-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Process</p>
        <h2 class="section-header__title" id="process-title">サービス導入の流れ</h2>
        <span class="section-header__line" aria-hidden="true"></span>
        <p class="section-header__description">
          お問い合わせから導入まで、4つのステップでサポートします。
        </p>
      </div>

      <div class="process__steps">
        <?php
        $steps = [
          ['title' => 'お問い合わせ',     'text' => 'まずはお気軽にご連絡ください。ご相談は無料です。'],
          ['title' => 'ヒアリング',       'text' => '組織の現状と課題を丁寧にお伺いします。'],
          ['title' => 'ご提案・お見積り', 'text' => '最適なプランをご提案し、お見積りを提出します。'],
          ['title' => 'サービス開始',     'text' => 'プログラムを実施し、組織の変革を支援します。'],
        ];
        foreach ($steps as $i => $step) :
        ?>
          <div class="process__step reveal reveal--delay-<?php echo $i + 1; ?>">
            <div class="process__step-number"><?php echo $i + 1; ?></div>
            <h3 class="process__step-title"><?php echo esc_html($step['title']); ?></h3>
            <p class="process__step-text"><?php echo esc_html($step['text']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>


  <!-- ===== 6. ブログセクション ===== -->
  <section class="section" aria-labelledby="blog-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Blog</p>
        <h2 class="section-header__title" id="blog-title">最新のコラム</h2>
        <span class="section-header__line" aria-hidden="true"></span>
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
          $delay = 1;
          while ($blog_query->have_posts()) :
            $blog_query->the_post();
        ?>
            <article class="blog-card reveal reveal--delay-<?php echo $delay++; ?>">
              <a href="<?php the_permalink(); ?>">
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

      <div class="blog-section__more reveal">
        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ?: home_url('/blog/')); ?>" class="btn btn--outline">
          コラム一覧を見る
          <svg class="btn__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </section>


  <!-- ===== 7. CTA セクション ===== -->
  <section class="cta">
    <div class="container cta__inner reveal">
      <h2 class="cta__title">
        <?php echo esc_html(get_theme_mod('ennoshita_cta_title', '組織の課題、一緒に解決しませんか？')); ?>
      </h2>
      <p class="cta__text">
        <?php echo esc_html(get_theme_mod('ennoshita_cta_text', 'まずはお気軽にご相談ください。貴社の状況をお伺いし、最適なアプローチをご提案します。')); ?>
      </p>
      <div class="cta__buttons">
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--white btn--large">
          無料相談のお申し込み
          <svg class="btn__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
        <a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn btn--outline-white btn--large">
          会社概要を見る
        </a>
      </div>
    </div>
  </section>

<?php get_footer(); ?>
