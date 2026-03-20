<?php
/**
 * AI検索エンジン最適化（AIO） — LLM・AI検索への対応
 *
 * - llms.txt エンドポイント
 * - robots.txt でAIボットを許可
 * - WebSite / Organization / Service 構造化データ
 * - AI向けメタタグ
 *
 * @package Ennoshita
 */

// ==============================================
// 1. llms.txt — LLM向けサイト説明ファイル
// ==============================================
function ennoshita_register_llms_txt() {
    add_rewrite_rule('^llms\.txt$', 'index.php?ennoshita_llms_txt=1', 'top');
    add_rewrite_rule('^llms-full\.txt$', 'index.php?ennoshita_llms_full_txt=1', 'top');
}
add_action('init', 'ennoshita_register_llms_txt');

function ennoshita_llms_txt_query_vars($vars) {
    $vars[] = 'ennoshita_llms_txt';
    $vars[] = 'ennoshita_llms_full_txt';
    return $vars;
}
add_filter('query_vars', 'ennoshita_llms_txt_query_vars');

function ennoshita_llms_txt_template() {
    if (get_query_var('ennoshita_llms_txt')) {
        header('Content-Type: text/plain; charset=utf-8');
        header('X-Robots-Tag: noindex');
        echo ennoshita_generate_llms_txt(false);
        exit;
    }
    if (get_query_var('ennoshita_llms_full_txt')) {
        header('Content-Type: text/plain; charset=utf-8');
        header('X-Robots-Tag: noindex');
        echo ennoshita_generate_llms_txt(true);
        exit;
    }
}
add_action('template_redirect', 'ennoshita_llms_txt_template');

function ennoshita_generate_llms_txt($full = false) {
    $site_url = home_url('/');
    $phone    = get_theme_mod('ennoshita_phone', '');

    $output = "# 株式会社えんのした\n\n";
    $output .= "> 岡山を拠点に、人材育成・人事制度構築・組織開発を支援するコンサルティング会社です。\n";
    $output .= "> 「人が育てば組織が変わる」を理念に、100社以上の企業の組織変革を支援してきました。\n\n";

    $output .= "## 会社情報\n\n";
    $output .= "- 会社名: 株式会社えんのした（Ennoshita Inc.）\n";
    $output .= "- 所在地: 岡山県岡山市 磨屋町ビル8階\n";
    $output .= "- 設立: 2012年5月\n";
    $output .= "- 代表取締役: 川路 隆志\n";
    if ($phone) {
        $output .= "- 電話番号: {$phone}\n";
    }
    $output .= "- ウェブサイト: {$site_url}\n\n";

    $output .= "## サービス\n\n";
    $output .= "- [人材育成サービス]({$site_url}service/training/): 管理職研修、新入社員研修、リーダーシップ開発など、企業の人材を育てる研修プログラム\n";
    $output .= "- [人事制度構築支援]({$site_url}service/hr-system/): 評価制度・報酬制度・等級制度の設計・構築支援\n";
    $output .= "- [組織開発支援]({$site_url}service/organization/): チームビルディング、組織風土改革、エンゲージメント向上支援\n\n";

    $output .= "## 主要ページ\n\n";
    $output .= "- [トップページ]({$site_url})\n";
    $output .= "- [会社概要]({$site_url}about/)\n";
    $output .= "- [お問い合わせ]({$site_url}contact/)\n";
    $output .= "- [コラム（ブログ）](" . esc_url(ennoshita_get_blog_url()) . ")\n";
    $output .= "- [プライバシーポリシー]({$site_url}privacy/)\n";

    if ($full) {
        $output .= "\n## 詳細情報\n\n";

        $output .= "### 人材育成サービスについて\n\n";
        $output .= "管理職のマネジメント力強化、新入社員の早期戦力化、次世代リーダーの育成など、企業の人材課題に合わせた研修プログラムを提供しています。";
        $output .= "座学だけでなく、実践的なワークショップやロールプレイを取り入れ、行動変容につながる研修を設計します。\n\n";

        $output .= "### 人事制度構築支援について\n\n";
        $output .= "現場の声を丁寧にヒアリングし、企業の文化・規模に合った人事制度（評価制度・報酬制度・等級制度）を設計します。";
        $output .= "制度導入後の運用支援まで一貫してサポートし、社員の納得感のある制度づくりを実現します。\n\n";

        $output .= "### 組織開発支援について\n\n";
        $output .= "部署間の壁を取り払い、チーム全体で考える文化を醸成する組織開発プログラムを提供しています。";
        $output .= "ワークショップ、1on1コーチング、組織診断など多角的なアプローチで組織の変革を支援します。\n\n";

        $output .= "### 導入の流れ\n\n";
        $output .= "1. 無料相談・ヒアリング\n";
        $output .= "2. 課題分析・プラン提案\n";
        $output .= "3. プログラム設計・カスタマイズ\n";
        $output .= "4. 実施・運用サポート\n";
        $output .= "5. 効果測定・改善提案\n\n";

        $output .= "### 対象エリア\n\n";
        $output .= "岡山県を中心に、中四国エリア、全国対応可能。オンライン研修にも対応しています。\n";

        // 最新のブログ記事も含める
        $recent_posts = get_posts([
            'posts_per_page' => 5,
            'post_status'    => 'publish',
        ]);
        if ($recent_posts) {
            $output .= "\n### 最新のコラム\n\n";
            foreach ($recent_posts as $post) {
                $output .= "- [" . esc_html($post->post_title) . "](" . get_permalink($post) . ")\n";
            }
        }
    }

    return $output;
}


