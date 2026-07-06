<?php
/**
 * 導入事例アーカイブテンプレート
 *
 * - 導入事例CPTの投稿があれば先頭に表示
 * - 続けて、各サービスページと同じデータソース（inc/service-data.php）の
 *   導入事例をサービス別に一覧表示する
 */
get_header();
?>

  <div class="page-header">
    <div class="container">
      <p class="page-header__label">Case Studies</p>
      <h1 class="page-header__title">導入事例</h1>
      <p class="page-header__subtitle">実際にサービスを導入いただいた企業様の事例を、サービス別にご紹介します。</p>
    </div>
  </div>

  <?php ennoshita_breadcrumb(); ?>

  <?php if (have_posts()) : ?>
  <section class="section">
    <div class="container">
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
    </div>
  </section>
  <?php endif; ?>

  <div class="container">
    <p style="color: var(--color-text-muted); font-size: 0.9rem; padding: 24px 0 0;">
      ※守秘義務保護のため、企業名は業種による匿名表記としています。詳細はお問い合わせの際にご確認いただけます。
    </p>
  </div>

  <?php
  // サービス別導入事例（各サービスページと同じデータソースを使用）
  $service_defs = [
    ['key' => 'training',     'url' => '/service/training/'],
    ['key' => 'hr-system',    'url' => '/service/hr-system/'],
    ['key' => 'organization', 'url' => '/service/organization/'],
  ];
  $services_meta = [];
  foreach (ennoshita_get_services() as $svc) {
    $services_meta[$svc['slug']] = $svc;
  }
  foreach ($service_defs as $idx => $def) :
    $sample = ennoshita_get_service_sample_data($def['key']);
    if (empty($sample['case_studies'])) {
      continue;
    }
    $meta       = isset($services_meta[$def['url']]) ? $services_meta[$def['url']] : null;
    $label      = $meta ? $meta['number'] : '';
    $heading    = $meta ? $meta['subtitle'] : $def['key'];
    $section_id = 'cases-' . $def['key'];
  ?>
  <section class="section<?php echo ($idx % 2 === 0) ? ' section--gray' : ''; ?>" aria-labelledby="<?php echo esc_attr($section_id); ?>">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label"><?php echo esc_html($label); ?></p>
        <h2 class="section-header__title" id="<?php echo esc_attr($section_id); ?>"><?php echo esc_html($heading); ?>の導入事例</h2>
        <span class="section-header__line" aria-hidden="true"></span>
        <?php if ($meta) : ?>
          <p class="section-header__description"><?php echo esc_html($meta['text']); ?></p>
        <?php endif; ?>
      </div>

      <div class="case-studies">
        <?php foreach ($sample['case_studies'] as $i => $case) : ?>
        <article class="case-study reveal reveal--delay-<?php echo min($i + 1, 3); ?>">
          <div class="case-study__header">
            <div class="case-study__company-info">
              <h3 class="case-study__company"><?php echo esc_html($case['company']); ?></h3>
              <div class="case-study__tags">
                <?php if (!empty($case['industry'])) : ?>
                  <span class="case-study__tag"><?php echo esc_html($case['industry']); ?></span>
                <?php endif; ?>
                <?php if (!empty($case['employees'])) : ?>
                  <span class="case-study__tag">従業員 <?php echo esc_html($case['employees']); ?></span>
                <?php endif; ?>
                <?php if (!empty($case['duration'])) : ?>
                  <span class="case-study__tag">期間: <?php echo esc_html($case['duration']); ?></span>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="case-study__body">
            <div class="case-study__section">
              <h4 class="case-study__label">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                課題
              </h4>
              <p><?php echo esc_html($case['challenge']); ?></p>
            </div>

            <div class="case-study__section">
              <h4 class="case-study__label">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                実施内容
              </h4>
              <p><?php echo esc_html($case['solution']); ?></p>
            </div>

            <div class="case-study__section case-study__section--result">
              <h4 class="case-study__label">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                成果
              </h4>
              <p><?php echo esc_html($case['result']); ?></p>
            </div>
          </div>

          <?php if (!empty($case['quote'])) : ?>
          <blockquote class="case-study__quote">
            <svg class="case-study__quote-icon" viewBox="0 0 24 24" fill="currentColor" width="24" height="24" aria-hidden="true"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/></svg>
            <p><?php echo esc_html($case['quote']); ?></p>
            <?php if (!empty($case['role'])) : ?>
              <cite class="case-study__cite"><?php echo esc_html($case['company']); ?> <?php echo esc_html($case['role']); ?></cite>
            <?php endif; ?>
          </blockquote>
          <?php endif; ?>
        </article>
        <?php endforeach; ?>
      </div>

      <div style="text-align:center; margin-top: 32px;">
        <a href="<?php echo esc_url(home_url($def['url'])); ?>" class="btn btn--primary">
          <?php echo esc_html($heading); ?>の詳細を見る
          <svg class="btn__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </section>
  <?php endforeach; ?>

  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php get_footer(); ?>
