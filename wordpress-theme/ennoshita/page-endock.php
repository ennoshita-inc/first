<?php
/**
 * Template Name: En-Dock LP
 *
 * 組織活力調査 En-Dock のランディングページ。
 *
 * 既存テーマと完全に統一感を保つため：
 * - get_header() / get_footer() で既存サイトのヘッダー・フッター・グローバルナビをそのまま継承
 * - 既存 style.css の磨かれたコンポーネントをフル活用
 * - LP固有の追加スタイルは lp-endock/lp-endock.css に最小限（.endock- プレフィックス）
 * - 既存 style.css には一切手を加えない
 *
 * 内容構成は説明資料 PDF v2026-03-26 に準拠。
 */

if (!defined('ABSPATH')) { exit; }

$theme_uri      = get_template_directory_uri();
$contact_url    = esc_url(home_url('/contact/'));
$dashboard_url  = esc_url($theme_uri . '/lp-endock/dashboard-sample.html');

// LP固有CSSのみ追加読み込み（既存テーマには影響しない）
add_action('wp_enqueue_scripts', function () use ($theme_uri) {
  wp_enqueue_style(
    'endock-lp',
    $theme_uri . '/lp-endock/lp-endock.css',
    [],
    '3.0.0'
  );
}, 20);

get_header();
?>

<main id="main-content">

<!-- 1. ページヘッダー -->
<div class="page-header">
  <div class="container">
    <p class="page-header__label">Organizational Vitality Survey</p>
    <h1 class="page-header__title">
      組織活力調査 <span class="endock-brand">En-Dock</span>
    </h1>
    <p class="page-header__subtitle">
      組織の「いま」を可視化し、未来への一歩を支援する
    </p>
  </div>
</div>

<!-- 2. パンくず -->
<?php if (function_exists('ennoshita_breadcrumb')) { ennoshita_breadcrumb(); } ?>

<!-- 3. 統計バー -->
<section class="section section--dark" aria-labelledby="endock-stats-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">At a Glance</p>
      <h2 class="section-header__title" id="endock-stats-title">En-Dock を、数字で。</h2>
      <span class="section-header__line" aria-hidden="true"></span>
    </div>
    <div class="trust__grid reveal">
      <div class="trust__item">
        <p class="trust__number" data-count="60">0<small>問</small></p>
        <p class="trust__label">標準設問数</p>
      </div>
      <div class="trust__item">
        <p class="trust__number" data-count="8">0<small>カテゴリ</small></p>
        <p class="trust__label">診断カテゴリ</p>
      </div>
      <div class="trust__item">
        <p class="trust__number" data-count="4">0<small>軸</small></p>
        <p class="trust__label">集計軸</p>
      </div>
      <div class="trust__item">
        <p class="trust__number" data-count="15">0<small>万円〜</small></p>
        <p class="trust__label">導入価格</p>
      </div>
    </div>
    <p class="endock-scale-note">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      <span>30 名規模の中小企業から、複数拠点をもつ中堅企業まで対応可能</span>
    </p>
  </div>
</section>

<!-- 4. なぜ「組織活力」の可視化が必要か -->
<section class="section" aria-labelledby="endock-why-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Why Visualize</p>
      <h2 class="section-header__title" id="endock-why-title">なぜ「組織活力」の可視化が必要か</h2>
      <span class="section-header__line" aria-hidden="true"></span>
      <p class="section-header__description">
        従業員エンゲージメントは、企業の業績・離職率・株価パフォーマンスに直結します。<br>
        「感覚」ではなく「データ」で組織の活力を捉えることが、経営の意思決定を変えます。
      </p>
    </div>

    <ul class="endock-engage reveal">
      <li class="endock-engage__item">
        <div class="endock-engage__num">87<span>%</span></div>
        <div class="endock-engage__label">エンゲージメントが高い<br>企業の<strong>離職率低下</strong></div>
        <div class="endock-engage__source">Gallup社調査</div>
      </li>
      <li class="endock-engage__item">
        <div class="endock-engage__num">21<span>%</span></div>
        <div class="endock-engage__label">エンゲージメントが高い<br>企業の<strong>生産性向上</strong></div>
        <div class="endock-engage__source">Gallup社調査</div>
      </li>
      <li class="endock-engage__item">
        <div class="endock-engage__num">2.5<span>倍</span></div>
        <div class="endock-engage__label">ES高企業の<br><strong>株価パフォーマンス</strong></div>
        <div class="endock-engage__source">ハーバードビジネスレビュー</div>
      </li>
    </ul>

    <div class="endock-herzberg reveal">
      <div class="endock-herzberg__head">
        <span class="endock-herzberg__chip">理論的背景</span>
        <h3>ハーズバーグの二要因理論</h3>
        <p>「衛生要因」の改善で不満を解消し、「動機付け要因」の充実でエンゲージメントを向上させる。<br>En-Dock は両方の要因を網羅的にカバーしています。</p>
      </div>
      <div class="endock-herzberg__cols">
        <div class="endock-herzberg__col endock-herzberg__col--hygiene">
          <div class="endock-herzberg__col-head">
            <span class="endock-herzberg__col-en">Hygiene Factors</span>
            <h4>衛生要因</h4>
            <p>満たされないと不満を生むが、満たされても満足には繋がらない要素</p>
          </div>
          <ul>
            <li><b>A</b> 経営方針・ビジョン</li>
            <li><b>B</b> 職場環境・業務効率</li>
            <li><b>C</b> 上司との関係</li>
            <li><b>E</b> 同僚・対人関係</li>
            <li><b>G</b> 処遇・報酬・福利厚生</li>
          </ul>
          <div class="endock-herzberg__arrow">改善で <strong>不満の解消</strong></div>
        </div>
        <div class="endock-herzberg__col endock-herzberg__col--motivator">
          <div class="endock-herzberg__col-head">
            <span class="endock-herzberg__col-en">Motivation Factors</span>
            <h4>動機付け要因</h4>
            <p>満たされるとエンゲージメントを高める、内発的動機づけの要素</p>
          </div>
          <ul>
            <li><b>D</b> 評価・承認</li>
            <li><b>F</b> 仕事のやりがい・成長</li>
            <li><b>H</b> 自己成長・挑戦</li>
          </ul>
          <div class="endock-herzberg__arrow">充実で <strong>エンゲージメント向上</strong></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 5. このような組織課題はありませんか -->
