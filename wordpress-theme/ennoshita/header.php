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

<div class="page-loading" aria-hidden="true">
  <div class="page-loading__spinner"></div>
</div>

<a class="skip-link" href="#main-content">メインコンテンツへスキップ</a>

<header class="site-header" role="banner">
  <div class="container site-header__inner">
    <?php ennoshita_the_logo(); ?>

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
          'depth'          => 1,
        ]); ?>
      <?php else : ?>
        <ul class="main-nav__list">
          <li><a href="<?php echo esc_url(home_url('/about/')); ?>" class="main-nav__link">会社概要</a></li>
          <li><a href="<?php echo esc_url(home_url('/#services')); ?>" class="main-nav__link">サービス</a></li>
          <li><a href="<?php echo esc_url(home_url('/blog/')); ?>" class="main-nav__link">コラム</a></li>
          <li><a href="<?php echo esc_url(home_url('/#process')); ?>" class="main-nav__link">導入の流れ</a></li>
          <li><a href="<?php echo esc_url(home_url('/contact/')); ?>" class="main-nav__contact">お問い合わせ</a></li>
        </ul>
      <?php endif; ?>
    </nav>

    <div class="nav-overlay" aria-hidden="true"></div>
  </div>
</header>

<main id="main-content">
