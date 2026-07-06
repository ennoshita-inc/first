<?php
/**
 * 代表者紹介ページテンプレート
 *
 * WordPressのテンプレート階層により、スラッグ「ceo」の固定ページに自動適用される。
 * 汎用 page.php は本文を読み物向けの狭い幅（container--narrow）で表示するが、
 * 代表者紹介は他の主要ページと同じ通常幅で表示する。
 */
get_header();

if (have_posts()) : the_post();
?>

  <div class="page-header">
    <div class="container">
      <p class="page-header__label">CEO Profile</p>
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

<?php
endif;
get_footer();
?>