<section class="section section--gray" aria-labelledby="endock-issues-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Issues</p>
      <h2 class="section-header__title" id="endock-issues-title">このような組織課題はありませんか？</h2>
      <span class="section-header__line" aria-hidden="true"></span>
    </div>

    <div class="endock-issues reveal">
      <article class="endock-issue">
        <h4>離職率の上昇</h4>
        <p>若手・中堅社員の離職が増加し、採用コストが膨らんでいる</p>
      </article>
      <article class="endock-issue">
        <h4>マネジメント機能の低下</h4>
        <p>管理職が部下の声を拾えず、組織に停滞感がある</p>
      </article>
      <article class="endock-issue">
        <h4>エンゲージメントの低迷</h4>
        <p>従業員の主体性が低く、受け身の姿勢が蔓延している</p>
      </article>
      <article class="endock-issue">
        <h4>組織課題が不明確</h4>
        <p>何が問題か見えず、手の打ちようがない状態</p>
      </article>
      <article class="endock-issue">
        <h4>施策の効果が見えない</h4>
        <p>研修や制度改善をしても、効果を定量的に評価できない</p>
      </article>
      <article class="endock-issue">
        <h4>事業承継の不安</h4>
        <p>後継者への引継ぎにあたり、組織状態の客観把握ができていない</p>
      </article>
    </div>

    <div class="endock-issues-bridge reveal">
      <svg width="20" height="32" viewBox="0 0 20 32" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="10" y1="2" x2="10" y2="26"/><polyline points="3,19 10,26 17,19"/></svg>
      <p><strong>En-Dock</strong> で組織の「いま」を可視化し、本質的な課題解決へ</p>
    </div>
  </div>
</section>

<!-- 6. En-Dock とは -->
<section class="section" aria-labelledby="endock-overview-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Overview</p>
      <h2 class="section-header__title" id="endock-overview-title">En-Dock とは</h2>
      <span class="section-header__line" aria-hidden="true"></span>
    </div>
    <div class="v11-overview reveal">
      <div>
        <div class="v11-overview-lead">組織診断から改善施策まで、ワンストップで支援。</div>
        <p class="v11-overview-text">En-Dock は、組織の状態を 8 つのカテゴリ × 4 つの集計軸 × 60 問で多角的に定量化する、えんのしたの組織健診ツールです。ハーズバーグの二要因理論に基づく学術的な設問設計、Googleフォームベースの手軽な実施、インタラクティブなダッシュボード、そして組織開発の専門家による施策提案までを一貫して提供します。<br><br>「やった感」で終わる調査ではなく、調査結果を「行動」に変える伴走支援が、En-Dock の真価です。</p>
      </div>
      <div class="v11-overview-features">
        <div class="v11-overview-feat">
          <div class="v11-overview-feat-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
          </div>
          <span class="v11-overview-feat-text">学術理論に基づく設計</span>
        </div>
        <div class="v11-overview-feat">
          <div class="v11-overview-feat-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <span class="v11-overview-feat-text">直感的ダッシュボード</span>
        </div>
        <div class="v11-overview-feat">
          <div class="v11-overview-feat-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
          </div>
          <span class="v11-overview-feat-text">経年比較で変化を追跡</span>
        </div>
        <div class="v11-overview-feat">
          <div class="v11-overview-feat-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          </div>
          <span class="v11-overview-feat-text">施策実行まで伴走</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 7. En-Dock 5つの特徴 -->
<section class="section section--gray" aria-labelledby="endock-features-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">5 Features</p>
      <h2 class="section-header__title" id="endock-features-title">En-Dock 5 つの特徴</h2>
      <span class="section-header__line" aria-hidden="true"></span>
    </div>

    <ol class="endock-features reveal">
      <li class="endock-feature">
        <span class="endock-feature__num">01</span>
        <div class="endock-feature__body">
          <h3>学術理論に基づく設問設計</h3>
          <p>ハーズバーグの二要因理論をベースに、衛生要因 5 カテゴリ・動機付け要因 3 カテゴリ・60 問を体系的に構成。「何を測っているか」が明確だから、結果の解釈と施策への接続がぶれません。</p>
        </div>
      </li>
      <li class="endock-feature">
        <span class="endock-feature__num">02</span>
        <div class="endock-feature__body">
          <h3>直感的なダッシュボード</h3>
          <p>インタラクティブな分析画面で、経年比較・部門別・カテゴリ別の傾向を即座に把握。レーダー / トレンド / ヒートマップ等の 7 タブで、誰が見ても読み解ける仕上がりです。</p>
        </div>
      </li>
      <li class="endock-feature">
        <span class="endock-feature__num">03</span>
        <div class="endock-feature__body">
          <h3>手軽な導入・短納期</h3>
          <p>Google フォームをベースにした調査システム。専用システムの導入や ID 管理は不要。お打合せから報告まで <strong>約 1 ヶ月</strong>で完了し、最短 2 週間で実施可能です。</p>
        </div>
      </li>
      <li class="endock-feature">
        <span class="endock-feature__num">04</span>
        <div class="endock-feature__body">
          <h3>実績豊富なコンサルタント</h3>
          <p>組織活性化の専門家が結果を読み解き、表面的な数値解説ではなく、経営課題に直結する改善提案を実施。代表自らが対話の場に入る、伴走型の支援です。</p>
        </div>
      </li>
      <li class="endock-feature">
        <span class="endock-feature__num">05</span>
        <div class="endock-feature__body">
          <h3>研修・施策との連動</h3>
          <p>診断で終わらせない。診断結果に基づく管理職育成、チームビルディング、人事制度設計、リーダーシップ研修など、課題に応じた施策をシームレスに提供します。</p>
        </div>
      </li>
    </ol>
  </div>
</section>

