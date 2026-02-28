<?php
/**
 * 実績事例アーカイブテンプレート
 */
get_header();
?>

  <div class="page-header">
    <div class="container">
      <p class="page-header__label">Case Studies</p>
      <h1 class="page-header__title">実績事例</h1>
      <p class="page-header__subtitle">えんのしたがこれまでに支援した企業様の事例をご紹介します。</p>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <div class="archive-content">
    <div class="container">
      <?php if (have_posts()) : ?>
        <div class="blog__grid">
          <?php while (have_posts()) : the_post();
            $company  = get_post_meta(get_the_ID(), '_cs_company', true);
            $industry = get_post_meta(get_the_ID(), '_cs_industry', true);
            $service  = get_post_meta(get_the_ID(), '_cs_service', true);

            $service_labels = [
              'training'     => '人材育成サービス',
              'hr-system'    => '人事制度構築支援',
              'organization' => '組織開発支援',
            ];
          ?>
            <article class="case-study-card reveal">
              <?php if ($service && isset($service_labels[$service])) : ?>
                <p class="case-study-card__label"><?php echo esc_html($service_labels[$service]); ?></p>
              <?php endif; ?>
              <h2 class="case-study-card__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              </h2>
              <?php if ($company) : ?>
                <p class="case-study-card__company"><?php echo esc_html($company); ?><?php echo $industry ? ' / ' . esc_html($industry) : ''; ?></p>
              <?php endif; ?>
              <?php if (has_excerpt()) : ?>
                <p class="case-study-card__excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
              <?php endif; ?>
              <a href="<?php the_permalink(); ?>" class="service-card__link">
                詳しく見る
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
              </a>
            </article>
          <?php endwhile; ?>
        </div>

        <?php the_posts_pagination([
          'mid_size'  => 2,
          'prev_text' => '&laquo;',
          'next_text' => '&raquo;',
        ]); ?>
      <?php else : ?>
        <p class="blog__empty">実績事例を準備中です。</p>
      <?php endif; ?>
    </div>
  </div>

  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php get_footer(); ?>
