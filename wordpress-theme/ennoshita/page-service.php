<?php
/**
 * Template Name: サービス詳細ページ
 *
 * サービス詳細ページ用テンプレート。
 * カスタムフィールド（抜粋）で「サブタイトル」を設定可能。
 * 本文はWordPressエディタで入力した内容が service-detail レイアウトで表示されます。
 */
get_header();

if (have_posts()) : the_post();
?>

  <div class="page-header">
    <div class="container">
      <h1 class="page-header__title"><?php the_title(); ?></h1>
      <?php if (has_excerpt()) : ?>
        <p class="page-header__subtitle"><?php echo esc_html(get_the_excerpt()); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <div class="page-content">
    <div class="container">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </div>
  </div>

  <!-- CTA -->
  <section class="cta">
    <div class="container cta__inner">
      <h2 class="cta__title">このサービスについて相談する</h2>
      <p class="cta__text">まずはお気軽にご相談ください。貴社の状況をお伺いし、最適なアプローチをご提案します。</p>
      <div class="cta__buttons">
        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--white btn--large">
          お問い合わせはこちら
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