<!-- 8. 4軸 × 8カテゴリ図解 -->
<section class="section" aria-labelledby="endock-orbit-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Diagnosis Structure</p>
      <h2 class="section-header__title" id="endock-orbit-title">8 カテゴリ × 4 集計軸で、立体的に診る</h2>
      <span class="section-header__line" aria-hidden="true"></span>
      <p class="section-header__description">
        8 つの評価カテゴリを 4 つの集計軸にマッピングし、組織を多角的に分析します。
      </p>
    </div>

    <div class="endock-orbit reveal" aria-label="4軸×8カテゴリの構造図">
      <svg viewBox="0 0 640 640" class="endock-orbit__svg" role="img" aria-labelledby="orbit-title-svg">
        <title id="orbit-title-svg">組織の活力を、4軸（会社・上司・同僚・仕事）×8カテゴリで診る構造図</title>
        <defs>
          <radialGradient id="orbit-center-grad" cx="50%" cy="50%" r="50%">
            <stop offset="0%"  stop-color="#a03038"/>
            <stop offset="100%" stop-color="#641a1f"/>
          </radialGradient>
          <filter id="orbit-glow" x="-50%" y="-50%" width="200%" height="200%">
            <feGaussianBlur stdDeviation="6" result="blur"/>
            <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
          </filter>
        </defs>

        <circle cx="320" cy="320" r="270" fill="none" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="2 6"/>
        <circle cx="320" cy="320" r="190" fill="none" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="2 6"/>

        <line x1="320" y1="240" x2="320" y2="120" stroke="var(--color-primary-200)" stroke-width="1.5"/>
        <line x1="320" y1="400" x2="320" y2="520" stroke="var(--color-primary-200)" stroke-width="1.5"/>
        <line x1="240" y1="320" x2="120" y2="320" stroke="var(--color-primary-200)" stroke-width="1.5"/>
        <line x1="400" y1="320" x2="520" y2="320" stroke="var(--color-primary-200)" stroke-width="1.5"/>

        <line x1="320" y1="120" x2="220" y2="50" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="2 4"/>
        <line x1="320" y1="120" x2="320" y2="50" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="2 4"/>
        <line x1="320" y1="120" x2="420" y2="50" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="2 4"/>
        <line x1="520" y1="320" x2="600" y2="270" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="2 4"/>
        <line x1="520" y1="320" x2="600" y2="370" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="2 4"/>
        <line x1="320" y1="520" x2="240" y2="595" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="2 4"/>
        <line x1="320" y1="520" x2="400" y2="595" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="2 4"/>
        <line x1="120" y1="320" x2="40"  y2="320" stroke="var(--color-border)" stroke-width="1" stroke-dasharray="2 4"/>

        <circle cx="320" cy="320" r="78" fill="url(#orbit-center-grad)" filter="url(#orbit-glow)"/>
        <circle cx="320" cy="320" r="78" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
        <text x="320" y="313" text-anchor="middle" fill="#fff" font-family="'Noto Serif JP',serif" font-size="20" font-weight="700">組織の</text>
        <text x="320" y="343" text-anchor="middle" fill="#fff" font-family="'Noto Serif JP',serif" font-size="20" font-weight="700">活力</text>

        <g class="endock-orbit__axis">
          <circle cx="320" cy="120" r="48" fill="#fff" stroke="var(--color-primary)" stroke-width="2.5"/>
          <text x="320" y="115" text-anchor="middle" fill="var(--color-primary)" font-family="'Noto Serif JP',serif" font-size="18" font-weight="700">会社</text>
          <text x="320" y="135" text-anchor="middle" fill="var(--color-accent)" font-family="'Inter',sans-serif" font-size="9" font-weight="600" letter-spacing="0.06em">経営・処遇</text>
        </g>
        <g class="endock-orbit__axis">
          <circle cx="520" cy="320" r="48" fill="#fff" stroke="var(--color-primary)" stroke-width="2.5"/>
          <text x="520" y="315" text-anchor="middle" fill="var(--color-primary)" font-family="'Noto Serif JP',serif" font-size="18" font-weight="700">上司</text>
          <text x="520" y="335" text-anchor="middle" fill="var(--color-accent)" font-family="'Inter',sans-serif" font-size="9" font-weight="600" letter-spacing="0.06em">マネジメント</text>
        </g>
        <g class="endock-orbit__axis">
          <circle cx="320" cy="520" r="48" fill="#fff" stroke="var(--color-primary)" stroke-width="2.5"/>
          <text x="320" y="515" text-anchor="middle" fill="var(--color-primary)" font-family="'Noto Serif JP',serif" font-size="18" font-weight="700">同僚</text>
          <text x="320" y="535" text-anchor="middle" fill="var(--color-accent)" font-family="'Inter',sans-serif" font-size="9" font-weight="600" letter-spacing="0.06em">関係性</text>
        </g>
        <g class="endock-orbit__axis">
          <circle cx="120" cy="320" r="48" fill="#fff" stroke="var(--color-primary)" stroke-width="2.5"/>
          <text x="120" y="315" text-anchor="middle" fill="var(--color-primary)" font-family="'Noto Serif JP',serif" font-size="18" font-weight="700">仕事</text>
          <text x="120" y="335" text-anchor="middle" fill="var(--color-accent)" font-family="'Inter',sans-serif" font-size="9" font-weight="600" letter-spacing="0.06em">仕事内容</text>
        </g>

        <g font-family="'Noto Sans JP',sans-serif" font-size="11.5" font-weight="600">
          <g class="endock-orbit__pill">
            <rect x="170" y="32" width="100" height="30" rx="15" fill="#fff" stroke="var(--color-primary-200)" stroke-width="1.5"/>
            <text x="220" y="51" text-anchor="middle" fill="var(--color-primary)">A 経営</text>
          </g>
          <g class="endock-orbit__pill">
            <rect x="270" y="32" width="100" height="30" rx="15" fill="#fff" stroke="var(--color-primary-200)" stroke-width="1.5"/>
            <text x="320" y="51" text-anchor="middle" fill="var(--color-primary)">B 職場</text>
          </g>
          <g class="endock-orbit__pill">
            <rect x="370" y="32" width="100" height="30" rx="15" fill="#fff" stroke="var(--color-primary-200)" stroke-width="1.5"/>
            <text x="420" y="51" text-anchor="middle" fill="var(--color-primary)">G 処遇</text>
          </g>
          <g class="endock-orbit__pill">
            <rect x="540" y="252" width="98" height="30" rx="15" fill="#fff" stroke="var(--color-primary-200)" stroke-width="1.5"/>
            <text x="589" y="271" text-anchor="middle" fill="var(--color-primary)">C 上司</text>
          </g>
          <g class="endock-orbit__pill">
            <rect x="540" y="356" width="98" height="30" rx="15" fill="#fff" stroke="var(--color-primary-200)" stroke-width="1.5"/>
            <text x="589" y="375" text-anchor="middle" fill="var(--color-primary)">D 評価</text>
          </g>
          <g class="endock-orbit__pill">
            <rect x="200" y="580" width="100" height="30" rx="15" fill="#fff" stroke="var(--color-primary-200)" stroke-width="1.5"/>
            <text x="250" y="599" text-anchor="middle" fill="var(--color-primary)">E 同僚</text>
          </g>
          <g class="endock-orbit__pill">
            <rect x="340" y="580" width="100" height="30" rx="15" fill="#fff" stroke="var(--color-primary-200)" stroke-width="1.5"/>
            <text x="390" y="599" text-anchor="middle" fill="var(--color-primary)">F 仕事</text>
          </g>
          <g class="endock-orbit__pill">
            <rect x="2" y="305" width="98" height="30" rx="15" fill="#fff" stroke="var(--color-primary-200)" stroke-width="1.5"/>
            <text x="51" y="324" text-anchor="middle" fill="var(--color-primary)">H 特性</text>
          </g>
        </g>
      </svg>

      <ul class="endock-orbit__legend">
        <li><span class="endock-orbit__key">A</span><b>経営</b><i>衛生</i><em>経営方針・ビジョン・将来性への共感度</em></li>
        <li><span class="endock-orbit__key">B</span><b>職場</b><i>衛生</i><em>職場環境・業務効率・働きやすさ</em></li>
        <li><span class="endock-orbit__key">C</span><b>上司</b><i>衛生</i><em>上司との関係・コミュニケーションの質</em></li>
        <li><span class="endock-orbit__key">D</span><b>評価</b><i>動機</i><em>評価制度の公正性・承認の質</em></li>
        <li><span class="endock-orbit__key">E</span><b>同僚</b><i>衛生</i><em>同僚との関係・チーム内の助け合い</em></li>
        <li><span class="endock-orbit__key">F</span><b>仕事</b><i>動機</i><em>仕事のやりがい・成長実感</em></li>
        <li><span class="endock-orbit__key">G</span><b>処遇</b><i>衛生</i><em>給与・賞与・福利厚生の納得度</em></li>
        <li><span class="endock-orbit__key">H</span><b>特性</b><i>動機</i><em>自己成長機会・新しい挑戦の実感</em></li>
      </ul>
    </div>
  </div>
