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
          <h2 class="contact-info__title">メール</h2>
          <?php $email = get_theme_mod('ennoshita_email'); ?>
          <p class="contact-info__text"><?php echo $email ? esc_html($email) : 'お問い合わせフォームをご利用ください'; ?></p>
        </div>

        <div class="contact-info__item">
          <div class="contact-info__icon" aria-hidden="true">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <h2 class="contact-info__title">所在地</h2>
          <p class="contact-info__text"><?php echo esc_html(get_theme_mod('ennoshita_address', '岡山県岡山市 磨屋町ビル8階')); ?></p>
        </div>

        <div class="contact-info__item">
          <div class="contact-info__icon" aria-hidden="true">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <h2 class="contact-info__title">営業時間</h2>
          <p class="contact-info__text">平日 9:00 - 18:00<br>土日祝休み</p>
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