// ==============================================
// 2. robots.txt — AI ボットを許可
// ==============================================
function ennoshita_robots_txt($output, $public) {
    if (!$public) {
        return $output;
    }

    // AI検索ボットを明示的に許可
    $ai_bots = [
        'GPTBot',
        'ChatGPT-User',
        'Google-Extended',
        'PerplexityBot',
        'ClaudeBot',
        'Applebot-Extended',
        'cohere-ai',
    ];

    foreach ($ai_bots as $bot) {
        $output .= "\nUser-agent: {$bot}\n";
        $output .= "Allow: /\n";
        $output .= "Disallow: /wp-admin/\n";
    }

    // llms.txt の場所を案内
    $output .= "\n# LLM向けサイト情報\n";
    $output .= "# " . home_url('/llms.txt') . "\n";

    // サイトマップ
    $output .= "\nSitemap: " . home_url('/wp-sitemap.xml') . "\n";

    return $output;
}
add_filter('robots_txt', 'ennoshita_robots_txt', 10, 2);


// ==============================================
// 3. 構造化データの拡充（WebSite + Organization + Service）
// ==============================================
function ennoshita_output_ai_jsonld() {
    $logo_id  = get_theme_mod('custom_logo');
    $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
    $phone    = get_theme_mod('ennoshita_phone', '');

    // WebSite スキーマ（サイト全体で1つ — サイト内検索対応）
    if (is_front_page()) {
        $website = [
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => '株式会社えんのした',
            'alternateName' => 'Ennoshita Inc.',
            'url'      => home_url('/'),
            'inLanguage' => 'ja',
            'description' => '岡山を拠点に人材育成・人事制度構築・組織開発を支援するコンサルティング会社',
        ];

        // サイト内検索アクション
        $website['potentialAction'] = [
            '@type'  => 'SearchAction',
            'target' => [
                '@type'       => 'EntryPoint',
                'urlTemplate' => home_url('/?s={search_term_string}'),
            ],
            'query-input' => 'required name=search_term_string',
        ];

        printf(
            '<script type="application/ld+json">%s</script>' . "\n",
            wp_json_encode($website, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );

        // Organization スキーマ（LocalBusiness を補完）
        $org = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Organization',
            'name'        => '株式会社えんのした',
            'alternateName' => 'Ennoshita Inc.',
            'url'         => home_url('/'),
            'description' => '人・職場・組織を支えるコンサルティング会社。人材育成、人事制度構築、組織開発を支援します。',
            'foundingDate' => '2012-05-01',
            'founder'     => [
                '@type' => 'Person',
                'name'  => '川路 隆志',
                'jobTitle' => '代表取締役',
            ],
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => '磨屋町ビル8階',
                'addressLocality' => '岡山市',
                'addressRegion'   => '岡山県',
                'postalCode'      => '700-0826',
                'addressCountry'  => 'JP',
            ],
            'areaServed'  => [
                '@type' => 'Country',
                'name'  => 'JP',
            ],
            'knowsAbout'  => [
                '人材育成',
                '管理職研修',
                'リーダーシップ開発',
                '人事制度構築',
                '評価制度設計',
                '組織開発',
                'チームビルディング',
                '組織風土改革',
                'コンサルティング',
            ],
        ];

        if ($phone) {
            $org['telephone'] = $phone;
        }
        if ($logo_url) {
            $org['logo'] = $logo_url;
            $org['image'] = $logo_url;
        }

        // SNSリンク
        $same_as = [];
        foreach (['x', 'facebook', 'instagram', 'linkedin'] as $sns) {
            $sns_url = get_theme_mod("ennoshita_sns_{$sns}");
            if ($sns_url) {
                $same_as[] = $sns_url;
            }
        }
        if ($same_as) {
            $org['sameAs'] = $same_as;
        }

        printf(
            '<script type="application/ld+json">%s</script>' . "\n",
            wp_json_encode($org, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );

        // Service スキーマ（3つのサービス）
        $services = [
            [
                'name'        => '人材育成サービス',
                'description' => '管理職研修、新入社員研修、リーダーシップ開発など、企業の人材育成を支援する研修プログラムの設計・実施',
                'url'         => home_url('/service/training/'),
                'category'    => '企業研修・人材育成コンサルティング',
            ],
            [
                'name'        => '人事制度構築支援',
                'description' => '評価制度・報酬制度・等級制度の設計・構築・運用支援。企業文化に合った人事制度づくりを実現',
                'url'         => home_url('/service/hr-system/'),
                'category'    => '人事制度コンサルティング',
            ],
            [
                'name'        => '組織開発支援',
                'description' => 'チームビルディング、組織風土改革、エンゲージメント向上。組織全体の変革を多角的にサポート',
                'url'         => home_url('/service/organization/'),
                'category'    => '組織開発コンサルティング',
            ],
        ];

        foreach ($services as $svc) {
            $svc_schema = [
                '@context'    => 'https://schema.org',
                '@type'       => 'Service',
                'name'        => $svc['name'],
                'description' => $svc['description'],
                'url'         => $svc['url'],
                'category'    => $svc['category'],
                'provider'    => [
                    '@type' => 'Organization',
                    'name'  => '株式会社えんのした',
                    'url'   => home_url('/'),
                ],
                'areaServed'  => [
                    '@type' => 'Country',
                    'name'  => 'JP',
                ],
                'availableChannel' => [
                    '@type'               => 'ServiceChannel',
                    'serviceUrl'          => home_url('/contact/'),
                    'availableLanguage'   => 'ja',
                ],
            ];

            printf(
                '<script type="application/ld+json">%s</script>' . "\n",
                wp_json_encode($svc_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
            );
        }
    }
}
add_action('wp_head', 'ennoshita_output_ai_jsonld', 3);


// ==============================================
// 4. AI向けメタタグ
// ==============================================
function ennoshita_ai_meta_tags() {
    // llms.txt の存在を通知
    printf('<link rel="alternate" type="text/plain" href="%s" title="LLM information">' . "\n", esc_url(home_url('/llms.txt')));

    // サイトの言語・地域を明示
    echo '<meta name="language" content="ja">' . "\n";
    echo '<meta name="geo.region" content="JP-33">' . "\n";
    echo '<meta name="geo.placename" content="Okayama">' . "\n";
}
add_action('wp_head', 'ennoshita_ai_meta_tags', 1);


// ==============================================
// 5. フラッシュ対応: rewrite ruleの自動フラッシュ
// ==============================================
function ennoshita_ai_flush_rewrite() {
    $flag = get_option('ennoshita_ai_rewrite_flushed', false);
    if (!$flag) {
        flush_rewrite_rules();
        update_option('ennoshita_ai_rewrite_flushed', true);
    }
}
add_action('init', 'ennoshita_ai_flush_rewrite', 20);

// テーマ切り替え時にフラグリセット
function ennoshita_ai_on_switch_theme() {
    delete_option('ennoshita_ai_rewrite_flushed');
}
add_action('after_switch_theme', 'ennoshita_ai_on_switch_theme');
