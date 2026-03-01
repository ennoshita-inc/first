<?php
/**
 * Template Name: 会社概要ページ
 *
 * セクション構成:
 * 1. ページヘッダー（ダークグラデーション）
 * 2. パンくず
 * 3. 理念セクション（Philosophy）
 * 4. ミッション＆ビジョン（Mission）
 * 5. 企業情報テーブル（Company）
 * 6. 本文エリア（the_content — 補足用）
 * 7. 代表メッセージ（Message）
 * 8. チーム紹介（Team）
 * 9. CTA
 */
get_header();

if (have_posts()) : the_post();
?>

  <!-- 1. ページヘッダー -->
  <div class="page-header">
    <div class="container">
      <p class="page-header__label">About Us</p>
      <h1 class="page-header__title">会社概要</h1>
      <p class="page-header__subtitle">人・職場・組織を支え、リーダーの心技体を育む</p>
    </div>
  </div>

  <!-- 2. パンくず -->
  <?php ennoshita_breadcrumb(); ?>

  <!-- 3. 理念セクション -->
  <section class="section" aria-labelledby="philosophy-title">
    <div class="container">
      <div class="philosophy__inner">
        <div class="philosophy__image reveal reveal--left">
          <?php
          $philosophy_img = get_theme_mod('ennoshita_philosophy_image');
          $philosophy_img_url = $philosophy_img ? $philosophy_img : get_template_directory_uri() . '/assets/images/philosophy.svg';
          ?>
          <img src="<?php echo esc_url($philosophy_img_url); ?>"
               alt="えんのしたの理念" width="540" height="405" loading="lazy">
        </div>
        <div class="philosophy__text reveal reveal--right">
          <p class="section-header__label">Philosophy</p>
          <h2 class="philosophy__heading" id="philosophy-title">
            人・職場・組織を支え、<br>リーダーの心技体を育む
          </h2>
          <span class="section-header__line section-header__line--left" aria-hidden="true"></span>
          <p>私たちは「人が変われば組織が変わり、組織が変われば社会が変わる」と信じています。</p>
          <p>多様な学びの場を提供し、次世代のリーダーに必要な「心」「技」「体」を育む。それが、えんのしたの使命です。</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 4. ミッション＆ビジョン -->
  <section class="section section--dark" aria-labelledby="mission-title">
    <div class="container container--narrow">
      <div class="section-header reveal">
        <p class="section-header__label">Mission</p>
        <h2 class="section-header__title" id="mission-title">私たちの使命</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <div class="v11-outcomes reveal">
        <div class="v11-outcome">
          <div class="v11-outcome-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          </div>
          <p class="v11-outcome-text">人が変われば組織が変わり、組織が変われば社会が変わる。一人ひとりの可能性を信じ、組織の成長に伴走します。</p>
        </div>
        <div class="v11-outcome">
          <div class="v11-outcome-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <p class="v11-outcome-text">多様な学びの場を提供し、次世代のリーダーに必要な「心」「技」「体」を育む。</p>
        </div>
        <div class="v11-outcome">
          <div class="v11-outcome-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/></svg>
          </div>
          <p class="v11-outcome-text">制度だけでなく、人の意識と行動を変えることで、組織の本質的な変革を実現します。</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 5. 企業情報テーブル -->
  <section class="section section--gray" aria-labelledby="company-title">
    <div class="container container--narrow">
      <div class="section-header reveal">
        <p class="section-header__label">Company</p>
        <h2 class="section-header__title" id="company-title">企業情報</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>

      <div class="entry-content reveal">
        <table>
          <tbody>
            <tr><th>会社名</th><td>株式会社えんのした</td></tr>
            <tr><th>設立</th><td>2012年5月1日</td></tr>
            <tr><th>資本金</th><td>300万円</td></tr>
            <tr><th>所在地</th><td><?php echo esc_html(get_theme_mod('ennoshita_address', '岡山県岡山市 磨屋町ビル8階')); ?></td></tr>
            <tr><th>事業内容</th><td>人材育成コンサルティング<br>人事制度構築支援<br>組織開発支援</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- 6. 本文エリア（追加コンテンツ用） -->
  <?php
  $content = get_the_content();
  if ($content) : ?>
  <section class="section" aria-labelledby="additional-content">
    <div class="container container--narrow">
      <div class="entry-content reveal entry-content--spaced">
        <?php the_content(); ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 7. 代表メッセージ -->
  <section class="section section--message" aria-labelledby="about-message-title">
    <div class="container">
      <div class="message__inner">
        <div class="message__image reveal reveal--left">
          <?php
          $rep_photo = get_theme_mod('ennoshita_representative_photo');
          $rep_photo_url = $rep_photo ? $rep_photo : get_template_directory_uri() . '/assets/images/representative.svg';
          ?>
          <img src="<?php echo esc_url($rep_photo_url); ?>"
               alt="代表取締役の写真"
               width="400" height="500" loading="lazy">
        </div>
        <div class="message__text reveal reveal--right">
          <p class="section-header__label">Message</p>
          <h2 class="section-header__title" id="about-message-title">代表メッセージ</h2>
          <span class="section-header__line section-header__line--left" aria-hidden="true"></span>
          <p class="message__lead">
            組織は、制度では変わりません。<br>
            変わるのは、人です。
          </p>
          <p>
            企業の成長を左右するのは外部環境だけではありません。多くの場合、課題は組織の内側にあります。
          </p>
          <p>
            私たちは、仕組みだけを設計する会社ではありません。未来を言語化し、現状とのギャップを整理し、戦略・制度・育成・対話を一貫して組み立てます。
          </p>
          <p class="message__signature">
            <span class="message__position">代表取締役</span>
            <span class="message__name-text">川路 隆志</span>
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- 8. チーム紹介 -->
  <?php
  $team_query = new WP_Query([
    'post_type'      => 'team_member',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
  ]);

  if ($team_query->have_posts()) :
  ?>
  <section class="section section--gray" aria-labelledby="team-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Team</p>
        <h2 class="section-header__title" id="team-title">チーム紹介</h2>
        <span class="section-header__line" aria-hidden="true"></span>
        <p class="section-header__description">経験豊富なコンサルタントが、貴社の課題に真摯に向き合います。</p>
      </div>

      <div class="team-grid">
        <?php while ($team_query->have_posts()) : $team_query->the_post();
          $position  = get_post_meta(get_the_ID(), '_team_position', true);
          $specialty = get_post_meta(get_the_ID(), '_team_specialty', true);
        ?>
          <div class="team-card reveal">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('thumbnail', ['class' => 'team-card__photo']); ?>
            <?php else : ?>
              <div class="team-card__photo-placeholder" aria-hidden="true">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              </div>
            <?php endif; ?>
            <h3 class="team-card__name"><?php the_title(); ?></h3>
            <?php if ($position) : ?>
              <p class="team-card__position"><?php echo esc_html($position); ?></p>
            <?php endif; ?>
            <?php if ($specialty) : ?>
              <p class="team-card__specialty"><?php echo esc_html($specialty); ?></p>
            <?php endif; ?>
            <?php if (has_excerpt()) : ?>
              <p class="team-card__bio"><?php echo esc_html(get_the_excerpt()); ?></p>
            <?php endif; ?>
          </div>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 9. CTA -->
  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php
endif;
get_footer();
?>
