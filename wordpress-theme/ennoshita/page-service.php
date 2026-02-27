<?php
/**
 * Template Name: サービス詳細ページ
 *
 * 3つのサービス詳細に使うページテンプレート。
 * page-header にはフロントページと同じダークグラデーションを使用。
 * 本文エリアは service-detail レイアウト。
 * 他サービスへの導線 + 導入の流れ + CTA。
 */
get_header();

if (have_posts()) : the_post();
?>

  <div class="page-header">
    <div class="container">
      <?php if (has_excerpt()) : ?>
        <p class="page-header__label"><?php echo esc_html(get_the_excerpt()); ?></p>
      <?php endif; ?>
      <h1 class="page-header__title"><?php the_title(); ?></h1>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <section class="service-detail">
    <div class="container container--narrow">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </div>
  </section>

  <!-- 他のサービス -->
  <section class="section section--gray" aria-labelledby="other-services-title">
    <div class="container">
      <div class="section-header">
        <p class="section-header__label">Other Services</p>
        <h2 class="section-header__title" id="other-services-title">その他のサービス</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>

      <div class="services__grid services__grid--compact">
        <?php
        $services = [
          ['slug' => '/service/training/',     'number' => 'SERVICE 01', 'title' => '組織の頭脳を育む', 'subtitle' => '人材育成サービス',
           'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>'],
          ['slug' => '/service/hr-system/',    'number' => 'SERVICE 02', 'title' => '組織の背骨を整える', 'subtitle' => '人事制度構築支援',
           'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>'],
          ['slug' => '/service/organization/', 'number' => 'SERVICE 03', 'title' => '組織の筋力を鍛える', 'subtitle' => '組織開発支援',
           'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'],
        ];

        $current_url = trailingslashit(get_permalink());
        foreach ($services as $svc) :
          $svc_url = home_url($svc['slug']);
          // 現在表示中のサービスはスキップ
          if (trailingslashit($svc_url) === $current_url) continue;
        ?>
          <article class="service-card">
            <span class="service-card__number"><?php echo esc_html($svc['number']); ?></span>
            <div class="service-card__icon" aria-hidden="true">
              <?php echo $svc['icon']; ?>
            </div>
            <h3 class="service-card__title"><?php echo esc_html($svc['title']); ?></h3>
            <p class="service-card__subtitle"><?php echo esc_html($svc['subtitle']); ?></p>
            <a href="<?php echo esc_url($svc_url); ?>" class="service-card__link">
              詳しく見る
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 導入の流れ — トップページと統一 -->
  <section class="section" aria-labelledby="process-title-service">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Process</p>
        <h2 class="section-header__title" id="process-title-service">サービス導入の流れ</h2>
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

  <!-- CTA — トップページと統一 -->
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

<?php
endif;
get_footer();
?>
