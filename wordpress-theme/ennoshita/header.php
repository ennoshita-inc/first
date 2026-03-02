<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if (is_front_page()) : ?>
<div class="page-loading" aria-hidden="true">
  <div class="page-loading__spinner"></div>
</div>
<?php endif; ?>

<a class="skip-link" href="#main-content">メインコンテンツへスキップ</a>

<header class="site-header" role="banner">
  <div class="container site-header__inner">
    <?php ennoshita_the_logo(); ?>

    <?php
    $header_phone = get_theme_mod('ennoshita_phone');
    if ($header_phone) : ?>
      <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $header_phone)); ?>" class="site-header__phone" aria-label="電話でのお問い合わせ">
        <svg class="site-header__phone-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        <span class="site-header__phone-number"><?php echo esc_html($header_phone); ?></span>
      </a>
    <?php endif; ?>

    <button class="hamburger" aria-expanded="false" aria-controls="main-nav" aria-label="メニューを開く">
      <span class="hamburger__lines">
        <span class="hamburger__line"></span>
        <span class="hamburger__line"></span>
        <span class="hamburger__line"></span>
      </span>
    </button>

    <nav class="main-nav" id="main-nav" role="navigation" aria-label="メインナビゲーション">
      <?php if (has_nav_menu('primary')) : ?>
        <?php wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'main-nav__list',
          'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s<li><a href="' . esc_url(home_url('/contact/')) . '" class="main-nav__contact">お問い合わせ</a></li></ul>',
          'link_before'    => '<span class="main-nav__link">',
          'link_after'     => '</span>',
          'depth'          => 2,
        ]); ?>
      <?php else : ?>
        <ul class="main-nav__list">
          <li><a href="<?php echo esc_url(home_url('/about/')); ?>" class="main-nav__link">会社概要</a></li>
          <li class="has-submenu">
            <a href="<?php echo esc_url(home_url('/#services')); ?>" class="main-nav__link">サービス</a>
            <ul class="sub-menu">
              <li><a href="<?php echo esc_url(home_url('/service/training/')); ?>">人材育成サービス</a></li>
              <li><a href="<?php echo esc_url(home_url('/service/hr-system/')); ?>">人事制度構築支援</a></li>
              <li><a href="<?php echo esc_url(home_url('/service/organization/')); ?>">組織開発支援</a></li>
            </ul>
          </li>
          <li><a href="<?php echo esc_url(ennoshita_get_blog_url()); ?>" class="main-nav__link">コラム</a></li>
          <li><a href="<?php echo esc_url(home_url('/contact/')); ?>" class="main-nav__contact">お問い合わせ</a></li>
        </ul>
      <?php endif; ?>
    </nav>

    <div class="nav-overlay" aria-hidden="true"></div>
  </div>
</header>

<main id="main-content">
