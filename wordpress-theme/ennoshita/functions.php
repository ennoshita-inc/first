<?php
/**
 * 株式会社えんのした WordPress テーマ functions.php
 *
 * 改善ポイント:
 * - パフォーマンス最適化（不要スクリプト除去、プリロード、WebP対応）
 * - SEO最適化（タイトルタグ、OGP、構造化データ）
 * - アクセシビリティ対応
 * - セキュリティ強化
 */

// ==============================================
// 1. テーマセットアップ
// ==============================================
function ennoshita_setup() {
    // タイトルタグの自動出力（改善1）
    add_theme_support('title-tag');

    // アイキャッチ画像
    add_theme_support('post-thumbnails');
    add_image_size('blog-card', 400, 225, true);
    add_image_size('hero', 960, 720, true);
    add_image_size('ogp', 1200, 630, true);

    // HTML5マークアップ
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    // ナビゲーションメニューの登録
    register_nav_menus([
        'primary'  => 'メインメニュー',
        'footer-1' => 'フッターメニュー（サービス）',
        'footer-2' => 'フッターメニュー（企業情報）',
    ]);
}
add_action('after_setup_theme', 'ennoshita_setup');


// ==============================================
// 2. スタイル・スクリプトの読み込み（改善6: パフォーマンス）
// ==============================================
function ennoshita_enqueue_assets() {
    // メインスタイル
    wp_enqueue_style(
        'ennoshita-style',
        get_stylesheet_uri(),
        [],
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    // Google Fonts（font-display: swap付き）
    wp_enqueue_style(
        'ennoshita-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap',
        [],
        null
    );

    // メインJS（defer読み込み）
    wp_enqueue_script(
        'ennoshita-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        filemtime(get_template_directory() . '/assets/js/main.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'ennoshita_enqueue_assets');


// ==============================================
// 3. パフォーマンス最適化
// ==============================================

// Google Fonts に preconnect を追加（改善7）
function ennoshita_preconnect_fonts($urls, $relation_type) {
    if ($relation_type === 'preconnect') {
        $urls[] = [
            'href'        => 'https://fonts.googleapis.com',
            'crossorigin' => false,
        ];
        $urls[] = [
            'href'        => 'https://fonts.gstatic.com',
            'crossorigin' => true,
        ];
    }
    return $urls;
}
add_filter('wp_resource_hints', 'ennoshita_preconnect_fonts', 10, 2);

// 不要な head 出力を削除（セキュリティ＋パフォーマンス）
function ennoshita_clean_head() {
    remove_action('wp_head', 'wp_generator');                // WPバージョン非表示
    remove_action('wp_head', 'wlwmanifest_link');            // Windows Live Writer
    remove_action('wp_head', 'rsd_link');                    // Really Simple Discovery
    remove_action('wp_head', 'wp_shortlink_wp_head');        // ショートリンク
    remove_action('wp_head', 'rest_output_link_wp_head');    // REST APIリンク
    remove_action('wp_head', 'feed_links_extra', 3);         // 余分なフィードリンク
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('after_setup_theme', 'ennoshita_clean_head');

// jQuery Migrate を除去（パフォーマンス）
function ennoshita_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
}
add_action('wp_default_scripts', 'ennoshita_remove_jquery_migrate');

// WebP アップロード対応（改善5）
function ennoshita_allow_webp($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'ennoshita_allow_webp');

// 画像に loading="lazy" を自動付与（WordPress 5.5+ はデフォルト対応）
// LCP画像には fetchpriority="high" を付与
function ennoshita_add_fetchpriority($attr, $attachment, $size) {
    // hero サイズの画像は LCP 候補なので lazy ではなく fetchpriority を設定
    if ($size === 'hero' || $size === 'full') {
        $attr['fetchpriority'] = 'high';
        unset($attr['loading']); // lazy を除去
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'ennoshita_add_fetchpriority', 10, 3);


// ==============================================
// 4. SEO 最適化（改善1, 2）
// ==============================================

// タイトルタグのカスタマイズ
function ennoshita_document_title_parts($title) {
    // トップページ: 「トップページ」を除去しキーワードを含む
    if (is_front_page()) {
        $title['title'] = '岡山の人材育成・組織開発コンサルティング';
        $title['tagline'] = ''; // キャッチフレーズを非表示
    }
    return $title;
}
add_filter('document_title_parts', 'ennoshita_document_title_parts');

// タイトルのセパレータを変更
function ennoshita_document_title_separator() {
    return '|';
}
add_filter('document_title_separator', 'ennoshita_document_title_separator');


// ==============================================
// 5. OGP 出力（改善3）
// ==============================================
function ennoshita_output_ogp() {
    $ogp = [];

    if (is_front_page() || is_home()) {
        $ogp['og:title']       = '株式会社えんのした | 岡山の人材育成・組織開発コンサルティング';
        $ogp['og:description'] = '人・職場・組織を支えるコンサルティング会社。人材育成、人事制度構築、組織開発の3つの柱で、リーダーの心技体を育みます。';
        $ogp['og:type']        = 'website';
        $ogp['og:url']         = home_url('/');
    } elseif (is_singular()) {
        $ogp['og:title']       = get_the_title();
        $ogp['og:description'] = ennoshita_get_meta_description();
        $ogp['og:type']        = 'article';
        $ogp['og:url']         = get_permalink();
    }

    // OGP画像
    if (is_singular() && has_post_thumbnail()) {
        $ogp['og:image'] = get_the_post_thumbnail_url(null, 'ogp');
    } else {
        $ogp['og:image'] = get_template_directory_uri() . '/assets/images/ogp-default.jpg';
    }

    $ogp['og:site_name'] = get_bloginfo('name');
    $ogp['og:locale']    = 'ja_JP';

    foreach ($ogp as $property => $content) {
        if ($content) {
            printf('<meta property="%s" content="%s">' . "\n", esc_attr($property), esc_attr($content));
        }
    }

    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    if (isset($ogp['og:title'])) {
        printf('<meta name="twitter:title" content="%s">' . "\n", esc_attr($ogp['og:title']));
    }
    if (isset($ogp['og:description'])) {
        printf('<meta name="twitter:description" content="%s">' . "\n", esc_attr($ogp['og:description']));
    }
    if (isset($ogp['og:image'])) {
        printf('<meta name="twitter:image" content="%s">' . "\n", esc_attr($ogp['og:image']));
    }
}
add_action('wp_head', 'ennoshita_output_ogp', 1);


// ==============================================
// 6. meta description 出力（改善2）
// ==============================================
function ennoshita_get_meta_description() {
    if (is_front_page()) {
        return '株式会社えんのしたは、岡山を拠点に人材育成・人事制度構築・組織開発を支援するコンサルティング会社です。多様な学びの場の提供により、リーダーの心技体を育み、組織の成長を実現します。';
    }

    if (is_singular()) {
        $post = get_post();
        if ($post && $post->post_excerpt) {
            return wp_trim_words($post->post_excerpt, 60, '…');
        }
        if ($post) {
            return wp_trim_words(strip_shortcodes($post->post_content), 60, '…');
        }
    }

    if (is_category() || is_tag()) {
        $description = term_description();
        if ($description) {
            return wp_trim_words(wp_strip_all_tags($description), 60, '…');
        }
    }

    return get_bloginfo('description');
}

function ennoshita_output_meta_description() {
    $desc = ennoshita_get_meta_description();
    if ($desc) {
        printf('<meta name="description" content="%s">' . "\n", esc_attr($desc));
    }
}
add_action('wp_head', 'ennoshita_output_meta_description', 1);


// ==============================================
// 7. 構造化データ JSON-LD（改善4）
// ==============================================
function ennoshita_output_jsonld() {
    if (is_front_page()) {
        $data = [
            '@context'    => 'https://schema.org',
            '@type'       => 'LocalBusiness',
            'name'        => '株式会社えんのした',
            'description' => '人・職場・組織を支えるコンサルティング会社。人材育成、人事制度構築、組織開発を支援します。',
            'url'         => home_url('/'),
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => '磨屋町ビル8階',
                'addressLocality' => '岡山市',
                'addressRegion'   => '岡山県',
                'addressCountry'  => 'JP',
            ],
            'foundingDate' => '2012-05-01',
        ];

        printf(
            '<script type="application/ld+json">%s</script>' . "\n",
            wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );
    }

    // ブログ記事の構造化データ
    if (is_singular('post')) {
        $data = [
            '@context'      => 'https://schema.org',
            '@type'         => 'Article',
            'headline'      => get_the_title(),
            'datePublished' => get_the_date('c'),
            'dateModified'  => get_the_modified_date('c'),
            'author'        => [
                '@type' => 'Organization',
                'name'  => '株式会社えんのした',
            ],
            'publisher'     => [
                '@type' => 'Organization',
                'name'  => '株式会社えんのした',
                'url'   => home_url('/'),
            ],
            'mainEntityOfPage' => get_permalink(),
        ];

        if (has_post_thumbnail()) {
            $data['image'] = get_the_post_thumbnail_url(null, 'full');
        }

        printf(
            '<script type="application/ld+json">%s</script>' . "\n",
            wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );
    }
}
add_action('wp_head', 'ennoshita_output_jsonld', 2);


// ==============================================
// 8. canonical URL 出力
// ==============================================
function ennoshita_output_canonical() {
    if (is_front_page()) {
        printf('<link rel="canonical" href="%s">' . "\n", esc_url(home_url('/')));
    } elseif (is_singular()) {
        printf('<link rel="canonical" href="%s">' . "\n", esc_url(get_permalink()));
    }
}
add_action('wp_head', 'ennoshita_output_canonical', 1);


// ==============================================
// 9. ウィジェットエリア
// ==============================================
function ennoshita_widgets_init() {
    register_sidebar([
        'name'          => 'サイドバー',
        'id'            => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget__title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'ennoshita_widgets_init');


// ==============================================
// 10. 抜粋（excerpt）のカスタマイズ
// ==============================================
function ennoshita_excerpt_length() {
    return 40;
}
add_filter('excerpt_length', 'ennoshita_excerpt_length');

function ennoshita_excerpt_more() {
    return '…';
}
add_filter('excerpt_more', 'ennoshita_excerpt_more');


// ==============================================
// 11. ブログURLスラッグ改善の注意（改善15）
// ==============================================
// 現在のURL構造 (/674/, /763/) はパーマリンク設定で変更可能
// WordPress管理画面 > 設定 > パーマリンク設定 で以下を推奨：
// 「投稿名」 → /%postname%/
// ※既存URLからの301リダイレクトが必要（Redirectionプラグイン推奨）
