<?php
/**
 * メルマガ登録CTA
 * ブログサイドバーや記事末尾で使用
 */
$newsletter_url = get_theme_mod('ennoshita_newsletter_url');
if (!$newsletter_url) return;
?>

<div class="newsletter-cta">
  <div class="newsletter-cta__icon" aria-hidden="true">
    <?php echo ennoshita_icon('mail', 28); ?>
  </div>
  <h3 class="newsletter-cta__title">無料メルマガ登録</h3>
  <p class="newsletter-cta__text">人材育成・組織開発に関する最新の知見やノウハウをお届けします。</p>
  <a href="<?php echo esc_url($newsletter_url); ?>" class="btn btn--primary btn--small" target="_blank" rel="noopener">
    メルマガに登録する <?php echo ennoshita_icon('arrow-right', 14); ?>
  </a>
</div>
