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
 * 7. 導入事例（case_study CPT カルーセル）
 * 8. よくあるご質問（FAQ）
 * 9. 関連コラム記事（サービス別フィルタリング）
 * 10. 本文エリア（the_content — 補足用）
 * 11. その他のサービス
 * 12. 導入の流れ
 * 14. CTA
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

// 導入事例: case_study CPTからクエリ
$case_studies = [];
$cs_query = new WP_Query([
    'post_type'      => 'case_study',
    'posts_per_page' => 10,
    'meta_query'     => [
        [
            'key'   => '_cs_service',
            'value' => $current_slug,
        ],
    ],
    'orderby' => 'date',
    'order'   => 'DESC',
]);
if ($cs_query->have_posts()) {
    while ($cs_query->have_posts()) {
        $cs_query->the_post();
        $cs_id = get_the_ID();
        $case_studies[] = [
            'company'   => get_post_meta($cs_id, '_cs_company', true),
            'industry'  => get_post_meta($cs_id, '_cs_industry', true),
            'employees' => get_post_meta($cs_id, '_cs_employees', true),
            'duration'  => get_post_meta($cs_id, '_cs_duration', true),
            'challenge' => get_post_meta($cs_id, '_cs_challenge', true),
            'solution'  => get_post_meta($cs_id, '_cs_solution', true),
            'result'    => get_post_meta($cs_id, '_cs_result', true),
            'quote'     => get_post_meta($cs_id, '_cs_quote', true),
            'role'      => get_post_meta($cs_id, '_cs_role', true),
        ];
    }
    wp_reset_postdata();
    rewind_posts();
    the_post();
}

// CPTに事例がない場合、サンプルデータの事例を使用
if (empty($case_studies) && $using_sample_data) {
    $sample = ennoshita_get_service_sample_data($current_slug);
    if ($sample && !empty($sample['case_studies'])) {
        $case_studies = $sample['case_studies'];
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

  <!-- 8. 導入事例（case_study CPT カルーセル） -->
  <?php if ($case_studies) : ?>
  <section class="section section--gray" aria-labelledby="service-case-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Case Study</p>
        <h2 class="section-header__title" id="service-case-title">導入事例</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <div class="carousel reveal" data-carousel>
        <div class="carousel-track">
          <?php foreach ($case_studies as $cs) : ?>
            <div class="carousel-slide">
              <div class="v11-case-card">
                <div class="v11-case-header">
                  <h3 class="v11-case-company"><?php echo esc_html($cs['company']); ?>
                    <?php if (!empty($cs['employees'])) : ?>
                      （従業員<?php echo esc_html($cs['employees']); ?>）
                    <?php endif; ?>
                  </h3>
                  <?php if (!empty($cs['industry'])) : ?>
                    <span class="v11-case-tag"><?php echo esc_html($cs['industry']); ?></span>
                  <?php endif; ?>
                </div>
                <div class="v11-case-detail">
                  <?php if (!empty($cs['challenge'])) : ?>
                    <div>
                      <div class="v11-case-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        課題
                      </div>
                      <p class="v11-case-block-text"><?php echo nl2br(esc_html($cs['challenge'])); ?></p>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($cs['solution'])) : ?>
                    <div>
                      <div class="v11-case-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        実施内容
                      </div>
                      <p class="v11-case-block-text"><?php echo nl2br(esc_html($cs['solution'])); ?></p>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($cs['result'])) : ?>
                    <div>
                      <div class="v11-case-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        成果
                      </div>
                      <p class="v11-case-block-text"><?php echo nl2br(esc_html($cs['result'])); ?></p>
                    </div>
                  <?php endif; ?>
                </div>
                <?php if (!empty($cs['quote'])) : ?>
                  <div class="v11-case-quote">
                    <svg class="v11-case-quote-icon" width="28" height="28" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/></svg>
                    <blockquote>
                      <p><?php echo esc_html($cs['quote']); ?></p>
                      <?php if (!empty($cs['role'])) : ?>
                        <cite>— <?php echo esc_html($cs['role']); ?></cite>
                      <?php endif; ?>
                    </blockquote>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <?php if (count($case_studies) > 1) : ?>
          <div class="carousel-nav">
            <button class="carousel-arrow carousel-prev" aria-label="前の事例">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="carousel-dots">
              <?php for ($i = 0; $i < count($case_studies); $i++) : ?>
                <button class="carousel-dot<?php echo $i === 0 ? ' active' : ''; ?>" aria-label="事例 <?php echo $i + 1; ?>"></button>
              <?php endfor; ?>
            </div>
            <button class="carousel-arrow carousel-next" aria-label="次の事例">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 9. よくあるご質問 -->
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

  <!-- 10. 関連コラム記事 -->
  <?php
  // まず関連サービスが設定された記事を優先表示
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

  // 関連記事がない場合は最新記事をフォールバック表示
  if (!$related_posts->have_posts()) {
      $related_posts = new WP_Query([
          'posts_per_page' => 3,
          'post_status'    => 'publish',
          'orderby'        => 'date',
          'order'          => 'DESC',
      ]);
  }
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

  <!-- 12. その他のサービス -->
  <?php get_template_part('template-parts/section', 'other-services'); ?>

  <!-- 13. 導入の流れ -->
  <?php get_template_part('template-parts/section', 'process', ['id' => 'process-title-service']); ?>

  <!-- 14. CTA -->
  <?php get_template_part('template-parts/section', 'cta'); ?>

