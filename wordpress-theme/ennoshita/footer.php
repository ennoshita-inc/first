</main><!-- /#main-content -->

<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer__inner">

      <div class="footer__brand">
        <?php ennoshita_the_logo('footer__logo'); ?>
        <p class="footer__description">
          人・職場・組織を支えるコンサルティング会社。<br>
          多様な学びの場を提供し、リーダーの心技体を育みます。
        </p>
      </div>

      <div class="footer__column">
        <h3 class="footer__heading">サービス</h3>
        <?php if (has_nav_menu('footer-1')) : ?>
          <?php wp_nav_menu([
            'theme_location' => 'footer-1',
            'container'      => false,
            'menu_class'     => 'footer__nav',
            'depth'          => 1,
          ]); ?>
        <?php else : ?>
          <ul class="footer__nav">
            <li><a href="<?php echo esc_url(home_url('/service/training/')); ?>">人材育成サービス</a></li>
            <li><a href="<?php echo esc_url(home_url('/service/hr-system/')); ?>">人事制度構築支援</a></li>
            <li><a href="<?php echo esc_url(home_url('/service/organization/')); ?>">組織開発支援</a></li>
            <li><a href="<?php echo esc_url(home_url('/flow/')); ?>">導入の流れ</a></li>
          </ul>
        <?php endif; ?>
      </div>

      <div class="footer__column">
        <h3 class="footer__heading">企業情報</h3>
        <?php if (has_nav_menu('footer-2')) : ?>
          <?php wp_nav_menu([
            'theme_location' => 'footer-2',
            'container'      => false,
            'menu_class'     => 'footer__nav',
            'depth'          => 1,
          ]); ?>
        <?php else : ?>
          <ul class="footer__nav">
            <li><a href="<?php echo esc_url(home_url('/about/')); ?>">会社概要</a></li>
            <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">コラム</a></li>
            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a></li>
            <li><a href="<?php echo esc_url(home_url('/sitemap/')); ?>">サイトマップ</a></li>
          </ul>
        <?php endif; ?>
      </div>

      <div class="footer__column">
        <h3 class="footer__heading">アクセス</h3>
        <dl class="footer__info">
          <dt>所在地</dt>
          <dd><?php echo nl2br(esc_html(get_theme_mod('ennoshita_address', '岡山県岡山市' . "\n" . '磨屋町ビル8階'))); ?></dd>
          <?php
          $phone = get_theme_mod('ennoshita_phone');
          if ($phone) : ?>
            <dt>電話番号</dt>
            <dd><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></dd>
          <?php endif; ?>
          <?php
          $email = get_theme_mod('ennoshita_email');
          if ($email) : ?>
            <dt>メール</dt>
            <dd><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></dd>
          <?php endif; ?>
        </dl>
      </div>

    </div><!-- /.footer__inner -->

    <div class="footer__bottom">
      <p>&copy; <?php echo date('Y'); ?> 株式会社えんのした. All rights reserved.</p>
      <nav class="footer__bottom-nav" aria-label="フッター補足ナビゲーション">
        <a href="<?php echo esc_url(home_url('/privacy/')); ?>">プライバシーポリシー</a>
        <a href="<?php echo esc_url(home_url('/sitemap/')); ?>">サイトマップ</a>
      </nav>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
