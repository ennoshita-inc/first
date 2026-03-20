<?php
/**
 * 理念セクション（共通テンプレートパート）
 *
 * 利用箇所: front-page.php, page-about.php
 * $args['context'] = 'front' | 'about' でタイトル・本文を切替
 */
$context = isset($args['context']) ? $args['context'] : 'front';
$title_id = ($context === 'about') ? 'philosophy-about-title' : 'philosophy-title';

$philosophy_img = get_theme_mod('ennoshita_philosophy_image');
$philosophy_img_url = $philosophy_img
    ? $philosophy_img
    : get_template_directory_uri() . '/assets/images/philosophy.svg';
?>

<section class="section" aria-labelledby="<?php echo esc_attr($title_id); ?>">
  <div class="container">
    <div class="philosophy__inner">
      <div class="philosophy__image reveal reveal--left">
        <img src="<?php echo esc_url($philosophy_img_url); ?>"
             alt="えんのしたのコンサルティング風景"
             width="540" height="405" loading="lazy">
      </div>
      <div class="philosophy__text reveal reveal--right">
        <p class="section-header__label">Philosophy</p>

        <?php if ($context === 'about') : ?>
          <h2 class="philosophy__heading" id="<?php echo esc_attr($title_id); ?>">
            人・職場・組織を支え、<br>リーダーの心技体を育む
          </h2>
        <?php else : ?>
          <h2 class="section-header__title" id="<?php echo esc_attr($title_id); ?>">人と組織の<br>可能性を信じて</h2>
        <?php endif; ?>

        <span class="section-header__line section-header__line--left" aria-hidden="true"></span>
        <p>
          私たちは「人が変われば組織が変わり、組織が変われば社会が変わる」と信じています。
        </p>

        <?php if ($context === 'about') : ?>
          <p>多様な学びの場を提供し、次世代のリーダーに必要な「心」「技」「体」を育む。それが、えんのしたの使命です。</p>
        <?php else : ?>
          <p>
            2012年の創業以来、岡山を拠点に多くの企業様の組織課題に向き合ってきました。
            一つひとつの企業に寄り添い、その組織にとって最適な解決策を一緒に考え、実行します。
          </p>
          <a href="<?php echo esc_url(home_url('/about/')); ?>" class="btn btn--outline">
            会社概要を見る
            <svg class="btn__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
