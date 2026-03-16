<?php
/**
 * Template Name: サービス詳細ページ
 *
 * パターン11「Gradient Flow」デザイン v6.0
 *
 * セクション構成:
 * 1. ページヘッダー（ダークグラデーション）
 * 2. パンくず
 * 3. サービス概要（2カラムグリッド + 特長アイコン）
 * 4. こんな企業様におすすめ（グラデーションアイコンカード）
 * 5. 提供プログラム（CPT or カスタムフィールド / アクセントバー付きカード）
 * 6. 導入効果・期待される成果（ダークセクション / 定性的+定量的表現）
 * 7. よくあるご質問（FAQ）
 * 8. 関連コラム記事（サービス別フィルタリング）
 * 9. 本文エリア（the_content — 補足用）
 * 10. その他のサービス
 * 11. 導入の流れ
 * 12. CTA
 */
get_header();

if (have_posts()) : the_post();

// カスタムフィールド取得
$service_number   = get_post_meta(get_the_ID(), '_service_number', true);
$overview         = get_post_meta(get_the_ID(), '_service_overview', true);
$targets_raw      = get_post_meta(get_the_ID(), '_service_targets', true);
$programs_raw     = get_post_meta(get_the_ID(), '_service_programs', true);
$outcomes_raw     = get_post_meta(get_the_ID(), '_service_outcomes', true);
$faq_raw          = get_post_meta(get_the_ID(), '_service_faq', true);

// フォールバック: カスタムフィールドが未入力の場合、サンプルデータを使用
$current_slug = basename(untrailingslashit(get_permalink()));
$using_sample_data = false;

$case_studies = [];

if (!$overview) {
    $sample_data = ennoshita_get_service_sample_data($current_slug);
    if ($sample_data) {
        $using_sample_data = true;
        $service_number   = $sample_data['number'];
        $overview         = $sample_data['overview'];
        $targets_raw      = $sample_data['targets'];
        $programs_raw     = $sample_data['programs'];
        $outcomes_raw     = $sample_data['outcomes'];
        $faq_raw          = $sample_data['faq'];
        if (!empty($sample_data['case_studies'])) {
            $case_studies = $sample_data['case_studies'];
        }
    }
}

// データ整形
$targets  = $targets_raw ? array_filter(array_map('trim', explode("\n", $targets_raw))) : [];
$outcomes = $outcomes_raw ? array_filter(array_map('trim', explode("\n", $outcomes_raw))) : [];

// プログラム: まずCPTからクエリ、なければカスタムフィールド/サンプルデータを使用
$programs = [];
$programs_from_cpt = false;
$program_query = new WP_Query([
    'post_type'      => 'service_program',
    'posts_per_page' => -1,
    'meta_key'       => '_prog_order',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
    'meta_query'     => [
        [
            'key'   => '_prog_service',
            'value' => $current_slug,
        ],
    ],
]);
if ($program_query->have_posts()) {
    $programs_from_cpt = true;
    while ($program_query->have_posts()) {
        $program_query->the_post();
        $programs[] = [
            'title'    => get_the_title(),
            'desc'     => wp_strip_all_tags(get_the_content()),
            'duration' => get_post_meta(get_the_ID(), '_prog_duration', true),
            'audience' => get_post_meta(get_the_ID(), '_prog_audience', true),
        ];
    }
    wp_reset_postdata();
    // メインクエリを復元
    rewind_posts();
    the_post();
}
if (!$programs_from_cpt && $programs_raw) {
    foreach (explode("\n", trim($programs_raw)) as $line) {
        $parts = explode('|', trim($line));
        if (count($parts) >= 2) {
            $programs[] = [
                'title'    => trim($parts[0]),
                'desc'     => trim($parts[1]),
                'duration' => isset($parts[2]) ? trim($parts[2]) : '',
                'audience' => isset($parts[3]) ? trim($parts[3]) : '',
            ];
        }
    }
}

$faqs = [];
if ($faq_raw) {
    foreach (explode("\n", trim($faq_raw)) as $line) {
        $parts = explode('|', trim($line), 2);
        if (count($parts) === 2 && trim($parts[0]) && trim($parts[1])) {
            $faqs[] = ['q' => trim($parts[0]), 'a' => trim($parts[1])];
        }
    }
}