</section>

<!-- 9. 設問サンプル(5段階評価) -->
<section class="section section--gray" aria-labelledby="endock-sample-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Sample Questions</p>
      <h2 class="section-header__title" id="endock-sample-title">設問サンプル（5 段階評価）</h2>
      <span class="section-header__line" aria-hidden="true"></span>
      <p class="section-header__description">
        各カテゴリから 1 問ずつ。実際の調査では、5 段階リッカートスケールで回答していただきます。
      </p>
    </div>

    <div class="endock-sample reveal">
      <table class="endock-sample__table">
        <thead>
          <tr>
            <th class="endock-sample__cat">カテゴリ</th>
            <th class="endock-sample__q">設問例</th>
            <th class="endock-sample__scale" colspan="5">5 段階評価</th>
          </tr>
          <tr class="endock-sample__scale-head">
            <th></th>
            <th></th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><span class="endock-sample__key">A</span> 経営</td>
            <td>会社の経営方針や計画は社員に十分伝わっている</td>
            <td colspan="5"><div class="endock-sample__radios"><span></span><span></span><span></span><span></span><span></span></div></td>
          </tr>
          <tr>
            <td><span class="endock-sample__key">B</span> 職場</td>
            <td>職場の業務量は適切である</td>
            <td colspan="5"><div class="endock-sample__radios"><span></span><span></span><span></span><span></span><span></span></div></td>
          </tr>
          <tr>
            <td><span class="endock-sample__key">C</span> 上司</td>
            <td>上司は自分の意見や考えを聴いてくれる</td>
            <td colspan="5"><div class="endock-sample__radios"><span></span><span></span><span></span><span></span><span></span></div></td>
          </tr>
          <tr>
            <td><span class="endock-sample__key">D</span> 評価</td>
            <td>自分の仕事に対する評価は公正だと感じる</td>
            <td colspan="5"><div class="endock-sample__radios"><span></span><span></span><span></span><span></span><span></span></div></td>
          </tr>
          <tr>
            <td><span class="endock-sample__key">E</span> 同僚</td>
            <td>困ったとき、同僚は助けてくれる</td>
            <td colspan="5"><div class="endock-sample__radios"><span></span><span></span><span></span><span></span><span></span></div></td>
          </tr>
          <tr>
            <td><span class="endock-sample__key">F</span> 仕事</td>
            <td>今の仕事にやりがいを感じている</td>
            <td colspan="5"><div class="endock-sample__radios"><span></span><span></span><span></span><span></span><span></span></div></td>
          </tr>
          <tr>
            <td><span class="endock-sample__key">G</span> 処遇</td>
            <td>給与・賞与は仕事内容に見合っている</td>
            <td colspan="5"><div class="endock-sample__radios"><span></span><span></span><span></span><span></span><span></span></div></td>
          </tr>
          <tr>
            <td><span class="endock-sample__key">H</span> 特性</td>
            <td>新しいことに挑戦する機会がある</td>
            <td colspan="5"><div class="endock-sample__radios"><span></span><span></span><span></span><span></span><span></span></div></td>
          </tr>
        </tbody>
      </table>
      <div class="endock-sample__foot">
        <span><b>回答形式</b> 5 段階リッカートスケール</span>
        <span><b>回答時間の目安</b> 15〜20 分（60 問版）／ 約 12 分（簡易 40 問版）</span>
      </div>
    </div>

    <div class="endock-design reveal">
      <h3 class="endock-design__title">アンケートの設計</h3>
      <p class="endock-design__sub">属性設問・基本設問・自由記述の <strong>3 部構成</strong></p>
      <ul class="endock-design__cols">
        <li class="endock-design__col">
          <span class="endock-design__num">01</span>
          <h4>属性設問</h4>
          <p class="endock-design__count">部門・職位・年代等<br>（最大 3 問）</p>
          <p class="endock-design__note">御社にて設定</p>
        </li>
        <li class="endock-design__col endock-design__col--accent">
          <span class="endock-design__num">02</span>
          <h4>基本設問</h4>
          <p class="endock-design__count">標準 60 問<br>（簡易版 40 問）</p>
          <p class="endock-design__note">5 段階評価</p>
        </li>
        <li class="endock-design__col">
          <span class="endock-design__num">03</span>
          <h4>自由記述</h4>
          <p class="endock-design__count">記述式<br>（最大 7 問）</p>
          <p class="endock-design__note">御社にて設定可</p>
        </li>
      </ul>
      <p class="endock-design__option">
        <span class="endock-design__option-tag">オプション</span>
        オリジナル設問の追加で、御社独自の課題にフォーカスした調査が可能です。
      </p>
    </div>
  </div>
</section>

