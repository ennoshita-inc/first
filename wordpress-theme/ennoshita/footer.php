  </main><!-- /#main-content -->

  <!-- ===== フッター ===== -->
  <footer class="footer" role="contentinfo">
    <div class="container">
      <div class="footer__inner">
        <div class="footer__about">
          <p class="footer__logo"><?php bloginfo('name'); ?></p>
          <p class="footer__description">
            人・職場・組織を支えるコンサルティング会社。<br>
            多様な学びの場の提供により、リーダーの心技体を育みます。
          </p>
          <address class="footer__address">
            〒700-0XXX 岡山県岡山市 磨屋町ビル8階
          </address>
        </div>

        <div class="footer__nav">
          <p class="footer__heading">サービス</p>
          <?php
          wp_nav_menu([
            'theme_location' => 'footer-1',
            'container'      => false,
            'menu_class'     => 'footer__list',
            'fallback_cb'    => 'ennoshita_footer_service_fallback',
            'depth'          => 1,
          ]);
          ?>
        </div>

        <div class="footer__nav">
          <p class="footer__heading">企業情報</p>
          <?php
          wp_nav_menu([
            'theme_location' => 'footer-2',
            'container'      => false,
            'menu_class'     => 'footer__list',
            'fallback_cb'    => 'ennoshita_footer_company_fallback',
            'depth'          => 1,
          ]);
          ?>
        </div>
      </div>

      <div class="footer__bottom">
        <p>&copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?> All Rights Reserved.</p>
      </div>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>
<?php
/**
 * フッターメニュー未設定時のフォールバック
 */
function ennoshita_footer_service_fallback() {
    echo '<ul class="footer__list">';
    echo '<li><a href="' . esc_url(home_url('/service/training/')) . '">人材育成サービス</a></li>';
    echo '<li><a href="' . esc_url(home_url('/service/hr-system/')) . '">人事制度構築支援</a></li>';
    echo '<li><a href="' . esc_url(home_url('/service/organization/')) . '">組織開発支援</a></li>';
    echo '<li><a href="' . esc_url(home_url('/flow/')) . '">導入の流れ</a></li>';
    echo '</ul>';
}

function ennoshita_footer_company_fallback() {
    echo '<ul class="footer__list">';
    echo '<li><a href="' . esc_url(home_url('/about/')) . '">会社概要</a></li>';
    echo '<li><a href="' . esc_url(home_url('/representative/')) . '">代表者紹介</a></li>';
    echo '<li><a href="' . esc_url(home_url('/blog/')) . '">ブログ</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact/')) . '">お問い合わせ</a></li>';
    echo '<li><a href="' . esc_url(home_url('/privacy/')) . '">プライバシーポリシー</a></li>';
    echo '</ul>';
}
?>
