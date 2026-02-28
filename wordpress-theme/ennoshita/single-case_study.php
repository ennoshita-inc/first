<?php
/**
 * 実績事例 個別テンプレート
 */
get_header();

if (have_posts()) : the_post();

$company   = get_post_meta(get_the_ID(), '_cs_company', true);
$industry  = get_post_meta(get_the_ID(), '_cs_industry', true);
$employees = get_post_meta(get_the_ID(), '_cs_employees', true);
$service   = get_post_meta(get_the_ID(), '_cs_service', true);
$duration  = get_post_meta(get_the_ID(), '_cs_duration', true);
$challenge = get_post_meta(get_the_ID(), '_cs_challenge', true);
$solution  = get_post_meta(get_the_ID(), '_cs_solution', true);
$result    = get_post_meta(get_the_ID(), '_cs_result', true);
$quote     = get_post_meta(get_the_ID(), '_cs_quote', true);
$role      = get_post_meta(get_the_ID(), '_cs_role', true);

$service_labels = [
  'training'     => '人材育成サービス',
  'hr-system'    => '人事制度構築支援',
  'organization' => '組織開発支援',
];
?>

  <div class="page-header">
    <div class="container">
      <p class="page-header__label">Case Study</p>
      <h1 class="page-header__title"><?php the_title(); ?></h1>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <article class="section">
    <div class="container container--narrow">

      <!-- 事例メタ情報 -->
      <div class="case-study-meta reveal">
        <?php if ($company) : ?>
          <span class="case-study-meta__item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            <?php echo esc_html($company); ?>
          </span>
        <?php endif; ?>
        <?php if ($industry) : ?>
          <span class="case-study-meta__item"><?php echo esc_html($industry); ?></span>
        <?php endif; ?>
        <?php if ($employees) : ?>
          <span class="case-study-meta__item">従業員 <?php echo esc_html($employees); ?></span>
        <?php endif; ?>
        <?php if ($service && isset($service_labels[$service])) : ?>
          <span class="case-study-meta__item"><?php echo esc_html($service_labels[$service]); ?></span>
        <?php endif; ?>
        <?php if ($duration) : ?>
          <span class="case-study-meta__item">支援期間: <?php echo esc_html($duration); ?></span>
        <?php endif; ?>
      </div>

      <!-- Before/After 形式のケーススタディ -->
      <div class="service-case reveal">
        <?php if ($challenge) : ?>
          <div class="service-case__block" style="margin-bottom: var(--space-lg);">
            <h4 class="service-case__label">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
              課題
            </h4>
            <p><?php echo nl2br(esc_html($challenge)); ?></p>
          </div>
        <?php endif; ?>
        <?php if ($solution) : ?>
          <div class="service-case__block" style="margin-bottom: var(--space-lg);">
            <h4 class="service-case__label">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
              実施内容
            </h4>
            <p><?php echo nl2br(esc_html($solution)); ?></p>
          </div>
        <?php endif; ?>
        <?php if ($result) : ?>
          <div class="service-case__block service-case__block--highlight" style="margin-bottom: var(--space-lg);">
            <h4 class="service-case__label">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              成果
            </h4>
            <p><?php echo nl2br(esc_html($result)); ?></p>
          </div>
        <?php endif; ?>
        <?php if ($quote) : ?>
          <div class="service-case__quote">
            <svg class="service-case__quote-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/></svg>
            <blockquote>
              <p><?php echo esc_html($quote); ?></p>
              <?php if ($role) : ?>
                <footer>— <?php echo esc_html($role); ?></footer>
              <?php endif; ?>
            </blockquote>
          </div>
        <?php endif; ?>
      </div>

      <!-- 本文（追加コンテンツ） -->
      <?php
      $content = get_the_content();
      if (trim($content)) :
      ?>
        <div class="entry-content" style="margin-top: var(--space-2xl);">
          <?php the_content(); ?>
        </div>
      <?php endif; ?>

    </div>
  </article>

  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php
endif;
get_footer();
?>