<!-- 10. ★ ダッシュボード実物プレビュー -->
<section class="section section--dark" id="dashboard-section" aria-labelledby="endock-dashboard-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Live Preview</p>
      <h2 class="section-header__title" id="endock-dashboard-title">実物のダッシュボードを、ご覧ください</h2>
      <span class="section-header__line" aria-hidden="true"></span>
      <p class="section-header__description">
        以下は、En-Dock が納品するインタラクティブダッシュボードの<strong>サンプル</strong>です。<br>
        7 つのタブを実際にクリックして、レーダーチャート・トレンド・部門別比較などをその場で体験してください。
      </p>
    </div>

    <div class="endock-dashboard-stage reveal">
      <div class="endock-dashboard__badge" aria-hidden="true">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        <span>クリックして 7 つのタブを切り替えてみてください</span>
      </div>
      <div class="endock-dashboard">
        <div class="endock-dashboard__bar" aria-hidden="true">
          <span class="endock-dashboard__dot" style="background:#ff5f57"></span>
          <span class="endock-dashboard__dot" style="background:#febc2e"></span>
          <span class="endock-dashboard__dot" style="background:#28c840"></span>
          <span class="endock-dashboard__url">en-dock-dashboard / sample-company / 2026年度</span>
        </div>
        <iframe class="endock-dashboard__iframe" src="<?php echo $dashboard_url; ?>" title="En-Dock サンプルダッシュボード" loading="lazy"></iframe>
      </div>
      <p class="endock-dashboard__note">
        ※ 上記は架空企業のサンプルデータです。実装ではお客様のデータでこの通りのダッシュボードが納品されます。
        <a href="<?php echo $dashboard_url; ?>" target="_blank" rel="noopener" class="endock-dashboard__open">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          別タブで全画面表示
        </a>
      </p>
    </div>
  </div>
</section>

