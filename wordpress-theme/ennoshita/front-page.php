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
  <?php $hero_image = get_theme_mod('ennoshita_hero_image'); ?>
  <section class="hero">
    <?php if ($hero_image) : ?>
      <div class="hero__bg" style="background-image:url('<?php echo esc_url($hero_image); ?>')" aria-hidden="true"></div>
    <?php endif; ?>
    <div class="hero__overlay" aria-hidden="true"></div>
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
        <?php
        $services = ennoshita_get_services();
        foreach ($services as $i => $svc) :
        ?>
        <article class="service-card reveal reveal--delay-<?php echo $i + 1; ?>">
          <span class="service-card__number"><?php echo esc_html($svc['number']); ?></span>
          <div class="service-card__icon" aria-hidden="true">
            <?php echo $svc['icon']; ?>
          </div>
          <h3 class="service-card__title"><?php echo esc_html($svc['title']); ?></h3>
          <p class="service-card__subtitle"><?php echo esc_html($svc['subtitle']); ?></p>
          <p class="service-card__text"><?php echo esc_html($svc['text']); ?></p>
          <a href="<?php echo esc_url(home_url($svc['slug'])); ?>" class="service-card__link">
            詳しく見る
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>



  <!-- ===== 3. 実績・数字 ===== -->
  <section class="section section--dark" aria-labelledby="trust-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Results</p>
        <h2 class="section-header__title" id="trust-title">えんのしたの実績</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <div class="trust__grid reveal">
        <?php
        for ($i = 1; $i <= 4; $i++) :
          $number = get_theme_mod("ennoshita_trust_{$i}_number", '');
          $unit   = get_theme_mod("ennoshita_trust_{$i}_unit", '');
          $label  = get_theme_mod("ennoshita_trust_{$i}_label", '');
          $link   = get_theme_mod("ennoshita_trust_{$i}_link", '');
          if (!$number) continue;
        ?>
          <div class="trust__item">
            <?php if ($link) : ?><a href="<?php echo esc_url($link); ?>" class="trust__link"><?php endif; ?>
              <p class="trust__number" data-count="<?php echo esc_attr($number); ?>">0<small><?php echo esc_html($unit); ?></small></p>
              <p class="trust__label"><?php echo esc_html($label); ?></p>
            <?php if ($link) : ?></a><?php endif; ?>
          </div>
        <?php endfor; ?>
      </div>
      <p class="trust__note">※ 各数字は実際の導入事例・提供実績に基づいています。<a href="<?php echo esc_url(home_url('/service/training/')); ?>">詳しくはサービス詳細をご覧ください</a></p>
    </div>
  </section>


  <!-- ===== 4. 理念セクション ===== -->
  <section class="section" aria-labelledby="philosophy-title">
    <div class="container">
      <div class="philosophy__inner">
        <div class="philosophy__image reveal reveal--left">
          <?php
          $philosophy_img = get_theme_mod('ennoshita_philosophy_image');
          $philosophy_img_url = $philosophy_img ? $philosophy_img : get_template_directory_uri() . '/assets/images/philosophy.svg';
          ?>
          <img src="<?php echo esc_url($philosophy_img_url); ?>"
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
          $rep_photo_url = $rep_photo ? $rep_photo : get_template_directory_uri() . '/assets/images/representative.svg';
          ?>
          <img src="<?php echo esc_url($rep_photo_url); ?>"
               alt="代表取締役の写真"
               width="260" height="325" loading="lazy">
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
  <?php get_template_part('template-parts/section', 'process', ['id' => 'process-title']); ?>


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
        <?php
        // カスタム投稿タイプ「お客様の声」から取得
        $testimonial_query = new WP_Query([
            'post_type'      => 'testimonial',
            'posts_per_page' => 3,
            'post_status'    => 'publish',
        ]);

        if ($testimonial_query->have_posts()) :
          $delay = 1;
          while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
            $company = get_post_meta(get_the_ID(), '_testimonial_company', true);
            $role    = get_post_meta(get_the_ID(), '_testimonial_role', true);
        ?>
          <article class="testimonial-card reveal reveal--delay-<?php echo $delay++; ?>">
            <div class="testimonial-card__quote">
              <svg class="testimonial-card__icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/></svg>
              <?php the_content(); ?>
            </div>
            <div class="testimonial-card__author">
              <div class="testimonial-card__avatar" aria-hidden="true"></div>
              <div class="testimonial-card__info">
                <?php if ($company) : ?>
                  <p class="testimonial-card__company"><?php echo esc_html($company); ?></p>
                <?php endif; ?>
                <?php if ($role) : ?>
                  <p class="testimonial-card__role"><?php echo esc_html($role); ?></p>
                <?php endif; ?>
              </div>
            </div>
          </article>
        <?php
          endwhile;
          wp_reset_postdata();
        else :
          // カスタム投稿がまだない場合のデフォルト表示
          $defaults = [
            ['text' => '管理職研修を導入してから、部下との1on1の質が目に見えて変わりました。現場からも「相談しやすくなった」という声が上がっています。', 'company' => '製造業 A社様（従業員300名）', 'role' => '人事部長'],
            ['text' => '人事制度の再構築を依頼しましたが、現場の声を丁寧にヒアリングし、当社の文化に合った制度を設計してくれました。社員の納得感が段違いです。', 'company' => 'IT企業 B社様（従業員150名）', 'role' => '代表取締役'],
            ['text' => '組織開発のワークショップを通じて、部署間の壁が徐々になくなりました。「チーム全体で考える」文化が根付き始めています。', 'company' => 'サービス業 C社様（従業員500名）', 'role' => '経営企画室 室長'],
          ];
          foreach ($defaults as $i => $item) :
        ?>
          <article class="testimonial-card reveal reveal--delay-<?php echo $i + 1; ?>">
            <div class="testimonial-card__quote">
              <svg class="testimonial-card__icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/></svg>
              <p><?php echo esc_html($item['text']); ?></p>
            </div>
            <div class="testimonial-card__author">
              <div class="testimonial-card__avatar" aria-hidden="true"></div>
              <div class="testimonial-card__info">
                <p class="testimonial-card__company"><?php echo esc_html($item['company']); ?></p>
                <p class="testimonial-card__role"><?php echo esc_html($item['role']); ?></p>
              </div>
            </div>
          </article>
        <?php endforeach; endif; ?>
      </div>
    </div>
  </section>


  <!-- ===== パートナー・メディア掲載 ===== -->
  <?php get_template_part('template-parts/section', 'partners'); ?>


  <!-- ===== 8. ブログセクション ===== -->
  <section class="section section--gray" id="blog" aria-labelledby="blog-title">
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
        else :
        ?>
          <p class="blog__empty">コラム記事を準備中です。近日公開予定です。</p>
        <?php
        endif;
        ?>
      </div>

      <div class="blog-section__more reveal">
        <a href="<?php echo esc_url(ennoshita_get_blog_url()); ?>" class="btn btn--outline">
          コラム一覧を見る
          <svg class="btn__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </section>


  <!-- ===== 9. CTA セクション ===== -->
  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php get_footer(); ?>
