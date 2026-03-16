<?php
/**
 * 導入事例アーカイブテンプレート
 */
get_header();
?>

  <div class="page-header">
    <div class="container">
      <p class="page-header__label">Case Studies</p>
      <h1 class="page-header__title">導入事例</h1>
      <p class="page-header__subtitle">実際にサービスを導入いただいた企業様の事例をご紹介します。</p>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <section class="section">
    <div class="container">
      <?php if (have_posts()) : ?>
      <div class="case-studies-archive">
        <?php while (have_posts()) : the_post();
          $company   = get_post_meta(get_the_ID(), '_cs_company', true);
          $industry  = get_post_meta(get_the_ID(), '_cs_industry', true);
          $employees = get_post_meta(get_the_ID(), '_cs_employees', true);
          $service   = get_post_meta(get_the_ID(), '_cs_service', true);
          $challenge = get_post_meta(get_the_ID(), '_cs_challenge', true);
          $result    = get_post_meta(get_the_ID(), '_cs_result', true);
        ?>
        <article class="case-study-card reveal">
          <div class="case-study-card__header">
            <h2 class="case-study-card__title">
              <a href="<?php the_permalink(); ?>"><?php echo esc_html($company ?: get_the_title()); ?></a>
            </h2>
            <div class="case-study__tags">
              <?php if ($industry) : ?>
                <span class="case-study__tag"><?php echo esc_html($industry); ?></span>
              <?php endif; ?>
              <?php if ($employees) : ?>
                <span class="case-study__tag">従業員 <?php echo esc_html($employees); ?></span>
              <?php endif; ?>
              <?php if ($service) : ?>
                <span class="case-study__tag"><?php
                  $service_labels = ['training' => '人材育成', 'hr-system' => '人事制度構築', 'organization' => '組織開発'];
                  echo esc_html($service_labels[$service] ?? $service);
                ?></span>
              <?php endif; ?>
            </div>
          </div>
          <?php if ($challenge) : ?>
          <div class="case-study-card__body">
            <p class="case-study-card__challenge"><strong>課題:</strong> <?php echo esc_html(mb_substr($challenge, 0, 120)); ?>…</p>
            <?php if ($result) : ?>
              <p class="case-study-card__result"><strong>成果:</strong> <?php echo esc_html(mb_substr($result, 0, 120)); ?>…</p>
            <?php endif; ?>
          </div>
          <?php endif; ?>
          <a href="<?php the_permalink(); ?>" class="case-study-card__link">
            詳しく見る <?php echo ennoshita_icon('arrow-right', 16); ?>
          </a>
        </article>
        <?php endwhile; ?>
      </div>

      <?php the_posts_pagination([
          'prev_text' => '前へ',
          'next_text' => '次へ',
      ]); ?>

      <?php else : ?>
        <p class="blog__empty">導入事例を準備中です。近日公開予定です。</p>
      <?php endif; ?>
    </div>
  </section>

  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php get_footer(); ?>