<!-- 11. 7タブのダッシュボード解説 -->
<section class="section" aria-labelledby="endock-tabs-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Dashboard</p>
      <h2 class="section-header__title" id="endock-tabs-title">7 つのタブで、多角的に分析</h2>
      <span class="section-header__line" aria-hidden="true"></span>
      <p class="section-header__description">
        ダッシュボードは 7 つのタブで構成。経営層・人事・現場、それぞれの視点で組織の状態を読み解けます。
      </p>
    </div>
    <div class="v11-programs reveal">
      <div class="v11-prog endock-tab">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="endock-tab__chart" aria-hidden="true">
            <svg viewBox="0 0 120 60" width="100%" height="100%">
              <rect x="4"  y="6"  width="34" height="22" rx="3" fill="var(--color-primary-50)"/>
              <rect x="42" y="6"  width="34" height="22" rx="3" fill="var(--color-accent-50)"/>
              <rect x="80" y="6"  width="36" height="22" rx="3" fill="var(--color-primary-100)"/>
              <rect x="4"  y="32" width="112" height="6" rx="2" fill="var(--color-primary-200)"/>
              <rect x="4"  y="32" width="74"  height="6" rx="2" fill="var(--color-primary)"/>
              <rect x="4"  y="44" width="112" height="6" rx="2" fill="var(--color-border)"/>
              <rect x="4"  y="44" width="48"  height="6" rx="2" fill="var(--color-accent)"/>
            </svg>
          </div>
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">概要</h3>
            <span class="v11-prog-num">01</span>
          </div>
          <p class="v11-prog-desc">総合スコア、4 軸 KPI、ヒートマップ、年度別成長ストーリーを一覧。経営会議の冒頭資料に最適。</p>
        </div>
      </div>
      <div class="v11-prog endock-tab">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="endock-tab__chart" aria-hidden="true">
            <svg viewBox="0 0 120 60" width="100%" height="100%">
              <g transform="translate(60,30)">
                <polygon points="0,-22 19,-7 12,18 -12,18 -19,-7" fill="none" stroke="var(--color-border)" stroke-width="1"/>
                <polygon points="0,-14 12,-4 8,12 -8,12 -12,-4"   fill="none" stroke="var(--color-border)" stroke-width="1"/>
                <polygon points="0,-18 16,-3 10,16 -11,16 -17,-2" fill="rgba(133,34,40,0.15)" stroke="var(--color-primary)" stroke-width="1.5"/>
                <circle cx="0"  cy="-18" r="2" fill="var(--color-primary)"/>
                <circle cx="16" cy="-3"  r="2" fill="var(--color-primary)"/>
                <circle cx="10" cy="16"  r="2" fill="var(--color-primary)"/>
                <circle cx="-11" cy="16" r="2" fill="var(--color-primary)"/>
                <circle cx="-17" cy="-2" r="2" fill="var(--color-primary)"/>
              </g>
            </svg>
          </div>
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">レーダー</h3>
            <span class="v11-prog-num">02</span>
          </div>
          <p class="v11-prog-desc">4 軸／8 カテゴリのレーダーチャート。年度選択で過去データと比較し、組織の「形」を直感的に把握。</p>
        </div>
      </div>
      <div class="v11-prog endock-tab">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="endock-tab__chart" aria-hidden="true">
            <svg viewBox="0 0 120 60" width="100%" height="100%">
              <line x1="4" y1="50" x2="116" y2="50" stroke="var(--color-border)" stroke-width="1"/>
              <line x1="4" y1="32" x2="116" y2="32" stroke="var(--color-border)" stroke-width="0.5" stroke-dasharray="2 3"/>
              <line x1="4" y1="14" x2="116" y2="14" stroke="var(--color-border)" stroke-width="0.5" stroke-dasharray="2 3"/>
              <polyline points="8,42 30,36 52,30 74,22 96,16 114,8" fill="none" stroke="var(--color-primary)" stroke-width="2"/>
              <polyline points="8,46 30,42 52,40 74,36 96,30 114,24" fill="none" stroke="var(--color-accent)" stroke-width="1.5" stroke-dasharray="3 2"/>
              <circle cx="8" cy="42" r="2.5" fill="var(--color-primary)"/>
              <circle cx="52" cy="30" r="2.5" fill="var(--color-primary)"/>
              <circle cx="114" cy="8" r="2.5" fill="var(--color-primary)"/>
            </svg>
          </div>
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">トレンド</h3>
            <span class="v11-prog-num">03</span>
          </div>
          <p class="v11-prog-desc">折れ線グラフで 5 年間の推移を可視化。どの軸が伸びているか、成長率の変化はどうか一目瞭然。</p>
        </div>
      </div>
      <div class="v11-prog endock-tab">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="endock-tab__chart" aria-hidden="true">
            <svg viewBox="0 0 120 60" width="100%" height="100%">
              <rect x="4"  y="6"  width="112" height="6" rx="2" fill="var(--color-border)"/>
              <rect x="4"  y="6"  width="92"  height="6" rx="2" fill="var(--color-primary)"/>
              <rect x="4"  y="18" width="112" height="6" rx="2" fill="var(--color-border)"/>
              <rect x="4"  y="18" width="64"  height="6" rx="2" fill="var(--color-primary)"/>
              <rect x="4"  y="30" width="112" height="6" rx="2" fill="var(--color-border)"/>
              <rect x="4"  y="30" width="78"  height="6" rx="2" fill="var(--color-accent)"/>
              <rect x="4"  y="42" width="112" height="6" rx="2" fill="var(--color-border)"/>
              <rect x="4"  y="42" width="40"  height="6" rx="2" fill="var(--color-primary)"/>
            </svg>
          </div>
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">カテゴリ詳細</h3>
            <span class="v11-prog-num">04</span>
          </div>
          <p class="v11-prog-desc">8 カテゴリそれぞれのスコアと 5 年間の変化量を表示。重点的に改善すべき領域を特定。</p>
        </div>
      </div>
      <div class="v11-prog endock-tab">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="endock-tab__chart" aria-hidden="true">
            <svg viewBox="0 0 120 60" width="100%" height="100%">
              <rect x="4"   y="6"  width="22" height="14" rx="2" fill="rgba(133,34,40,0.85)"/>
              <rect x="28"  y="6"  width="22" height="14" rx="2" fill="rgba(133,34,40,0.55)"/>
              <rect x="52"  y="6"  width="22" height="14" rx="2" fill="rgba(133,34,40,0.30)"/>
              <rect x="76"  y="6"  width="22" height="14" rx="2" fill="rgba(196,154,42,0.65)"/>
              <rect x="100" y="6"  width="16" height="14" rx="2" fill="rgba(133,34,40,0.20)"/>
              <rect x="4"   y="22" width="22" height="14" rx="2" fill="rgba(133,34,40,0.40)"/>
              <rect x="28"  y="22" width="22" height="14" rx="2" fill="rgba(133,34,40,0.75)"/>
              <rect x="52"  y="22" width="22" height="14" rx="2" fill="rgba(196,154,42,0.50)"/>
              <rect x="76"  y="22" width="22" height="14" rx="2" fill="rgba(133,34,40,0.60)"/>
              <rect x="100" y="22" width="16" height="14" rx="2" fill="rgba(133,34,40,0.35)"/>
              <rect x="4"   y="38" width="22" height="14" rx="2" fill="rgba(196,154,42,0.45)"/>
              <rect x="28"  y="38" width="22" height="14" rx="2" fill="rgba(133,34,40,0.50)"/>
              <rect x="52"  y="38" width="22" height="14" rx="2" fill="rgba(133,34,40,0.85)"/>
              <rect x="76"  y="38" width="22" height="14" rx="2" fill="rgba(133,34,40,0.30)"/>
              <rect x="100" y="38" width="16" height="14" rx="2" fill="rgba(196,154,42,0.70)"/>
            </svg>
          </div>
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">部門別</h3>
            <span class="v11-prog-num">05</span>
          </div>
          <p class="v11-prog-desc">部門 × 4 軸のクロス分析。部門ごとの強み・弱みを比較し、個別施策の根拠データに。</p>
        </div>
      </div>
      <div class="v11-prog endock-tab">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="endock-tab__chart" aria-hidden="true">
            <svg viewBox="0 0 120 60" width="100%" height="100%">
              <path d="M6 8 H56 a4 4 0 0 1 4 4 v14 a4 4 0 0 1 -4 4 H22 l-6 6 v-6 H10 a4 4 0 0 1 -4 -4 V12 a4 4 0 0 1 4 -4 z" fill="var(--color-primary-50)" stroke="var(--color-primary)" stroke-width="1"/>
              <line x1="14" y1="14" x2="50" y2="14" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round"/>
              <line x1="14" y1="20" x2="42" y2="20" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M64 26 H110 a4 4 0 0 1 4 4 v14 a4 4 0 0 1 -4 4 H100 l-6 6 v-6 H64 a4 4 0 0 1 -4 -4 V30 a4 4 0 0 1 4 -4 z" fill="var(--color-accent-50)" stroke="var(--color-accent)" stroke-width="1"/>
              <line x1="68" y1="32" x2="106" y2="32" stroke="var(--color-accent-light)" stroke-width="1.5" stroke-linecap="round"/>
              <line x1="68" y1="38" x2="96" y2="38" stroke="var(--color-accent-light)" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">自由記述</h3>
            <span class="v11-prog-num">06</span>
          </div>
          <p class="v11-prog-desc">従業員の生の声を「満足度が高いコメント」と「改善期待のコメント」に分類して表示。</p>
        </div>
      </div>
      <div class="v11-prog endock-tab">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="endock-tab__chart" aria-hidden="true">
            <svg viewBox="0 0 120 60" width="100%" height="100%">
              <circle cx="14" cy="12" r="5" fill="var(--color-primary)"/>
              <polyline points="11,12 13,14 17,9" fill="none" stroke="#fff" stroke-width="1.5"/>
              <line x1="24" y1="12" x2="100" y2="12" stroke="var(--color-primary)" stroke-width="2" stroke-linecap="round"/>
              <circle cx="14" cy="30" r="5" fill="var(--color-primary)"/>
              <polyline points="11,30 13,32 17,27" fill="none" stroke="#fff" stroke-width="1.5"/>
              <line x1="24" y1="30" x2="92" y2="30" stroke="var(--color-primary)" stroke-width="2" stroke-linecap="round"/>
              <circle cx="14" cy="48" r="5" fill="none" stroke="var(--color-primary-200)" stroke-width="1.5"/>
              <line x1="24" y1="48" x2="80" y2="48" stroke="var(--color-primary-200)" stroke-width="2" stroke-linecap="round"/>
            </svg>
          </div>
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">施策提案</h3>
            <span class="v11-prog-num">07</span>
          </div>
          <p class="v11-prog-desc">診断データに基づき、御社に最適化した具体的な組織開発施策を 12 ヶ月の実施スケジュール案つきで提案。</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 12. アンケート機能について -->
<section class="section section--gray" aria-labelledby="endock-system-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Survey System</p>
      <h2 class="section-header__title" id="endock-system-title">アンケート機能について</h2>
      <span class="section-header__line" aria-hidden="true"></span>
      <p class="section-header__description">
        Google フォームをベースにした、シンプルで安心の調査システム。<br>
        専用システムは不要、最短 2 週間で実施開始できます。
      </p>
    </div>

    <ul class="endock-system reveal">
      <li class="endock-system__item">
        <div class="endock-system__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        </div>
        <h4>Web 回答方式</h4>
        <p>PC・スマートフォン・タブレットに対応。場所を選ばず回答可能。</p>
      </li>
      <li class="endock-system__item">
        <div class="endock-system__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        </div>
        <h4>匿名性の確保</h4>
        <p>回答者の個人が特定されない設計。安心して本音を回答できる環境を提供。</p>
      </li>
      <li class="endock-system__item">
        <div class="endock-system__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        </div>
        <h4>回答形式</h4>
        <p>5 段階選択式 + 自由記述式。直感的で回答しやすい画面設計。</p>
      </li>
      <li class="endock-system__item">
        <div class="endock-system__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <h4>リアルタイム確認</h4>
        <p>管理者は回答数の推移をリアルタイムで確認可能。回収率の管理が容易。</p>
      </li>
      <li class="endock-system__item">
        <div class="endock-system__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <h4>配信代行（オプション）</h4>
        <p>メール案内文の配信を代行。社内周知の負担を軽減します。</p>
      </li>
      <li class="endock-system__item">
        <div class="endock-system__icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <h4>専用システム不要</h4>
        <p>Google フォーム利用のため、新たなシステム導入・ID 管理が不要。</p>
      </li>
    </ul>
  </div>