<?php
endif;
get_footer();


/**
 * サンプルデータ関数
 * カスタムフィールドが空の場合に表示するデモデータ
 */
function ennoshita_get_service_sample_data($slug) {
    $data = [
        'training' => [
            'number'         => 'SERVICE 01',
            'overview'       => "「教える」から「変わる」へ。行動変容に直結する研修を。\n\n次世代リーダーの育成から新入社員の基礎力強化まで、貴社の人材課題に合わせたカスタマイズ型の研修プログラムを提供します。座学だけでなく、実践演習・グループワーク・振り返りセッションを組み合わせた設計が特長です。",
            'targets'        => "管理職のマネジメント力・リーダーシップを強化したい\n新入社員・若手社員の早期戦力化を図りたい\n社内の1on1ミーティングの質を向上させたい\nMBTIなどを活用してチーム理解を深めたい\n研修を実施しても「やりっぱなし」で終わってしまう\n外部の専門家による客観的な視点を取り入れたい",
            'programs'       => "管理職リーダーシップ研修|部下育成・チーム運営・目標管理の実践スキルを体系的に習得。ケーススタディとロールプレイで即実践できる力を養います。|2日間（集合研修）|管理職・課長クラス\n新入社員ビジネス基礎研修|社会人としてのマインドセット・ビジネスマナー・報連相・タイムマネジメントを短期集中で習得。|3日間|新入社員\nMBTIチームビルディング研修|MBTI性格検査を活用し、自己理解と他者理解を深めます。チームの多様性を強みに変えるワークショップ。|1日間|全社員・チーム単位\n1on1ミーティング実践講座|効果的な1on1の進め方、傾聴スキル、フィードバック技法を実践的に学びます。|半日（3時間）|管理職\n目標管理（MBO/OKR）導入研修|組織の目標を個人の行動に落とし込む目標管理の設計と運用を学びます。|1日間|管理職・人事担当者",
            'outcomes'       => "管理職が部下の成長を「自分ごと」として捉えるようになり、チーム全体の生産性が平均15%向上。「チームの雰囲気が明らかに変わった」という声が多数。\n「1on1が楽しみになった」という声が続出。実施率は90%以上に定着し、上司への信頼感が大幅に改善。形骸化しない対話の文化が根付きます。\n若手が「この会社で成長できる」と実感できる環境が生まれ、3年以内の離職率が業界平均の半分以下に。採用コストの削減にも直結します。\n研修後のアンケートで「仕事への意欲が高まった」と回答した社員が8割超。エンゲージメントスコアは20ポイント向上し、組織全体の活力が蘇ります。",
            'case_studies'   => [
                [
                    'company'   => '製造業 A社様',
                    'industry'  => '管理職研修',
                    'employees' => '350名',
                    'duration'  => '6ヶ月',
                    'challenge' => '管理職が「プレイヤー意識」から脱却できず、部下育成が後回しに。若手社員の3年以内離職率が35%に達し、「上が何も教えてくれない」という不満が蔓延していた。',
                    'solution'  => '管理職15名を対象に6ヶ月間のリーダーシップ開発プログラムを実施。月1回の集合研修（計6回）に加え、月2回のオンラインフォローアップで学びの定着を促進。360度フィードバックも導入。',
                    'result'    => '若手離職率が35%→15%に半減。管理職全員が1on1を月2回以上実施するようになり、部下からの信頼度スコアが3.2→4.2に改善。「上司に相談しやすくなった」が全社アンケートで最多回答に。',
                    'quote'     => '研修で学んだことをすぐ現場で試せる設計が良かったです。特に1on1の質が変わり、部下から「相談しやすくなった」と言われるようになりました。',
                    'role'      => '人事部長',
                ],
                [
                    'company'   => 'IT企業 B社様',
                    'industry'  => 'チームビルディング',
                    'employees' => '80名',
                    'duration'  => '2日間',
                    'challenge' => '急成長に伴い中途入社の社員が急増。社内文化の共有が追いつかず、部署間の連携が希薄に。特にエンジニアとビジネス職の間で「壁」ができていた。',
                    'solution'  => '全社員80名を対象に、MBTIチームビルディング研修を実施。4チームに分かれてのワークショップ形式で、相互理解を深めるプログラムを2日間にわたり実施。',
                    'result'    => '「他部署との連携がスムーズになった」と回答した社員が72%。部署横断プロジェクトが前年比3倍に増加。「職場の一体感」スコアが2.8→4.1に大幅改善。',
                    'quote'     => 'エンジニアとビジネス側が「言語が違う」と感じていたのが、MBTIを通じて「考え方が違うだけ」と理解できました。今では気軽に相談し合える関係です。',
                    'role'      => '代表取締役',
                ],
                [
                    'company'   => 'サービス業 C社様',
                    'industry'  => '新入社員研修',
                    'employees' => '1,200名',
                    'duration'  => '3日間+3ヶ月フォロー',
                    'challenge' => '新入社員の早期離職が深刻で、入社1年以内の離職率が28%に。OJTに依存した育成体制で、配属先により教育の質にばらつきがあった。',
                    'solution'  => '新入社員60名を対象に3日間のビジネス基礎研修を実施。さらに配属後3ヶ月間、月1回のフォローアップ研修とメンター制度を組み合わせた継続支援プログラムを展開。',
                    'result'    => '入社1年以内の離職率が28%→12%に激減。「自信を持って仕事に取り組める」という回答が34%→91%に上昇。上司からも「例年より即戦力になるのが早い」との評価。',
                    'quote'     => '今までは「見て覚えろ」文化でしたが、体系的な研修のおかげで新入社員が自信を持って仕事に臨めるようになりました。メンター制度との組み合わせも効果的でした。',
                    'role'      => '人材開発課長',
                ],
            ],
            'faq'            => "研修の最少催行人数は？|5名様から対応可能です。少人数だからこそ一人ひとりに寄り添った密度の濃い研修が実現できます。\nオンラインでも実施できますか？|はい。Zoom等を活用したオンライン研修に対応しています。集合研修とオンラインを組み合わせたハイブリッド形式も可能です。\nカリキュラムのカスタマイズは可能ですか？|すべての研修はヒアリング結果に基づき、貴社の課題・業界特性に合わせてカスタマイズします。パッケージの押し売りは一切いたしません。\n研修後のフォローアップはありますか？|はい。研修後1〜3ヶ月のフォローアップ期間を設け、行動計画の進捗確認と追加サポートを行います。「やりっぱなし」にしません。\n費用の目安を教えてください|プログラム内容・期間・人数により異なります。まずはお気軽にお問い合わせください。ヒアリング後にお見積りをご提示いたします。\n岡山県外でも対応可能ですか？|はい。全国対応しています。オンライン研修であれば場所の制約はありません。対面研修の場合は別途交通費をご相談させていただきます。",
        ],
        'hr-system' => [
            'number'         => 'SERVICE 02',
            'overview'       => "「作って終わり」にしない。運用定着まで伴走する人事制度構築。\n\n評価制度・等級制度・報酬制度を一体的に設計し、社員が納得して働ける人事制度を構築します。経営戦略と連動した制度設計により、社員の成長と組織の成果が両立する仕組みを実現します。",
            'targets'        => "人事評価が属人的で、社員の不満が蓄積している\n等級制度が形骸化し、キャリアパスが見えない\n賃金テーブルが古く、採用競争力が低下している\n人事制度を刷新したいが、何から手をつければいいかわからない\n制度を作ったが現場で運用されていない\n中途採用者と既存社員の処遇バランスが取れていない",
            'programs'       => "人事制度グランドデザイン設計|経営理念・ビジョンから逆算し、等級・評価・報酬制度の全体像を設計します。|2〜3ヶ月|経営陣・人事部門\n評価制度構築|職種・等級に応じた評価基準を策定。目標管理制度（MBO）やコンピテンシー評価を組み合わせて設計。|2〜3ヶ月|人事部門・各部門長\n等級・キャリアパス設計|社員の成長段階を可視化する等級フレームワークと、明確なキャリアパスを構築します。|1〜2ヶ月|人事部門\n報酬制度（賃金テーブル）設計|市場水準・社内公平性を考慮した賃金テーブルを設計。シミュレーションで移行コストも算出。|1〜2ヶ月|経営陣・人事部門\n制度運用サポート|評価者研修・目標設定研修・制度説明会の実施。運用開始後のPDCA伴走支援。|3〜6ヶ月|全社",
            'outcomes'       => "社員の評価に対する「なぜこの評価なのか」が明確になり、納得度スコアが平均1.5ポイント向上。不満を起点とした離職が大幅に減少します。\n等級・キャリアパスが可視化されることで「次に何を目指せばいいか」が明確に。社員の目標意識と成長意欲が格段に高まります。\n市場水準を踏まえた賃金テーブルにより、採用オファーの承諾率が20%以上改善。「この会社で働きたい」と思える処遇が実現します。\n評価の属人性を排除し、「誰が評価しても同じ基準」で運用できる公平な仕組みに。評価者の負担も軽減されます。",
            'case_studies'   => [
                [
                    'company'   => 'IT企業 B社様',
                    'industry'  => '人事制度構築',
                    'employees' => '180名',
                    'duration'  => '8ヶ月',
                    'challenge' => '創業10年で急成長したが、人事制度が追いついていなかった。評価基準が曖昧で上司の主観に依存しており、「なぜこの評価なのか」という社員の不満が離職につながっていた。',
                    'solution'  => '全社員へのアンケートと部門長インタビューを実施し、課題を可視化。6ヶ月かけて等級制度・評価制度・報酬制度を一体的に再設計。評価者研修を全管理職に実施し、新制度への移行をサポート。',
                    'result'    => '制度導入後の社員満足度調査で「評価の納得感」スコアが3.8点→4.5点（5点満点）に向上。離職率が18%→8%に改善。新制度により中途採用のオファー承諾率も向上。',
                    'quote'     => '社員一人ひとりの声を丁寧にヒアリングしてくれたことで、「押しつけの制度」ではなく「自分たちの制度」という納得感が生まれました。運用開始後のフォローも心強かったです。',
                    'role'      => '取締役 管理本部長',
                ],
                [
                    'company'   => '製造業 D社様',
                    'industry'  => '評価制度改定',
                    'employees' => '420名',
                    'duration'  => '10ヶ月',
                    'challenge' => '30年以上前に作られた年功序列型の人事制度が残っており、若手の優秀な人材が「頑張っても報われない」と感じて離職するケースが増加。中途採用でも給与面で競合他社に負けていた。',
                    'solution'  => '経営陣との戦略ワークショップから開始し、「成果と行動の両面で評価する」新方針を策定。職種別の等級定義を作成し、市場水準を踏まえた新賃金テーブルを設計。全管理職30名への評価者研修も実施。',
                    'result'    => '若手の離職率が22%→9%に改善。中途採用のオファー承諾率が55%→78%に上昇。「キャリアの見通しが立つようになった」という声が社員アンケートで最多回答に。',
                    'quote'     => '「年功序列を壊す」というと現場の反発が心配でしたが、丁寧な説明会と段階的な移行のおかげで、むしろベテラン社員からも「これなら納得できる」という声をいただきました。',
                    'role'      => '人事部長',
                ],
                [
                    'company'   => '小売業 E社様',
                    'industry'  => '等級・報酬制度',
                    'employees' => '95名',
                    'duration'  => '5ヶ月',
                    'challenge' => '創業者の属人的な評価で運営されてきたが、社員数が100名に迫り限界に。「何をすれば昇格できるのか」が不明確で、社員のモチベーション低下が顕著だった。',
                    'solution'  => '経営理念に基づく5段階の等級フレームワークを構築。各等級に求められる能力・行動を明文化し、昇格要件を明確化。シンプルで運用しやすい評価シートも同時に開発。',
                    'result'    => '「キャリアの道筋が見えるようになった」と回答した社員が85%。次期リーダー候補の自薦が前年比4倍に増加。評価面談の満足度も3.1→4.3に向上。',
                    'quote'     => '100名未満の会社にも合った、シンプルで分かりやすい制度を作ってもらえました。経営者として評価の「基準」ができたことで、自信を持ってフィードバックできるようになりました。',
                    'role'      => '代表取締役',
                ],
            ],
            'faq'            => "人事制度の構築にはどれくらいの期間がかかりますか？|規模や範囲によりますが、基本設計から運用開始まで6〜12ヶ月が目安です。段階的な導入も可能です。\n小規模企業（50名以下）でも対応可能ですか？|はい。企業規模に合わせたシンプルで運用しやすい制度を設計します。過度に複雑な制度は提案しません。\n既存の制度を完全に変える必要がありますか？|いいえ。現行制度の良い部分は活かしつつ、課題のある部分だけを改善する「部分改定」も対応可能です。\n社員への説明はどうすればよいですか？|制度説明会の企画・実施もサポートします。社員の不安を解消し、新制度への理解と納得を得られるよう丁寧に進めます。\n運用開始後のサポートはありますか？|はい。運用開始後3〜6ヶ月の伴走支援期間を設け、評価運用のモニタリング・改善提案を行います。",
        ],
        'organization' => [
            'number'         => 'SERVICE 03',
            'overview'       => "「教える」ではなく「引き出す」。自走する組織をつくる。\n\n部署間の壁を越えた対話を促進し、自律的に課題を解決できる組織づくりを支援します。ダニエル・キム氏の「成功の循環モデル」に基づき、チームの関係性の質を高めることで、思考の質・行動の質・結果の質が連鎖的に向上するアプローチを採用しています。",
            'targets'        => "部署間のコミュニケーションが不足し、サイロ化が進んでいる\n会議で本音が出ず、表面的な議論や報告で終わってしまう\n経営理念やビジョンが現場に浸透していない\nチームの心理的安全性が低く、挑戦や提案が生まれにくい\n組織変革を進めたいが、現場の抵抗や温度差が大きい\n経営層と現場社員の間に認識のギャップがある\n合併・統合後の組織文化の融合に課題を感じている",
            'programs'       => "組織診断・課題可視化|組織サーベイ（エンゲージメント調査）と個別インタビューを通じて、組織の「見えない課題」を構造的に可視化。数値データと定性データの両面から現状を分析し、優先テーマを特定。|2〜3週間|経営陣・人事部門\nビジョン浸透ワークショップ|経営層と社員が対話を通じて企業理念・ビジョンを「自分ごと化」するワークショップ。一方的な伝達ではなく、社員自身が言葉にすることで腹落ちする設計。|1日間|全社員・部門単位\nチームコーチング|チームの関係性の質を高め、自律的な課題解決力を養うチーム単位のコーチングプログラム。実際の業務課題をテーマに扱うため、学びがそのまま成果につながります。|3〜6ヶ月（月1〜2回）|チーム・部門単位\n組織変革プロジェクト伴走|経営戦略の転換や組織再編など、大規模な変革プロジェクトのファシリテーション。キーパーソンの巻き込みから合意形成、実行フォローまで一貫して伴走。|6ヶ月〜1年|経営陣・プロジェクトチーム\n心理的安全性向上プログラム|Googleの「プロジェクト・アリストテレス」の研究知見をベースに、心理的安全性の高いチームづくりを支援。「建設的に衝突できる」チームを目指します。|3ヶ月|チーム・部門単位",
            'outcomes'       => "部署間の連携が強化され、部門横断プロジェクトの意思決定スピードが40%向上。「壁がなくなった」という声が各部門から上がるようになります。\n会議で建設的な議論ができるようになり、自発的な改善提案が前年比3倍に増加。「言いたいことが言える」から「建設的に議論できる」チームへ成長します。\n社員エンゲージメントスコアが導入前比で25ポイント以上向上。「この会社のビジョンを自分の言葉で説明できる」と答えた社員が32%→78%に改善。\n社内ファシリテーターが育成され、外部支援がなくても自走できる組織体制が構築。「依存」ではなく「自立」がゴールです。",
            'case_studies'   => [
                [
                    'company'   => 'サービス業 C社様',
                    'industry'  => '組織開発',
                    'employees' => '500名',
                    'duration'  => '9ヶ月',
                    'challenge' => '3つの事業部がそれぞれ独立して動いており、部署間の連携がほとんど取れていなかった。全社的なビジョンが浸透しておらず、「うちの部署には関係ない」という空気が蔓延。',
                    'solution'  => '全社組織サーベイと各部門キーパーソン20名へのインタビューで課題を構造化。経営層と中核メンバーによるビジョン共有ワークショップを計3回実施し、部門横断プロジェクトチームを組成。6ヶ月間のチームコーチングで連携の仕組みを構築。',
                    'result'    => '部門横断プロジェクトが定着し、新サービスの企画から提供開始までのリードタイムが40%短縮。エンゲージメントスコアが62点→87点に大幅向上。社内ファシリテーター8名が育成され、自走的な対話の場が定着。',
                    'quote'     => '正直、最初は「また外部のコンサルか」という冷ややかな反応でした。しかし、一人ひとりの声を丁寧に聴いてくださったことで信頼関係が生まれ、今では部署間の壁が本当に薄くなりました。',
                    'role'      => '経営企画部長',
                ],
                [
                    'company'   => '建設業 F社様',
                    'industry'  => 'ビジョン浸透',
                    'employees' => '230名',
                    'duration'  => '4ヶ月',
                    'challenge' => '世代交代を控え、創業家の経営理念が次世代に伝わっていなかった。「理念は額に飾ってあるだけ」という状態で、現場の行動指針として機能していなかった。',
                    'solution'  => '経営層と各世代の代表者によるビジョン対話ワークショップを4回実施。理念を「自分の言葉」に翻訳する作業を通じて、全社員が共感できる行動指針を共同作成。各部門での浸透ミーティングも支援。',
                    'result'    => '「理念を自分の仕事に結びつけて考えられる」と回答した社員が18%→72%に向上。新卒採用説明会でも社員が自分の言葉で理念を語れるようになり、応募者数が1.5倍に増加。',
                    'quote'     => '「理念経営」と言いながら形骸化していたことを痛感しました。ワークショップを通じて若手社員から出てきた言葉に、私自身が感動して涙が出ました。',
                    'role'      => '代表取締役社長',
                ],
                [
                    'company'   => '医療法人 G様',
                    'industry'  => '心理的安全性',
                    'employees' => '320名',
                    'duration'  => '6ヶ月',
                    'challenge' => '医療現場特有の厳格なヒエラルキーにより、若手スタッフが意見を言えない雰囲気が蔓延。インシデント報告が上がらず、患者安全の面でもリスクを抱えていた。',
                    'solution'  => '各病棟の看護師長・主任を対象に心理的安全性向上プログラムを実施。「失敗を責めない文化」の醸成と、建設的フィードバックの実践トレーニングを6ヶ月間継続。',
                    'result'    => 'インシデント・ヒヤリハット報告件数が2.5倍に増加（隠れていた報告が表面化）。離職率が15%→7%に半減。「職場で安心して意見が言える」スコアが3.0→4.4に向上。',
                    'quote'     => '「報告が増える＝問題が増える」ではなく「安心して報告できるようになった」証拠だと理解できました。スタッフの表情が明るくなったのが何より嬉しいです。',
                    'role'      => '看護部長',
                ],
            ],
            'faq'            => "組織開発とは具体的に何をするのですか？|組織の「関係性の質」を高めることで、チームの対話・協働・自律性を促進するアプローチです。ワークショップ、チームコーチング、ファシリテーション等の手法を組み合わせて実施します。\n効果が出るまでどれくらいかかりますか？|組織の規模や課題の深さによりますが、3〜6ヶ月で変化の兆しが見え始め、1年で定着するケースが多いです。\n社員の反発が心配です。大丈夫でしょうか？|変革には一定の抵抗が伴いますが、「押しつけ」ではなく「対話」を通じて進めるため、社員自身が当事者として参加する設計にしています。\n経営層だけでなく現場も巻き込めますか？|はい。むしろ現場の巻き込みが成功の鍵です。経営層のコミットメントと現場の主体性、両方を引き出すプログラム設計を行います。\nオンラインでも組織開発は可能ですか？|はい。オンラインワークショップやバーチャルチームコーチングの実績があります。対面とオンラインを組み合わせたハイブリッド形式も効果的です。\n他のコンサルティング会社との違いは何ですか？|私たちは「答えを持ち込む」のではなく「答えを引き出す」アプローチを大切にしています。「依存」ではなく「自立」がゴールです。",
        ],
    ];

    return isset($data[$slug]) ? $data[$slug] : null;
}
?>
