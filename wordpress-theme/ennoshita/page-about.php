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
  <?php get_template_part('template-parts/section', 'philosophy', ['context' => 'about']); ?>

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
            <?php $phone = get_theme_mod('ennoshita_phone'); if ($phone) : ?>
            <tr>
              <th>電話番号</th>
              <td><?php echo esc_html($phone); ?></td>
            </tr>
            <?php endif; ?>
            <tr>
              <th>事業内容</th>
              <td>
                <ul class="about-info__list">
                  <li>人材育成サービス</li>
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
        <p class="section-header__description">業種・規模を問わず、多くの企業様の組織課題に向き合ってきました。</p>
      </div>

      <div class="about-clients reveal">
        <div class="about-clients__grid">
          <div class="about-clients__category">
            <h3 class="about-clients__category-title">製造業</h3>
            <ul class="about-clients__list">
              <li>大手自動車部品メーカー様</li>
              <li>精密機器メーカー様</li>
              <li>食品製造メーカー様</li>
            </ul>
          </div>
          <div class="about-clients__category">
            <h3 class="about-clients__category-title">サービス業</h3>
            <ul class="about-clients__list">
              <li>総合病院・医療法人様</li>
              <li>大手小売チェーン様</li>
              <li>ホテル・観光業様</li>
            </ul>
          </div>
          <div class="about-clients__category">
            <h3 class="about-clients__category-title">IT・その他</h3>
            <ul class="about-clients__list">
              <li>ITソリューション企業様</li>
              <li>建設・不動産企業様</li>
              <li>地方自治体・公共団体様</li>
            </ul>
          </div>
        </div>
        <p class="about-clients__note">※ 守秘義務の関係上、企業名は非公開とさせていただいております。</p>
      </div>
    </div>
  </section>

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
              src="https://maps.google.com/maps?q=岡山県岡山市北区磨屋町10-20+磨屋町ビル&z=16&output=embed"
              width="100%" height="100%" style="border:0; min-height: 300px;" allowfullscreen="" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              title="株式会社えんのした所在地"></iframe>
          </div>
          <div class="about-access__info">
            <h3 class="about-access__company">株式会社えんのした</h3>
            <dl class="about-access__details">
              <dt>交通アクセス</dt>
              <dd>JR岡山駅 東口より徒歩約10分<br>岡電「郵便局前」電停より徒歩約1分</dd>
              <dt>駐車場</dt>
              <dd>専用駐車場はございません。<br>お近くのコインパーキングをご利用ください。</dd>
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