// 概要テキストの特長キーワード抽出（overview-features用）
$overview_features = [];
if ($current_slug === 'training') {
    $overview_features = [
        ['icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>', 'text' => 'カスタマイズ設計'],
        ['icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>', 'text' => '実践型プログラム'],
        ['icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>', 'text' => '効果測定'],
        ['icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>', 'text' => 'フォローアップ'],
    ];
} elseif ($current_slug === 'hr-system') {
    $overview_features = [
        ['icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>', 'text' => '制度一体設計'],
        ['icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>', 'text' => '運用定着支援'],
        ['icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>', 'text' => '評価者研修'],
        ['icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>', 'text' => 'シミュレーション'],
    ];
} elseif ($current_slug === 'organization') {
    $overview_features = [
        ['icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>', 'text' => '組織診断'],
        ['icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>', 'text' => '対話ファシリテーション'],
        ['icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>', 'text' => 'チームコーチング'],
        ['icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>', 'text' => '自走化支援'],
    ];
}

// overview の先頭部分（リード文）と残りを分割
$overview_lines = $overview ? preg_split('/\n{2,}/', $overview, 2) : [];
$overview_lead = !empty($overview_lines[0]) ? trim($overview_lines[0]) : '';
$overview_body = !empty($overview_lines[1]) ? trim($overview_lines[1]) : '';

