<?php
/**
 * 導入事例 個別テンプレート
 */
get_header();

if (have_posts()) : the_post();

$company   = get_post_meta(get_the_ID(), '_cs_company', true);
$industry  = get_post_meta(get_the_ID(), '_cs_industry', true);
$employees = get_post_meta(get_the_ID(), '_cs_employees', true);
$duration  = get_post_meta(get_the_ID(), '_cs_duration', true);
$service   = get_post_meta(get_the_ID(), '_cs_service', true);
$challenge = get_post_meta(get_the_ID(), '_cs_challenge', true);
$solution  = get_post_meta(get_the_ID(), '_cs_solution', true);
$result    = get_post_meta(get_the_ID(), '_cs_result', true);
$quote     = get_post_meta(get_the_ID(), '_cs_quote', true);
$role      = get_post_meta(get_the_ID(), '_cs_role', true);
$service_labels = ['training' => '人材育成サービス', 'hr-system' => '人事制度構築支援', 'organization' => '組織開発支援'];
?>

  <div class="page-header">
    <div class="container">
      <p class="page-header__label">Case Study</p>
      <h1 class="page-header__title"><?php echo esc_html($company ?: get_the_title()); ?></h1>
      <?php if ($industry) : ?>
        <p class="page-header__subtitle"><?php echo esc_html($industry); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <section class="section">
    <div class="container container--narrow">
      <!-- 企業情報サマリー -->
      <div class="cs-summary reveal">
        <?php if ($company) : ?>
          <div class="cs-summary__item">
            <span class="cs-summary__label">企業名</span>
            <span class="cs-summary__value"><?php echo esc_html($company); ?></span>
          </div>
        <?php endif; ?>
        <?php if ($employees) : ?>
          <div class="cs-summary__item">
            <span class="cs-summary__label">従業員数</span>
            <span class="cs-summary__value"><?php echo esc_html($employees); ?></span>
          </div>
        <?php endif; ?>
        <?php if ($duration) : ?>
          <div class="cs-summary__item">
            <span class="cs-summary__label">支援期間</span>
            <span class="cs-summary__value"><?php echo esc_html($duration); ?></span>
          </div>
        <?php endif; ?>
        <?php if ($service && isset($service_labels[$service])) : ?>
          <div class="cs-summary__item">
            <span class="cs-summary__label">サービス</span>
            <span class="cs-summary__value"><?php echo esc_html($service_labels[$service]); ?></span>
          </div>
        <?php endif; ?>
      </div>

      <!-- 課題→施策→成果 -->
      <?php if ($challenge) : ?>
      <div class="cs-detail reveal">
        <h2 class="cs-detail__heading">
          <?php echo ennoshita_icon('arrow-right', 20); ?>
          課題
        </h2>
        <p><?php echo nl2br(esc_html($challenge)); ?></p>
      </div>
      <?php endif; ?>

      <?php if ($solution) : ?>
      <div class="cs-detail reveal">
        <h2 class="cs-detail__heading">
          <?php echo ennoshita_icon('arrow-right', 20); ?>
          実施内容
        </h2>
        <p><?php echo nl2br(esc_html($solution)); ?></p>
      </div>
      <?php endif; ?>

      <?php if ($result) : ?>
      <div class="cs-detail cs-detail--result reveal">
        <h2 class="cs-detail__heading">
          <?php echo ennoshita_icon('arrow-right', 20); ?>
          成果
        </h2>
        <p><?php echo nl2br(esc_html($result)); ?></p>
      </div>
      <?php endif; ?>

      <!-- お客様の声 -->
      <?php if ($quote) : ?>
      <blockquote class="cs-quote reveal">
        <?php echo ennoshita_icon('quote', 32); ?>
        <p><?php echo nl2br(esc_html($quote)); ?></p>
        <?php if ($role) : ?>
          <cite><?php echo esc_html($company); ?> <?php echo esc_html($role); ?></cite>
        <?php endif; ?>
      </blockquote>
      <?php endif; ?>

      <!-- 本文 -->
      <?php
      $content = get_the_content();
      if (trim($content)) :
      ?>
      <div class="entry-content reveal">
        <?php the_content(); ?>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php
endif;
get_footer();
?>
