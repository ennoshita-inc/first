<?php
/**
 * 共通CTAセクション
 * front-page.php, page-service.php, single.php, index.php, archive.php で再利用
 */
?>
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
      <a href="<?php echo esc_url(home_url('/#services')); ?>" class="btn btn--outline-white btn--large">
        サービス一覧を見る
        <svg class="btn__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>
