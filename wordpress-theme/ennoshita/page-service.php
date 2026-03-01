<?php
/**
 * Template Name: サービス詳細ページ
 *
 * 構造化されたサービス詳細テンプレート v5.0
 *
 * セクション構成:
 * 1. ページヘッダー（ダークグラデーション）
 * 2. パンくず
 * 3. サービス概要（overview）
 * 4. こんな企業様におすすめ（targets）
 * 5. プログラム/メニュー一覧（programs）
 * 6. 導入効果・期待される成果（outcomes）
 * 7. 導入スケジュール（timeline）
 * 8. 導入事例（case study）
 * 9. よくあるご質問（FAQ）
 * 10. 関連コラム記事
 * 11. 本文エリア（the_content — 補足用）
 * 12. その他のサービス
 * 13. 導入の流れ
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
$timeline_raw     = get_post_meta(get_the_ID(), '_service_timeline', true);
$case_company     = get_post_meta(get_the_ID(), '_service_case_company', true);
$case_challenge   = get_post_meta(get_the_ID(), '_service_case_challenge', true);
$case_solution    = get_post_meta(get_the_ID(), '_service_case_solution', true);
$case_result      = get_post_meta(get_the_ID(), '_service_case_result', true);
$case_quote       = get_post_meta(get_the_ID(), '_service_case_quote', true);
$faq_raw          = get_post_meta(get_the_ID(), '_service_faq', true);

// フォールバック: カスタムフィールドが未入力の場合、サンプルデータを使用
// （WordPress管理画面で入力すればこのデータは上書きされます）
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
        $timeline_raw     = $sample_data['timeline'];
        $case_company     = $sample_data['case_company'];
        $case_challenge   = $sample_data['case_challenge'];
        $case_solution    = $sample_data['case_solution'];
        $case_result      = $sample_data['case_result'];
        $case_quote       = $sample_data['case_quote'];
        $faq_raw          = $sample_data['faq'];
    }
}

// データ整形
$targets  = $targets_raw ? array_filter(array_map('trim', explode("\n", $targets_raw))) : [];
$outcomes = $outcomes_raw ? array_filter(array_map('trim', explode("\n", $outcomes_raw))) : [];

$programs = [];
if ($programs_raw) {
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

$timeline = [];
if ($timeline_raw) {
    foreach (explode("\n", trim($timeline_raw)) as $line) {
        $parts = explode('|', trim($line));
        if (count($parts) >= 2) {
            $timeline[] = [
                'phase'    => trim($parts[0]),
                'duration' => trim($parts[1]),
                'content'  => isset($parts[2]) ? trim($parts[2]) : '',
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
      <?php if ($overview) : ?>
        <p class="page-header__subtitle"><?php echo esc_html(mb_substr($overview, 0, 80)); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <!-- 2. パンくず -->
  <?php ennoshita_breadcrumb(); ?>

  <!-- 3. サービス概要 -->
  <?php if ($overview) : ?>
  <section class="section" aria-labelledby="service-overview-title">
    <div class="container container--narrow">
      <div class="section-header reveal">
        <p class="section-header__label">Overview</p>
        <h2 class="section-header__title" id="service-overview-title">サービス概要</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <div class="service-overview reveal">
        <p class="service-overview__text"><?php echo nl2br(esc_html($overview)); ?></p>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 4. こんな企業様におすすめ -->
  <?php if ($targets) : ?>
  <section class="section section--gray" aria-labelledby="service-targets-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">For You</p>
        <h2 class="section-header__title" id="service-targets-title">こんな企業様におすすめ</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <ul class="service-targets reveal">
        <?php foreach ($targets as $i => $target) : ?>
          <li class="service-targets__item reveal--delay-<?php echo min($i + 1, 4); ?>">
            <svg class="service-targets__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
            <span><?php echo esc_html($target); ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>
  <?php endif; ?>

  <!-- 5. プログラム/メニュー一覧 -->
  <?php if ($programs) : ?>
  <section class="section" aria-labelledby="service-programs-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Programs</p>
        <h2 class="section-header__title" id="service-programs-title">提供プログラム</h2>
        <span class="section-header__line" aria-hidden="true"></span>
        <p class="section-header__description">貴社の課題に合わせて、最適なプログラムをご提案いたします。</p>
      </div>
      <div class="service-programs reveal">
        <?php foreach ($programs as $i => $prog) : ?>
          <div class="service-program-card reveal--delay-<?php echo min($i + 1, 4); ?>">
            <div class="service-program-card__header">
              <span class="service-program-card__number"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span>
              <h3 class="service-program-card__title"><?php echo esc_html($prog['title']); ?></h3>
            </div>
            <p class="service-program-card__desc"><?php echo esc_html($prog['desc']); ?></p>
            <?php if ($prog['duration'] || $prog['audience']) : ?>
              <div class="service-program-card__meta">
                <?php if ($prog['duration']) : ?>
                  <span class="service-program-card__tag">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <?php echo esc_html($prog['duration']); ?>
                  </span>
                <?php endif; ?>
                <?php if ($prog['audience']) : ?>
                  <span class="service-program-card__tag">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <?php echo esc_html($prog['audience']); ?>
                  </span>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 6. 導入効果・期待される成果 -->
  <?php if ($outcomes) : ?>
  <section class="section section--dark" aria-labelledby="service-outcomes-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Outcomes</p>
        <h2 class="section-header__title" id="service-outcomes-title">導入効果・期待される成果</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <div class="service-outcomes reveal">
        <?php foreach ($outcomes as $i => $outcome) : ?>
          <div class="service-outcomes__item reveal--delay-<?php echo min($i + 1, 4); ?>">
            <div class="service-outcomes__number"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></div>
            <p class="service-outcomes__text"><?php echo esc_html($outcome); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 7. 導入スケジュール -->
  <?php if ($timeline) : ?>
  <section class="section" aria-labelledby="service-timeline-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Timeline</p>
        <h2 class="section-header__title" id="service-timeline-title">導入スケジュール</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <div class="service-timeline reveal">
        <?php foreach ($timeline as $i => $phase) : ?>
          <div class="service-timeline__phase reveal--delay-<?php echo min($i + 1, 4); ?>">
            <div class="service-timeline__marker">
              <span class="service-timeline__step"><?php echo $i + 1; ?></span>
            </div>
            <div class="service-timeline__body">
              <h3 class="service-timeline__title"><?php echo esc_html($phase['phase']); ?></h3>
              <span class="service-timeline__duration"><?php echo esc_html($phase['duration']); ?></span>
              <?php if ($phase['content']) : ?>
                <p class="service-timeline__content"><?php echo esc_html($phase['content']); ?></p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 8. 導入事例 -->
  <?php if ($case_company) : ?>
  <section class="section section--gray" aria-labelledby="service-case-title">
    <div class="container">
      <div class="section-header reveal">
        <p class="section-header__label">Case Study</p>
        <h2 class="section-header__title" id="service-case-title">導入事例</h2>
        <span class="section-header__line" aria-hidden="true"></span>
      </div>
      <div class="service-case reveal">
        <div class="service-case__header">
          <h3 class="service-case__company"><?php echo esc_html($case_company); ?></h3>
        </div>
        <div class="service-case__grid">
          <?php if ($case_challenge) : ?>
            <div class="service-case__block">
              <h4 class="service-case__label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                課題
              </h4>
              <p><?php echo nl2br(esc_html($case_challenge)); ?></p>
            </div>
          <?php endif; ?>
          <?php if ($case_solution) : ?>
            <div class="service-case__block">
              <h4 class="service-case__label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                実施内容
              </h4>
              <p><?php echo nl2br(esc_html($case_solution)); ?></p>
            </div>
          <?php endif; ?>
          <?php if ($case_result) : ?>
            <div class="service-case__block service-case__block--highlight">
              <h4 class="service-case__label">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                成果
              </h4>
              <p><?php echo nl2br(esc_html($case_result)); ?></p>
            </div>
          <?php endif; ?>
        </div>
        <?php if ($case_quote) : ?>
          <div class="service-case__quote">
            <svg class="service-case__quote-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/></svg>
            <blockquote>
              <p><?php echo esc_html($case_quote); ?></p>
            </blockquote>
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
      <div class="service-faq reveal">
        <?php foreach ($faqs as $faq) : ?>
          <details class="service-faq__item">
            <summary class="service-faq__question">
              <span class="service-faq__q-mark">Q</span>
              <span><?php echo esc_html($faq['q']); ?></span>
              <svg class="service-faq__chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </summary>
            <div class="service-faq__answer">
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
  $related_posts = new WP_Query([
      'posts_per_page' => 3,
      'post_status'    => 'publish',
      'orderby'        => 'date',
      'order'          => 'DESC',
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
  // サンプルデータ使用時は本文エリアを表示しない（旧コンテンツとの重複を防止）
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
            'overview'       => "次世代リーダーの育成から新入社員の基礎力強化まで、貴社の人材課題に合わせたカスタマイズ型の研修プログラムを提供します。\n\n座学だけでなく、実践演習・グループワーク・振り返りセッションを組み合わせた「行動変容」に直結するプログラム設計が特長です。研修後のフォローアップも含め、学びが現場で活きる仕組みを構築します。",
            'targets'        => "管理職のマネジメント力・リーダーシップを強化したい\n新入社員・若手社員の早期戦力化を図りたい\n社内の1on1ミーティングの質を向上させたい\nMBTIなどを活用してチーム理解を深めたい\n研修を実施しても「やりっぱなし」で終わってしまう\n外部の専門家による客観的な視点を取り入れたい",
            'programs'       => "管理職リーダーシップ研修|部下育成・チーム運営・目標管理の実践スキルを体系的に習得。ケーススタディとロールプレイで即実践できる力を養います。|2日間（集合研修）|管理職・課長クラス\n新入社員ビジネス基礎研修|社会人としてのマインドセット・ビジネスマナー・報連相・タイムマネジメントを短期集中で習得。|3日間|新入社員\nMBTIチームビルディング研修|MBTI性格検査を活用し、自己理解と他者理解を深めます。チームの多様性を強みに変えるワークショップ。|1日間|全社員・チーム単位\n1on1ミーティング実践講座|効果的な1on1の進め方、傾聴スキル、フィードバック技法を実践的に学びます。|半日（3時間）|管理職\n目標管理（MBO/OKR）導入研修|組織の目標を個人の行動に落とし込む目標管理の設計と運用を学びます。|1日間|管理職・人事担当者",
            'outcomes'       => "管理職の部下育成スキルが向上し、チームの生産性が平均15%改善\n1on1ミーティングの実施率が90%以上に定着\n新入社員の3年以内離職率が業界平均の半分以下に\n「研修が実務に活きている」と回答した受講者が85%以上\n社員エンゲージメントスコアが導入前比で20ポイント向上",
            'timeline'       => "ヒアリング・課題分析|1〜2週間|現状の人材課題・組織目標をヒアリングし、研修ニーズを明確化\nプログラム設計|2〜3週間|貴社に最適なカリキュラム・教材をカスタマイズ設計\n研修実施|1日〜3日間|集合研修またはオンラインで実施。実践演習を多く取り入れます\nフォローアップ|1〜3ヶ月|研修後の行動計画進捗を確認。必要に応じて追加フォロー研修を実施",
            'case_company'   => '製造業 A社様（従業員350名）',
            'case_challenge' => "管理職が「プレイヤー意識」から脱却できず、部下育成が後回しになっていた。離職率が業界平均を上回り、特に若手社員の3年以内離職率が35%に達していた。",
            'case_solution'  => "管理職15名を対象に、6ヶ月間のリーダーシップ開発プログラムを実施。月1回の集合研修（1on1スキル、フィードバック技法、コーチング基礎）に加え、月2回のオンラインフォローアップで実践の振り返りと改善を繰り返した。",
            'case_result'    => "プログラム終了後1年で、若手社員の離職率が35%→15%に半減。管理職の1on1実施率が100%に。社員満足度調査の「上司との関係性」スコアが4.2点（5点満点）に向上。",
            'case_quote'     => '研修で学んだことをすぐ現場で試せる設計が良かったです。特に1on1の質が変わり、部下から「相談しやすくなった」と言われるようになりました。',
            'faq'            => "研修の最少催行人数は？|5名様から対応可能です。少人数だからこそ一人ひとりに寄り添った密度の濃い研修が実現できます。\nオンラインでも実施できますか？|はい。Zoom等を活用したオンライン研修に対応しています。集合研修とオンラインを組み合わせたハイブリッド形式も可能です。\nカリキュラムのカスタマイズは可能ですか？|すべての研修はヒアリング結果に基づき、貴社の課題・業界特性に合わせてカスタマイズします。パッケージの押し売りは一切いたしません。\n研修後のフォローアップはありますか？|はい。研修後1〜3ヶ月のフォローアップ期間を設け、行動計画の進捗確認と追加サポートを行います。「やりっぱなし」にしません。\n費用の目安を教えてください|プログラム内容・期間・人数により異なります。まずはお気軽にお問い合わせください。ヒアリング後にお見積りをご提示いたします。\n岡山県外でも対応可能ですか？|はい。全国対応しています。オンライン研修であれば場所の制約はありません。対面研修の場合は別途交通費をご相談させていただきます。",
        ],
        'hr-system' => [
            'number'         => 'SERVICE 02',
            'overview'       => "評価制度・等級制度・報酬制度を一体的に設計し、社員が納得して働ける人事制度を構築します。\n\n「制度を作って終わり」ではなく、運用定着まで伴走するのが私たちの特長です。経営戦略と連動した制度設計により、社員の成長と組織の成果が両立する仕組みを実現します。",
            'targets'        => "人事評価が属人的で、社員の不満が蓄積している\n等級制度が形骸化し、キャリアパスが見えない\n賃金テーブルが古く、採用競争力が低下している\n人事制度を刷新したいが、何から手をつければいいかわからない\n制度を作ったが現場で運用されていない\n中途採用者と既存社員の処遇バランスが取れていない",
            'programs'       => "人事制度グランドデザイン設計|経営理念・ビジョンから逆算し、等級・評価・報酬制度の全体像を設計します。|2〜3ヶ月|経営陣・人事部門\n評価制度構築|職種・等級に応じた評価基準を策定。目標管理制度（MBO）やコンピテンシー評価を組み合わせて設計。|2〜3ヶ月|人事部門・各部門長\n等級・キャリアパス設計|社員の成長段階を可視化する等級フレームワークと、明確なキャリアパスを構築します。|1〜2ヶ月|人事部門\n報酬制度（賃金テーブル）設計|市場水準・社内公平性を考慮した賃金テーブルを設計。シミュレーションで移行コストも算出。|1〜2ヶ月|経営陣・人事部門\n制度運用サポート|評価者研修・目標設定研修・制度説明会の実施。運用開始後のPDCA伴走支援。|3〜6ヶ月|全社",
            'outcomes'       => "社員の評価に対する納得度が向上し、エンゲージメントスコアが改善\n等級・キャリアパスが明確になり、社員の目標意識が強化\n賃金の外部競争力が向上し、採用力が強化\n評価の属人性が排除され、公平・透明な人事運用が実現\n人件費の適正配分により、投資対効果が向上",
            'timeline'       => "現状分析・課題整理|2〜3週間|既存制度の分析、社員アンケート・インタビューで課題を可視化\n制度設計（基本方針策定）|1〜2ヶ月|経営戦略と連動した人事制度の基本方針・フレームワークを設計\n詳細設計・シミュレーション|1〜2ヶ月|評価基準・等級定義・賃金テーブルの詳細設計。移行シミュレーション実施\n導入準備・研修|1ヶ月|評価者研修、社員説明会、運用マニュアル整備\n運用開始・伴走支援|3〜6ヶ月|制度運用のモニタリング、改善提案、定着フォローアップ",
            'case_company'   => 'IT企業 B社様（従業員180名）',
            'case_challenge' => "創業10年で急成長したが、人事制度が追いついていなかった。評価基準が曖昧で上司の主観に依存しており、「なぜこの評価なのか」という社員の不満が離職につながっていた。",
            'case_solution'  => "全社員へのアンケートと部門長インタビューを実施し、課題を可視化。6ヶ月かけて等級制度・評価制度・報酬制度を一体的に再設計。評価者研修を全管理職に実施し、新制度への移行をサポート。",
            'case_result'    => "制度導入後の社員満足度調査で「評価の納得感」スコアが3.8点→4.5点（5点満点）に向上。離職率が18%→8%に改善。新制度により中途採用のオファー承諾率も向上。",
            'case_quote'     => '社員一人ひとりの声を丁寧にヒアリングしてくれたことで、「押しつけの制度」ではなく「自分たちの制度」という納得感が生まれました。運用開始後のフォローも心強かったです。',
            'faq'            => "人事制度の構築にはどれくらいの期間がかかりますか？|規模や範囲によりますが、基本設計から運用開始まで6〜12ヶ月が目安です。段階的な導入も可能です。\n小規模企業（50名以下）でも対応可能ですか？|はい。企業規模に合わせたシンプルで運用しやすい制度を設計します。過度に複雑な制度は提案しません。\n既存の制度を完全に変える必要がありますか？|いいえ。現行制度の良い部分は活かしつつ、課題のある部分だけを改善する「部分改定」も対応可能です。\n社員への説明はどうすればよいですか？|制度説明会の企画・実施もサポートします。社員の不安を解消し、新制度への理解と納得を得られるよう丁寧に進めます。\n運用開始後のサポートはありますか？|はい。運用開始後3〜6ヶ月の伴走支援期間を設け、評価運用のモニタリング・改善提案を行います。",
        ],
        'organization' => [
            'number'         => 'SERVICE 03',
            'overview'       => "部署間の壁を越えた対話を促進し、自律的に課題を解決できる組織づくりを支援します。\n\nダニエル・キム氏の「成功の循環モデル」に基づき、チームの関係性の質を高めることで、思考の質・行動の質・結果の質が連鎖的に向上するアプローチを採用。組織サーベイによる現状の可視化から、ワークショップ・ファシリテーション・チームコーチングの実施、そして社内ファシリテーターの育成による自走化まで、一貫して伴走します。\n\n「外部に依存する組織」ではなく、「自ら考え、動ける組織」をつくることが私たちのゴールです。",
            'targets'        => "部署間のコミュニケーションが不足し、サイロ化が進んでいる\n会議で本音が出ず、表面的な議論や報告で終わってしまう\n経営理念やビジョンが現場に浸透していない\nチームの心理的安全性が低く、挑戦や提案が生まれにくい\n組織変革を進めたいが、現場の抵抗や温度差が大きい\n経営層と現場社員の間に認識のギャップがある\n合併・統合後の組織文化の融合に課題を感じている",
            'programs'       => "組織診断・課題可視化|組織サーベイ（エンゲージメント調査）と個別インタビューを通じて、組織の「見えない課題」を構造的に可視化。数値データと定性データの両面から現状を分析し、優先的に取り組むべきテーマを特定します。|2〜3週間|経営陣・人事部門\nビジョン浸透ワークショップ|経営層と社員が対話を通じて企業理念・ビジョンを「自分ごと化」するワークショップ。一方的な伝達ではなく、社員自身が言葉にすることで腹落ちする設計です。|1日間|全社員・部門単位\nチームコーチング|チームの関係性の質を高め、自律的な課題解決力を養うチーム単位のコーチングプログラム。実際の業務課題をテーマに扱うため、学びがそのまま成果につながります。|3〜6ヶ月（月1〜2回）|チーム・部門単位\n組織変革プロジェクト伴走|経営戦略の転換や組織再編など、大規模な変革プロジェクトのファシリテーション。キーパーソンの巻き込みから合意形成、実行フォローまで一貫して伴走します。|6ヶ月〜1年|経営陣・プロジェクトチーム\n心理的安全性向上プログラム|Googleの「プロジェクト・アリストテレス」の研究知見をベースに、心理的安全性の高いチームづくりを支援。「言いたいことが言える」だけでなく「建設的に衝突できる」チームを目指します。|3ヶ月|チーム・部門単位",
            'outcomes'       => "部署間の連携が強化され、プロジェクトの意思決定スピードが向上\n会議で建設的な議論ができるようになり、自発的な改善提案が増加\n社員エンゲージメントスコアが導入前比で25ポイント以上向上\n経営ビジョンの浸透度が大幅に改善し、全社の方向性が統一\n社内ファシリテーターが育ち、自走できる組織体制が構築",
            'timeline'       => "組織診断・現状把握|2〜3週間|組織サーベイ・インタビューを実施し、課題を構造化。優先テーマを特定\nプログラム設計|2〜3週間|診断結果に基づき、貴社の状況に最適なオーダーメイドの支援プログラムを設計\n介入フェーズ（実施）|3〜6ヶ月|ワークショップ・チームコーチング・ファシリテーションを計画的に実施\n定着・自走化支援|1〜3ヶ月|社内ファシリテーターの育成、振り返りの仕組みづくりで組織の自走力を確立",
            'case_company'   => 'サービス業 C社様（従業員500名・3事業部体制）',
            'case_challenge' => "3つの事業部がそれぞれ独立して動いており、部署間の連携がほとんど取れていなかった。全社的なビジョンが浸透しておらず、「うちの部署には関係ない」という空気が蔓延。経営層は危機感を持っていたが、現場との温度差が大きく、過去のトップダウン施策も形骸化していた。",
            'case_solution'  => "まず全社組織サーベイと各部門キーパーソン20名へのインタビューで課題を構造化。その後、経営層と各部門の中核メンバーを集めたビジョン共有ワークショップを計3回実施し、「全社共通の言葉」を醸成。さらに、3つの事業部から横断メンバーを選出したプロジェクトチームを組成し、6ヶ月間のチームコーチングで部門間連携の仕組みを構築した。",
            'case_result'    => "部門横断プロジェクトが定着し、新サービスの企画から提供開始までのリードタイムが40%短縮。社員エンゲージメントスコアが62点→87点に大幅向上。「会社のビジョンを自分の言葉で説明できる」と回答した社員が32%→78%に改善。社内ファシリテーター8名が育成され、自走的な対話の場が各部門で定着。",
            'case_quote'     => '正直、最初は「また外部のコンサルか」という冷ややかな反応でした。しかし、一人ひとりの声を丁寧に聴いてくださったことで徐々に信頼関係が生まれ、「この人たちとなら変われるかもしれない」という空気に変わっていきました。今では部署間の壁が本当に薄くなり、以前は考えられなかった部門横断の自主勉強会まで始まっています。',
            'faq'            => "組織開発とは具体的に何をするのですか？|組織の「関係性の質」を高めることで、チームの対話・協働・自律性を促進するアプローチです。ワークショップ、チームコーチング、ファシリテーション等の手法を組み合わせて実施します。研修のように「教える」のではなく、組織の中から答えを引き出すことが特長です。\n効果が出るまでどれくらいかかりますか？|組織の規模や課題の深さによりますが、3〜6ヶ月で変化の兆しが見え始め、1年で定着するケースが多いです。まずは組織診断で現状を把握し、段階的にアプローチするため、無理なく進められます。\n社員の反発が心配です。大丈夫でしょうか？|変革には一定の抵抗が伴いますが、「押しつけ」ではなく「対話」を通じて進めるため、社員自身が当事者として参加する設計にしています。過去の支援先でも、最初は懐疑的だった方が最終的にプロジェクトの推進役になったケースが多くあります。\n経営層だけでなく現場も巻き込めますか？|はい。むしろ現場の巻き込みが成功の鍵です。経営層のコミットメントと現場の主体性、両方を引き出すプログラム設計を行います。キーパーソンの特定と段階的な巻き込みにより、自然と参加の輪が広がる仕組みをつくります。\nオンラインでも組織開発は可能ですか？|はい。オンラインワークショップやバーチャルチームコーチングの実績があります。対面とオンラインを組み合わせたハイブリッド形式も効果的です。遠方の拠点を含む全社施策にも柔軟に対応できます。\n他のコンサルティング会社との違いは何ですか？|私たちは「答えを持ち込む」のではなく、「答えを引き出す」アプローチを大切にしています。コンサルタントが去った後も組織が自走できるよう、社内ファシリテーターの育成や対話の仕組みづくりまで支援します。「依存」ではなく「自立」がゴールです。",
        ],
    ];

    return isset($data[$slug]) ? $data[$slug] : null;
}
?>
