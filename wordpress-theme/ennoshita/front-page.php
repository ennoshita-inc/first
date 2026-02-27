<?php
/**
 * トップページテンプレート v4.0
 *
 * セクション構成:
 * 1. ヒーロー
 * 2. サービス紹介
 * 3. 実績・数字
 * 4. 理念 / 私たちについて
 * 5. 代表メッセージ
 * 6. 導入の流れ
 * 7. お客様の声
 * 8. ブログ
 * 9. CTA
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
          $hero_html = nl2br(esc_html($hero_title));
          // 「心技体」にゴールドグラデーションを適用
          $hero_html = str_replace(
            esc_html('心技体'),
            '<em class="hero__title-accent">心技体</em>',
            $hero_html
          );
          echo $hero_html;
          ?>
        </h1>
        <p class="hero__description">
          <?php echo esc_html(get_theme_mod('ennoshita_hero_description', '「人が育てば組織が変わる」――岡山を拠点に、人材育成・人事制度構築・組織開発の3つの柱で、100社以上の企業様の組織変革を支援してきました。')); ?>
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
    </div>

    <div class="hero__scroll" aria-hidden="true">
      <span>SCROLL</span>
      <span class="hero__scroll-line"></span>
    </div>
  </section>


  <!-- ===== 2. サービス紹介 ===== -->
  <section class="section" id="services" aria-labelledby="services-title">
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
          <span class="section-header__line section-header__line--left" aria-hidden="true"></span>
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


  <!-- ===== 5. 代表メッセージ ===== -->
  <section class="section section--message" aria-labelledby="message-title">
    <div class="container">
      <div class="message__inner">
        <div class="message__image reveal reveal--left">
          <?php
          $rep_photo = get_theme_mod('ennoshita_representative_photo');
          $rep_photo_url = $rep_photo ? $rep_photo : get_template_directory_uri() . '/assets/images/representative.jpg';
          ?>
          <img src="<?php echo esc_url($rep_photo_url); ?>"
               alt="代表取締役の写真"
               width="400" height="500" loading="lazy">
        </div>
        <div class="message__text reveal reveal--right">
          <p class="section-header__label">Message</p>
          <h2 class="section-header__title" id="message-title">代表メッセージ</h2>
          <span class="section-header__line section-header__line--left" aria-hidden="true"></span>
          <p class="message__lead">
            組織は、制度では変わりません。<br>
            変わるのは、人です。
          </p>
          <p>
            企業の成長を左右するのは外部環境だけではありません。多くの場合、課題は組織の内側にあります。
          </p>
          <p>
            制度や理論は必要です。しかし、それを動かすのは人の意思と行動です。
          </p>
          <p>
            これまで数多くの現場で、自ら課題を考え、行動を起こすリーダーの変化を見てきました。そして、その挑戦を受け止める経営者の変化も見てきました。
          </p>
          <p>
            人の認識と覚悟が変わったとき、組織は静かに前へ進みます。
          </p>
          <p>
            私たちは、仕組みだけを設計する会社ではありません。未来を言語化し、現状とのギャップを整理し、戦略・制度・育成・対話を一貫して組み立てます。
          </p>
          <p>
            本質を押さえながら、具体策まで落とし込む。実行し、検証し、積み重ねる。
          </p>
          <p>
            その過程を通じて、働く人が誇りを持ち、組織に活力が生まれる状態を支援します。
          </p>
          <p>
            変革とは、特別な出来事ではなく、主体性が連鎖するプロセスです。
          </p>
          <p>
            その歩みに責任を持って伴走いたします。
          </p>
          <p class="message__signature">
            <span class="message__position">代表取締役</span>
            <span class="message__name-text">川路 隆志</span>
          </p>
        </div>
      </div>
    </div>
  </section>


  <!-- ===== 6. 導入の流れ ===== -->
  <section class="section section--gray" id="process" aria-labelledby="process-title">
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


  <!-- ===== 7. お客様の声 ===== -->
  <section class="section" aria-labelledby="testimonials-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Voice</p>
        <h2 class="section-header__title" id="testimonials-title">お客様の声</h2>
        <span class="section-header__line" aria-hidden="true"></span>
        <p class="section-header__description">
          導入企業様の人事ご担当者様からいただいたお声をご紹介します。
        </p>
      </div>

      <div class="testimonials__grid">
        <article class="testimonial-card reveal reveal--delay-1">
          <div class="testimonial-card__quote">
            <svg class="testimonial-card__icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/></svg>
            <p>管理職研修を導入してから、部下との1on1の質が目に見えて変わりました。現場からも「相談しやすくなった」という声が上がっています。</p>
          </div>
          <div class="testimonial-card__author">
            <div class="testimonial-card__avatar" aria-hidden="true"></div>
            <div class="testimonial-card__info">
              <p class="testimonial-card__company">製造業 A社様（従業員300名）</p>
              <p class="testimonial-card__role">人事部長</p>
            </div>
          </div>
        </article>

        <article class="testimonial-card reveal reveal--delay-2">
          <div class="testimonial-card__quote">
            <svg class="testimonial-card__icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/></svg>
            <p>人事制度の再構築を依頼しましたが、現場の声を丁寧にヒアリングし、当社の文化に合った制度を設計してくれました。社員の納得感が段違いです。</p>
          </div>
          <div class="testimonial-card__author">
            <div class="testimonial-card__avatar" aria-hidden="true"></div>
            <div class="testimonial-card__info">
              <p class="testimonial-card__company">IT企業 B社様（従業員150名）</p>
              <p class="testimonial-card__role">代表取締役</p>
            </div>
          </div>
        </article>

        <article class="testimonial-card reveal reveal--delay-3">
          <div class="testimonial-card__quote">
            <svg class="testimonial-card__icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/></svg>
            <p>組織開発のワークショップを通じて、部署間の壁が徐々になくなりました。「チーム全体で考える」文化が根付き始めています。</p>
          </div>
          <div class="testimonial-card__author">
            <div class="testimonial-card__avatar" aria-hidden="true"></div>
            <div class="testimonial-card__info">
              <p class="testimonial-card__company">サービス業 C社様（従業員500名）</p>
              <p class="testimonial-card__role">経営企画室 室長</p>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>


  <!-- ===== 8. ブログセクション ===== -->
  <section class="section section--gray" aria-labelledby="blog-title">
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
          while ($blog_query->have_posts()) :
            $blog_query->the_post();
            get_template_part('template-parts/content', 'card');
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
