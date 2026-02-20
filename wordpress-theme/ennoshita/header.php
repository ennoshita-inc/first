<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- スキップリンク（改善: アクセシビリティ） -->
<a class="skip-link screen-reader-text" href="#main-content">メインコンテンツへスキップ</a>

<!-- ===== ヘッダー ===== -->
<header class="header" role="banner">
  <div class="container header__inner">
    <div class="header__logo">
      <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?> トップページへ">
        <?php if (has_custom_logo()) : ?>
          <?php
          $custom_logo_id = get_theme_mod('custom_logo');
          $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
          ?>
          <img src="<?php echo esc_url($logo[0]); ?>"
               alt="<?php bloginfo('name'); ?>"
               width="180" height="40"
               loading="eager">
        <?php else : ?>
          <?php bloginfo('name'); ?>
        <?php endif; ?>
      </a>
    </div>

    <!-- 改善13: モバイル用ハンバーガーメニュー（aria属性付き） -->
    <button class="hamburger"
            aria-label="メニューを開く"
            aria-expanded="false"
            aria-controls="main-nav">
      <span class="hamburger__line"></span>
      <span class="hamburger__line"></span>
      <span class="hamburger__line"></span>
    </button>

    <nav class="nav" id="main-nav" role="navigation" aria-label="メインナビゲーション">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'nav__list',
        'fallback_cb'    => false,
        'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
        'link_before'    => '',
        'link_after'     => '',
      ]);
      ?>
    </nav>
  </div>
</header>

<main id="main-content">
