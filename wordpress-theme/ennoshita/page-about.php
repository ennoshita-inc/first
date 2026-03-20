<?php
/**
 * Template Name: 会社概要ページ
 */
get_header();

if (have_posts()) : the_post();
?>

  <div class="page-header">
    <div class="container">
      <h1 class="page-header__title">会社概要</h1>
      <p class="page-header__subtitle">About Us</p>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <!-- 理念セクション -->
  <section class="section" aria-labelledby="philosophy-about-title">
    <div class="container">
      <div class="philosophy__inner">
        <div class="philosophy__image reveal reveal--left">
          <?php
          $philosophy_img = get_theme_mod('ennoshita_philosophy_image');
          $philosophy_img_url = $philosophy_img ? $philosophy_img : get_template_directory_uri() . '/assets/images/hero.jpg';
          ?>
          <img src="<?php echo esc_url($philosophy_img_url); ?>"
               alt="えんのしたの理念" width="540" height="405" loading="lazy">
        </div>
        <div class="philosophy__text reveal reveal--right">
          <p class="section-header__label">Philosophy</p>
          <h2 class="philosophy__heading" id="philosophy-about-title">
            人・職場・組織を支え、<br>リーダーの心技体を育む
          </h2>
          <span class="section-header__line section-header__line--left" aria-hidden="true"></span>
          <p>私たちは「人が変われば組織が変わり、組織が変われば社会が変わる」と信じています。</p>
          <p>多様な学びの場を提供し、次世代のリーダーに必要な「心」「技」「体」を育む。それが、えんのしたの使命です。</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 会社情報テーブル -->
  <section class="section section--gray" aria-labelledby="company-info-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Company</p>
        <h2 class="section-header__title" id="company-info-title">企業情報</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>

      <div class="about-info reveal">
        <table class="about-info__table">
          <tbody>
            <tr>
              <th>会社名</th>
              <td>株式会社えんのした</td>
            </tr>
            <tr>
              <th>英文社名</th>
              <td>Ennoshita Co., Ltd.</td>
            </tr>
            <tr>
              <th>設立</th>
              <td>2012年5月1日</td>
            </tr>
            <tr>
              <th>資本金</th>
              <td>300万円</td>
            </tr>
            <tr>
              <th>代表者</th>
              <td>代表取締役　川路 隆志</td>
            </tr>
            <tr>
              <th>所在地</th>
              <td><?php echo esc_html(get_theme_mod('ennoshita_address', '岡山県岡山市 磨屋町ビル8階')); ?></td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td><?php echo esc_html(get_theme_mod('ennoshita_phone', '086-XXX-XXXX')); ?></td>
            </tr>
            <tr>
              <th>事業内容</th>
              <td>
                <ul class="about-info__list">
                  <li>人材育成コンサルティング</li>
                  <li>人事制度構築支援</li>
                  <li>組織開発支援</li>
                </ul>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- 主要取引先 -->
  <section class="section" aria-labelledby="clients-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Clients</p>
        <h2 class="section-header__title" id="clients-title">主要取引先</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>

      <div class="about-clients reveal">
        <p class="about-clients__note">守秘義務の関係上、企業名の公開は控えさせていただいております。<br>製造業・サービス業・IT・官公庁など、業種・規模を問わず多くの企業・団体様とお取引いただいております。</p>
      </div>
    </div>
  </section>

  <!-- ページ本文 (WordPress追加コンテンツ用) -->
  <?php
  $content = get_the_content();
  if ($content) : ?>
  <section class="section">
    <div class="container">
      <div class="entry-content reveal">
        <?php the_content(); ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- コンサルタント紹介 -->
  <?php get_template_part('template-parts/section', 'consultants'); ?>

  <!-- アクセス -->
  <section class="section section--gray" aria-labelledby="access-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Access</p>
        <h2 class="section-header__title" id="access-title">アクセス</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>

      <div class="about-access reveal">
        <div class="about-access__inner">
          <div class="about-access__map">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3281.5!2d133.93!3d34.66!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z5bKh5bGx5biC!5e0!3m2!1sja!2sjp!4v1"
              width="100%" height="100%" style="border:0; min-height: 300px;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              title="株式会社えんのした所在地"></iframe>
          </div>
          <div class="about-access__info">
            <h3 class="about-access__company">株式会社えんのした</h3>
            <dl class="about-access__details">
              <dt>住所</dt>
              <dd><?php echo esc_html(get_theme_mod('ennoshita_address', '岡山県岡山市 磨屋町ビル8階')); ?></dd>
              <dt>電話</dt>
              <dd><?php echo esc_html(get_theme_mod('ennoshita_phone', '086-XXX-XXXX')); ?></dd>
              <dt>営業時間</dt>
              <dd>平日 9:00 - 18:00（土日祝休み）</dd>
            </dl>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--outline">
              お問い合わせはこちら
              <svg class="btn__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php
endif;
get_footer();
?>