</section>

<!-- 13. 調査の流れ -->
<section class="section" aria-labelledby="endock-process-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Process</p>
      <h2 class="section-header__title" id="endock-process-title">調査実施の流れ</h2>
      <span class="section-header__line" aria-hidden="true"></span>
      <p class="section-header__description">お打合せから報告まで、<strong>約 1 ヶ月</strong>で完了します。</p>
    </div>
    <div class="process__steps reveal">
      <div class="process__step">
        <div class="process__step-number">01</div>
        <h3 class="process__step-title">ヒアリング・設計</h3>
        <p class="process__step-text">部署構成・職位体系・調査目的を確認し、設問・属性をカスタマイズ。<br><small>所要：1〜2 日</small></p>
      </div>
      <div class="process__step">
        <div class="process__step-number">02</div>
        <h3 class="process__step-title">フォーム作成</h3>
        <p class="process__step-text">Google フォームで Web アンケートを構築。スマホ対応で完全匿名。<br><small>所要：2〜3 日</small></p>
      </div>
      <div class="process__step">
        <div class="process__step-number">03</div>
        <h3 class="process__step-title">調査実施</h3>
        <p class="process__step-text">全従業員に案内し回答を収集。リマインド文面もご用意。<br><small>所要：2〜3 週間</small></p>
      </div>
      <div class="process__step">
        <div class="process__step-number">04</div>
        <h3 class="process__step-title">集計・分析</h3>
        <p class="process__step-text">回収データを集計・換算し、7 タブのインタラクティブダッシュボードを生成。<br><small>所要：3〜5 日</small></p>
      </div>
      <div class="process__step">
        <div class="process__step-number">05</div>
        <h3 class="process__step-title">報告・提案</h3>
        <p class="process__step-text">経営層・人事へ報告会を実施。データに基づく改善提案書を納品。<br><small>所要：1 日</small></p>
      </div>
    </div>
    <div class="endock-deliverables reveal">
      <span class="endock-deliverables__label">納品物</span>
      <ul>
        <li><b>① 回答ローデータ</b><span>Excel</span></li>
        <li><b>② 分析ダッシュボード</b><span>HTML</span></li>
        <li><b>③ 報告書・改善提案書</b><span>PDF / PPTX</span></li>
      </ul>
    </div>
  </div>
</section>

<!-- 14. 診断後の改善施策メニュー -->
<section class="section section--gray" aria-labelledby="endock-services-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Follow-up Services</p>
      <h2 class="section-header__title" id="endock-services-title">診断後の改善施策メニュー（一例）</h2>
      <span class="section-header__line" aria-hidden="true"></span>
      <p class="section-header__description">診断で終わらない。課題に応じた改善施策を、ワンストップで提供します。</p>
    </div>
    <div class="v11-programs reveal">
      <div class="v11-prog">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">管理職育成プログラム</h3>
            <span class="v11-prog-num">01</span>
          </div>
          <p class="v11-prog-desc">全 12 回の体系的プログラムで、意識・対話力・思考力の 3 つの変革を実現。次世代リーダーを段階的に育成します。</p>
          <div class="v11-prog-footer">
            <span class="v11-prog-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>12 回</span>
            <span class="v11-prog-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>管理職</span>
          </div>
        </div>
      </div>
      <div class="v11-prog">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">チームビルディング</h3>
            <span class="v11-prog-num">02</span>
          </div>
          <p class="v11-prog-desc">レゴ®シリアスプレイ®等の対話型ワークショップ。言語化しにくい組織課題を「手で考える」ことで部門間の相互理解を構築。</p>
          <div class="v11-prog-footer">
            <span class="v11-prog-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>1〜2 日</span>
            <span class="v11-prog-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>部門横断</span>
          </div>
        </div>
      </div>
      <div class="v11-prog">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">組織開発コンサルティング</h3>
            <span class="v11-prog-num">03</span>
          </div>
          <p class="v11-prog-desc">人事制度設計、目標管理（CMBO）、組織構造改革まで。えんのした独自のアプローチで、組織の根幹を強化。</p>
          <div class="v11-prog-footer">
            <span class="v11-prog-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>3〜12 ヶ月</span>
            <span class="v11-prog-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>経営・人事</span>
          </div>
        </div>
      </div>
      <div class="v11-prog">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">事業承継支援</h3>
            <span class="v11-prog-num">04</span>
          </div>
          <p class="v11-prog-desc">後継者育成プログラム、経営理念の承継支援。代々受け継がれてきた組織文化を、次世代に確実に引き継ぐ伴走型支援。</p>
          <div class="v11-prog-footer">
            <span class="v11-prog-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>長期</span>
            <span class="v11-prog-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>後継者</span>
          </div>
        </div>
      </div>
      <div class="v11-prog">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">リーダーシップ研修</h3>
            <span class="v11-prog-num">05</span>
          </div>
          <p class="v11-prog-desc">自己理解（MBTI 等）を土台に、リーダーとしての覚悟と実践力を養成。座学＋職場実践＋コーチングで行動変容を定着。</p>
          <div class="v11-prog-footer">
            <span class="v11-prog-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>3〜6 ヶ月</span>
            <span class="v11-prog-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>リーダー層</span>
          </div>
        </div>
      </div>
      <div class="v11-prog">
        <div class="v11-prog-accent"></div>
        <div class="v11-prog-body">
          <div class="v11-prog-header">
            <h3 class="v11-prog-title">経営戦略策定支援</h3>
            <span class="v11-prog-num">06</span>
          </div>
          <p class="v11-prog-desc">中期経営計画、ビジョン策定、戦略フレームワーク活用。経営の方向性を組織の活力データと結びつけて再設計。</p>
          <div class="v11-prog-footer">
            <span class="v11-prog-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>3〜6 ヶ月</span>
            <span class="v11-prog-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>経営層</span>
          </div>
        </div>
      </div>
    </div>
    <p class="endock-services__note">※ 上記は一例です。診断結果に応じて、御社の課題に最適な施策をご提案いたします。</p>
  </div>
