<?php
/**
 * Template Name: お問い合わせページ
 */
get_header();

if (have_posts()) : the_post();
?>

  <div class="page-header">
    <div class="container">
      <h1 class="page-header__title">お問い合わせ</h1>
      <p class="page-header__subtitle">まずはお気軽にご相談ください。ご相談は無料です。</p>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <div class="page-content">
    <div class="container">

      <div class="contact-info__grid reveal">
        <div class="contact-info__item">
          <div class="contact-info__icon" aria-hidden="true">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <h2 class="contact-info__title">お問い合わせ</h2>
          <p class="contact-info__text">下記フォームよりご連絡ください</p>
        </div>
      </div>

      <div class="contact-form reveal">
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
      </div>

    </div>
  </div>

<?php
endif;
get_footer();
?>
