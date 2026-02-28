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
  <section class="section">
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
          <h2 class="philosophy__heading">
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
  <section class="section section--gray">
    <div class="container container--narrow">
      <div class="section-header reveal">
        <p class="section-header__label">Company</p>
        <h2 class="section-header__title">企業情報</h2>
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

      <!-- ページ本文 (追加コンテンツ用) -->
      <?php
      $content = get_the_content();
      if ($content) : ?>
        <div class="entry-content reveal entry-content--spaced">
          <?php the_content(); ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- チーム紹介 -->
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
  <section class="section" aria-labelledby="team-title">
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

  <!-- CTA -->
  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php
endif;
get_footer();
?>
