<?php
/**
 * Template Name: 会社概要ページ
 */
get_header();

if (have_posts()) : the_post();
?>

  <div class="page-header">
    <div class="container">
      <h1 class="page-header__title">会社概要</h1>
      <p class="page-header__subtitle">About Us</p>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <!-- 理念セクション -->
  <section class="section">
    <div class="container">
      <div class="philosophy__inner">
        <div class="philosophy__image reveal reveal--left">
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/hero.jpg"
               alt="えんのしたの理念" width="540" height="405" loading="lazy">
        </div>
        <div class="philosophy__text reveal reveal--right">
          <p class="section-header__label">Philosophy</p>
          <h2 style="font-size: var(--font-size-2xl); font-weight: 700; margin-bottom: var(--space-lg); line-height: var(--line-height-tight);">
            人・職場・組織を支え、<br>リーダーの心技体を育む
          </h2>
          <span class="section-header__line" style="margin: var(--space-md) 0;" aria-hidden="true"></span>
          <p>私たちは「人が変われば組織が変わり、組織が変われば社会が変わる」と信じています。</p>
          <p>多様な学びの場を提供し、次世代のリーダーに必要な「心」「技」「体」を育む。それが、えんのしたの使命です。</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 会社情報テーブル -->
  <section class="section section--gray">
    <div class="container container--narrow">
      <div class="section-header reveal">
        <p class="section-header__label">Company</p>
        <h2 class="section-header__title">企業情報</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>

      <div class="entry-content reveal">
        <table>
          <tbody>
            <tr><th>会社名</th><td>株式会社えんのした</td></tr>
            <tr><th>設立</th><td>2012年5月1日</td></tr>
            <tr><th>資本金</th><td>300万円</td></tr>
            <tr><th>所在地</th><td><?php echo esc_html(get_theme_mod('ennoshita_address', '岡山県岡山市 磨屋町ビル8階')); ?></td></tr>
            <tr><th>事業内容</th><td>人材育成コンサルティング<br>人事制度構築支援<br>組織開発支援</td></tr>
          </tbody>
        </table>
      </div>

      <!-- ページ本文 (追加コンテンツ用) -->
      <?php
      $content = get_the_content();
      if ($content) : ?>
        <div class="entry-content reveal" style="margin-top: var(--space-2xl);">
          <?php the_content(); ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php
endif;
get_footer();
?>
