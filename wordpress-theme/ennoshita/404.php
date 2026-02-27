<?php
/**
 * 404エラーページテンプレート
 */
get_header();
?>

  <section class="error-404">
    <div class="container">
      <p class="error-404__number" aria-hidden="true">404</p>
      <h1 class="error-404__title">ページが見つかりませんでした</h1>
      <p class="error-404__text">
        お探しのページは移動または削除された可能性があります。<br>
        URLをご確認いただくか、以下のリンクからお探しください。
      </p>
      <div class="error-404__buttons">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
          トップページへ戻る
        </a>
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline">
          お問い合わせ
        </a>
      </div>
    </div>
  </section>

<?php get_footer(); ?>
