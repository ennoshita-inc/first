<?php
/**
 * Template Name: サービス詳細ページ
 *
 * 3つのサービス詳細に使うページテンプレート。
 * page-header にはフロントページと同じダークグラデーションを使用。
 * 本文エリアは service-detail レイアウト。
 * 導入の流れはトップページと同じ内容を表示。
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
    <div class="container">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </div>
  </section>

  <!-- 導入の流れ — トップページと統一 -->
  <section class="section section--gray" aria-labelledby="process-title-service">
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