</section>

<!-- 15. 期待される成果 -->
<section class="section section--dark" aria-labelledby="endock-outcomes-title">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-header__label">Outcomes</p>
      <h2 class="section-header__title" id="endock-outcomes-title">期待される成果</h2>
      <span class="section-header__line" aria-hidden="true"></span>
    </div>
    <div class="v11-outcomes reveal">
      <div class="v11-outcome">
        <div class="v11-outcome-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <p class="v11-outcome-text">組織課題が <span class="v11-outcome-highlight">8 カテゴリ</span> に分解され、優先順位が明確になる</p>
      </div>
      <div class="v11-outcome">
        <div class="v11-outcome-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
        </div>
        <p class="v11-outcome-text">経営層・人事・現場の <span class="v11-outcome-highlight">共通言語</span> ができ、対話の質が変わる</p>
      </div>
      <div class="v11-outcome">
        <div class="v11-outcome-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <p class="v11-outcome-text">研修・施策の効果を <span class="v11-outcome-highlight">経年比較</span> で定量的に検証できる</p>
      </div>
      <div class="v11-outcome">
        <div class="v11-outcome-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <p class="v11-outcome-text">経営層への報告に、<span class="v11-outcome-highlight">客観的なデータ根拠</span> を持たせられる</p>
      </div>
      <div class="v11-outcome">
        <div class="v11-outcome-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
        </div>
        <p class="v11-outcome-text">組織開発の <span class="v11-outcome-highlight">PDS サイクル</span> が、データドリブンで回り出す</p>
      </div>
      <div class="v11-outcome">
        <div class="v11-outcome-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </div>
        <p class="v11-outcome-text">部門ごとの強み・弱みを把握し、<span class="v11-outcome-highlight">個別最適</span> な施策が打てる</p>
      </div>
    </div>
  </div>
</section>

<!-- 16. FAQ -->
<section class="section" aria-labelledby="endock-faq-title">
  <div class="container container--narrow">
    <div class="section-header reveal">
      <p class="section-header__label">FAQ</p>
      <h2 class="section-header__title" id="endock-faq-title">よくあるご質問</h2>
      <span class="section-header__line" aria-hidden="true"></span>
    </div>
    <div class="v11-faq reveal">
      <details class="v11-faq-item">
        <summary class="v11-faq-q">
          <span class="v11-faq-q-badge">Q</span>
          <span>どのくらいの規模の企業が対象ですか？</span>
          <svg class="v11-faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </summary>
        <div class="v11-faq-a"><p>30 名規模の中小企業から、複数拠点をもつ中堅企業まで対応可能です。500 名超の規模については、設計段階から個別にご相談ください。</p></div>
      </details>

      <details class="v11-faq-item">
        <summary class="v11-faq-q">
          <span class="v11-faq-q-badge">Q</span>
          <span>回答にどれくらい時間がかかりますか？</span>
          <svg class="v11-faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </summary>
        <div class="v11-faq-a"><p>標準 60 問版で 15〜20 分、簡易 40 問版で約 12 分です。スマートフォン対応で、通勤時間などにも回答できます。</p></div>
      </details>

      <details class="v11-faq-item">
        <summary class="v11-faq-q">
          <span class="v11-faq-q-badge">Q</span>
          <span>回答内容が誰に見られるか心配です</span>
          <svg class="v11-faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </summary>
        <div class="v11-faq-a"><p>完全匿名制です。個人を特定できる形で経営層・人事に共有されることはありません。集計は属性カテゴリ単位（部門・職位など）でのみ行います。</p></div>
      </details>

      <details class="v11-faq-item">
        <summary class="v11-faq-q">
          <span class="v11-faq-q-badge">Q</span>
          <span>料金はいくらですか？</span>
          <svg class="v11-faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </summary>
        <div class="v11-faq-a"><p>導入規模・調査範囲に応じた個別見積となります。おおよその目安は無料相談時にお伝えします。料金表のPDFは対面・オンラインミーティング時にご提示します。</p></div>
      </details>

      <details class="v11-faq-item">
        <summary class="v11-faq-q">
          <span class="v11-faq-q-badge">Q</span>
          <span>他社の従業員満足度調査と何が違うのですか？</span>
          <svg class="v11-faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </summary>
        <div class="v11-faq-a"><p>① ハーズバーグの二要因理論に基づく学術的な設問設計、② 報告書ではなくインタラクティブダッシュボードでの納品、③ 調査結果に基づく具体的な組織開発施策をえんのした自身が一気通貫で支援する点が大きな違いです。</p></div>
      </details>

      <details class="v11-faq-item">
        <summary class="v11-faq-q">
          <span class="v11-faq-q-badge">Q</span>
          <span>継続的に毎年実施できますか？</span>
          <svg class="v11-faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </summary>
        <div class="v11-faq-a"><p>可能です。むしろ、経年比較ができてこそ「施策の効果」が定量的に検証できます。前年と同じ設問で継続調査することで、組織の変化を追跡できます。</p></div>
      </details>

      <details class="v11-faq-item">
        <summary class="v11-faq-q">
          <span class="v11-faq-q-badge">Q</span>
          <span>問い合わせ後にしつこく営業されませんか？</span>
          <svg class="v11-faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
        </summary>
        <div class="v11-faq-a"><p>ご安心ください。営業電話・しつこいご連絡はいたしません。お問い合わせの段階では「組織課題を一緒に整理する場」としてご活用ください。</p></div>
      </details>
    </div>
  </div>
</section>

<!-- 17. 締めの哲学引用 -->
<section class="section endock-philosophy" aria-label="えんのしたの哲学">
  <div class="container container--narrow">
    <div class="endock-philosophy__inner reveal">
      <div class="endock-philosophy__mark" aria-hidden="true">“</div>
      <blockquote class="endock-philosophy__quote">
        調査して、終わりではない。<br>
        データを「行動」に変える、<br>
        そこからが、私たちの仕事です。
      </blockquote>
      <div class="endock-philosophy__author">
        <span class="endock-philosophy__author-line"></span>
        <span>えんのした流・組織開発の哲学</span>
        <span class="endock-philosophy__author-line"></span>
      </div>
    </div>
  </div>
</section>

<!-- 18. CTA（既存テンプレートパーツ） -->
<?php get_template_part('template-parts/section', 'cta'); ?>

</main>

<?php get_footer(); ?>