// 成果アイコンSVG
$outcome_icons = [
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>',
    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
];
?>

  <!-- 1. ページヘッダー -->
  <div class="page-header">
    <div class="container">
      <?php if ($service_number) : ?>
        <p class="page-header__label"><?php echo esc_html($service_number); ?></p>
      <?php elseif (has_excerpt()) : ?>
        <p class="page-header__label"><?php echo esc_html(get_the_excerpt()); ?></p>
      <?php endif; ?>
      <h1 class="page-header__title"><?php the_title(); ?></h1>
      <?php if ($overview_lead) : ?>
        <p class="page-header__subtitle"><?php echo esc_html(mb_substr(str_replace("\n", ' ', $overview_lead), 0, 80)); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <!-- 2. パンくず -->
  <?php ennoshita_breadcrumb(); ?>

  <!-- 3. サービス概要（Gradient Flow: 2カラムグリッド） -->
  <?php if ($overview) : ?>
  <section class="section" style="background:linear-gradient(180deg, var(--color-bg-warm), #fff)" aria-labelledby="service-overview-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Overview</p>
        <h2 class="section-header__title" id="service-overview-title">サービス概要</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <div class="v11-overview reveal">
        <div>
          <?php if ($overview_lead) : ?>
            <div class="v11-overview-lead"><?php echo nl2br(esc_html($overview_lead)); ?></div>
          <?php endif; ?>
          <?php if ($overview_body) : ?>
            <p class="v11-overview-text"><?php echo nl2br(esc_html($overview_body)); ?></p>
          <?php endif; ?>
        </div>
        <?php if ($overview_features) : ?>
        <div class="v11-overview-features">
          <?php foreach ($overview_features as $feat) : ?>
            <div class="v11-overview-feat">
              <div class="v11-overview-feat-icon" aria-hidden="true"><?php echo $feat['icon']; ?></div>
              <span class="v11-overview-feat-text"><?php echo esc_html($feat['text']); ?></span>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 4. こんな企業様におすすめ（Gradient Flow: グラデーションアイコン） -->
  <?php if ($targets) : ?>
  <section class="section section--gray" aria-labelledby="service-targets-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">For You</p>
        <h2 class="section-header__title" id="service-targets-title">こんな企業様におすすめ</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <div class="v11-targets reveal">
        <?php foreach ($targets as $target) : ?>
          <div class="v11-target">
            <div class="v11-target-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <span><?php echo esc_html($target); ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 5. 提供プログラム（Gradient Flow: アクセントバー付きカード） -->
  <?php if ($programs) : ?>
  <section class="section" aria-labelledby="service-programs-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Programs</p>
        <h2 class="section-header__title" id="service-programs-title">提供プログラム</h2>
        <span class="section-header__line" aria-hidden="true"></span>
        <p class="section-header__description">貴社の課題に合わせて、最適なプログラムをご提案いたします。</p>
      </div>
      <div class="v11-programs reveal">
        <?php foreach ($programs as $i => $prog) : ?>
          <div class="v11-prog">
            <div class="v11-prog-accent" aria-hidden="true"></div>
            <div class="v11-prog-body">
              <div class="v11-prog-header">
                <h3 class="v11-prog-title"><?php echo esc_html($prog['title']); ?></h3>
                <span class="v11-prog-num" aria-hidden="true"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span>
              </div>
              <p class="v11-prog-desc"><?php echo esc_html($prog['desc']); ?></p>
              <?php if ($prog['duration'] || $prog['audience']) : ?>
                <div class="v11-prog-footer">
                  <?php if ($prog['duration']) : ?>
                    <span class="v11-prog-tag">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                      <?php echo esc_html($prog['duration']); ?>
                    </span>
                  <?php endif; ?>
                  <?php if ($prog['audience']) : ?>
                    <span class="v11-prog-tag">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                      <?php echo esc_html($prog['audience']); ?>
                    </span>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 6. 導入効果・期待される成果（Gradient Flow: ダークセクション + 定性的表現） -->
  <?php if ($outcomes) : ?>
  <section class="section section--dark" aria-labelledby="service-outcomes-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Outcomes</p>
        <h2 class="section-header__title" id="service-outcomes-title">導入効果・期待される成果</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <div class="v11-outcomes reveal">
        <?php foreach ($outcomes as $i => $outcome) : ?>
          <div class="v11-outcome">
            <div class="v11-outcome-icon" aria-hidden="true">
              <?php echo isset($outcome_icons[$i]) ? $outcome_icons[$i] : $outcome_icons[0]; ?>
            </div>
            <p class="v11-outcome-text"><?php
              // 数値部分をハイライト表示: 数字+単位パターンを検出してspanで囲む
              $text = esc_html($outcome);
              $text = preg_replace(
                  '/([\d,]+(?:\.\d+)?(?:\s*[%％ポイント倍件名社時間日ヶ月年万億]+)+)/u',
                  '<span class="v11-outcome-highlight">$1</span>',
                  $text
              );
              echo $text;
            ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 8. よくあるご質問 -->
  <?php if ($faqs) : ?>
  <section class="section" aria-labelledby="service-faq-title">
    <div class="container container--narrow">
      <div class="section-header reveal">
        <p class="section-header__label">FAQ</p>
        <h2 class="section-header__title" id="service-faq-title">よくあるご質問</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <div class="v11-faq reveal">
        <?php foreach ($faqs as $faq) : ?>
          <details class="v11-faq-item">
            <summary class="v11-faq-q">
              <span class="v11-faq-q-badge">Q</span>
              <span><?php echo esc_html($faq['q']); ?></span>
              <svg class="v11-faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </summary>
            <div class="v11-faq-a">
              <p><?php echo nl2br(esc_html($faq['a'])); ?></p>
            </div>
          </details>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 9. 導入事例 -->
  <?php if ($case_studies) : ?>
  <section class="section section--gray" aria-labelledby="service-cases-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Case Studies</p>
        <h2 class="section-header__title" id="service-cases-title">導入事例</h2>
        <span class="section-header__line" aria-hidden="true"></span>
        <p class="section-header__description">実際にサービスを導入いただいた企業様の事例をご紹介します。</p>
      </div>

      <div class="case-studies">
        <?php foreach ($case_studies as $i => $case) : ?>
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
    </div>
  </section>
  <?php endif; ?>

  <!-- 10. 関連コラム記事 -->
  <?php
  // 関連サービスが設定された記事のみ表示（未設定の記事は表示しない）
  $related_posts = new WP_Query([
      'posts_per_page' => 3,
      'post_status'    => 'publish',
      'orderby'        => 'date',
      'order'          => 'DESC',
      'meta_query'     => [
          [
              'key'   => '_related_service',
              'value' => $current_slug,
          ],
      ],
  ]);
  if ($related_posts->have_posts()) :
  ?>
  <section class="section section--gray" aria-labelledby="service-related-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Related</p>
        <h2 class="section-header__title" id="service-related-title">関連コラム</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <div class="blog__grid">
        <?php
        while ($related_posts->have_posts()) :
          $related_posts->the_post();
          get_template_part('template-parts/content', 'card');
        endwhile;
        wp_reset_postdata();
        ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 11. 本文エリア（補足コンテンツ） -->
  <?php
  if (!$using_sample_data) :
      $content = get_the_content();
      if (trim($content)) :
  ?>
  <section class="section">
    <div class="container container--narrow">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </div>
  </section>
  <?php
      endif;
  endif;
  ?>

  <!-- 担当コンサルタント -->
  <?php get_template_part('template-parts/section', 'consultants'); ?>

  <!-- 12. その他のサービス -->
  <?php get_template_part('template-parts/section', 'other-services'); ?>

  <!-- 13. 導入の流れ -->
  <?php get_template_part('template-parts/section', 'process', ['id' => 'process-title-service']); ?>

  <!-- 14. CTA -->
  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php
endif;
get_footer();
