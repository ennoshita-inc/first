<?php
/**
 * 株式会社えんのした WordPress テーマ functions.php v3.0
 *
 * 全16改善項目に対応:
 * #1  タイトルタグ最適化
 * #2  meta description
 * #3  OGP (Open Graph)
 * #4  構造化データ JSON-LD
 * #5  画像最適化 (WebP, lazy, fetchpriority)
 * #6  CSS/JS 読み込み最適化
 * #7  フォント最適化 (preconnect, font-display)
 * #8  見出し構造 (テンプレートで対応)
 * #9  画像alt属性 (テンプレートで対応)
 * #10 フォーカス表示 (CSSで対応)
 * #11 カラーコントラスト (CSSで対応)
 * #12 CTA強化 (テンプレートで対応)
 * #13 モバイル対応 (CSS + JSで対応)
 * #14 ファーストビュー (テンプレートで対応)
 * #15 URLスラッグ (管理画面パーマリンク設定)
 * #16 カテゴリ・タグ整理 (管理画面で対応)
 */

// ==============================================
// 1. テーマセットアップ
// ==============================================
function ennoshita_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    add_image_size('blog-card', 400, 225, true);
    add_image_size('blog-card-2x', 800, 450, true);
    add_image_size('hero', 960, 720, true);
    add_image_size('ogp', 1200, 630, true);

    add_theme_support('html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ]);

    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');

    register_nav_menus([
        'primary'  => 'メインメニュー',
        'footer-1' => 'フッターメニュー（サービス）',
        'footer-2' => 'フッターメニュー（企業情報）',
    ]);
}
add_action('after_setup_theme', 'ennoshita_setup');


// ==============================================
// 2. スタイル・スクリプト読み込み (#6 #7)
// ==============================================
function ennoshita_enqueue_assets() {
    // メインスタイル
    wp_enqueue_style(
        'ennoshita-style',
        get_stylesheet_uri(),
        [],
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    // Google Fonts (font-display: swap)
    wp_enqueue_style(
        'ennoshita-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Noto+Serif+JP:wght@500;700;900&display=swap',
        [],
        null
    );

    // メインJS (defer)
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
// 3. パフォーマンス最適化 (#5 #6 #7)
// ==============================================

// preconnect (Google Fonts)
function ennoshita_preconnect_fonts($urls, $relation_type) {
    if ($relation_type === 'preconnect') {
        $urls[] = ['href' => 'https://fonts.googleapis.com', 'crossorigin' => false];
        $urls[] = ['href' => 'https://fonts.gstatic.com', 'crossorigin' => true];
    }
    return $urls;
}
add_filter('wp_resource_hints', 'ennoshita_preconnect_fonts', 10, 2);

// 不要な head 出力を削除 (セキュリティ + パフォーマンス)
function ennoshita_clean_head() {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}
add_action('after_setup_theme', 'ennoshita_clean_head');

// jQuery Migrate 除去
function ennoshita_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
}
add_action('wp_default_scripts', 'ennoshita_remove_jquery_migrate');

// WebP アップロード対応
function ennoshita_allow_webp($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'ennoshita_allow_webp');

// LCP画像に fetchpriority="high" を付与
function ennoshita_add_fetchpriority($attr, $attachment, $size) {
    if ($size === 'hero' || $size === 'full') {
        $attr['fetchpriority'] = 'high';
        unset($attr['loading']);
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'ennoshita_add_fetchpriority', 10, 3);

// script タグに defer 属性を追加
function ennoshita_script_defer($tag, $handle, $src) {
    if (is_admin()) {
        return $tag;
    }
    if ($handle === 'ennoshita-main') {
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'ennoshita_script_defer', 10, 3);


// ==============================================
// 4. SEO — タイトルタグ (#1)
// ==============================================
function ennoshita_document_title_parts($title) {
    if (is_front_page()) {
        $title['title'] = '岡山の人材育成・組織開発コンサルティング';
        $title['tagline'] = '';
    }
    return $title;
}
add_filter('document_title_parts', 'ennoshita_document_title_parts');

function ennoshita_document_title_separator() {
    return '|';
}
add_filter('document_title_separator', 'ennoshita_document_title_separator');


// ==============================================
// 5. SEO — meta description (#2)
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
// 6. SEO — OGP (#3)
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
    } elseif (is_archive()) {
        $ogp['og:title']       = get_the_archive_title();
        $ogp['og:description'] = get_the_archive_description() ?: get_bloginfo('description');
        $ogp['og:type']        = 'website';
        $ogp['og:url']         = get_pagenum_link();
    }

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
    foreach (['og:title' => 'twitter:title', 'og:description' => 'twitter:description', 'og:image' => 'twitter:image'] as $og => $tw) {
        if (!empty($ogp[$og])) {
            printf('<meta name="%s" content="%s">' . "\n", esc_attr($tw), esc_attr($ogp[$og]));
        }
    }
}
add_action('wp_head', 'ennoshita_output_ogp', 1);


// ==============================================
// 7. SEO — 構造化データ JSON-LD (#4)
// ==============================================
function ennoshita_output_jsonld() {
    if (is_front_page()) {
        $data = [
            '@context'    => 'https://schema.org',
            '@type'       => 'LocalBusiness',
            'name'        => '株式会社えんのした',
            'description' => '人・職場・組織を支えるコンサルティング会社。人材育成、人事制度構築、組織開発を支援します。',
            'url'         => home_url('/'),
            'telephone'   => '',
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => '磨屋町ビル8階',
                'addressLocality' => '岡山市',
                'addressRegion'   => '岡山県',
                'addressCountry'  => 'JP',
            ],
            'foundingDate' => '2012-05-01',
            'sameAs'       => [],
        ];

        printf(
            '<script type="application/ld+json">%s</script>' . "\n",
            wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );
    }

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
            'publisher' => [
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
// 8. SEO — canonical URL
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
// 9. ウィジェット
// ==============================================
function ennoshita_widgets_init() {
    register_sidebar([
        'name'          => 'ブログサイドバー',
        'id'            => 'sidebar-blog',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget__title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'ennoshita_widgets_init');


// ==============================================
// 10. 抜粋 (excerpt) カスタマイズ
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
// 11. パンくずリスト
// ==============================================
function ennoshita_breadcrumb() {
    if (is_front_page()) return;

    echo '<nav class="breadcrumb" aria-label="パンくずリスト">';
    echo '<div class="container">';
    echo '<a href="' . esc_url(home_url('/')) . '">ホーム</a>';
    echo '<span class="breadcrumb__separator" aria-hidden="true">/</span>';

    if (is_category()) {
        single_cat_title();
    } elseif (is_tag()) {
        single_tag_title();
    } elseif (is_singular('post')) {
        $categories = get_the_category();
        if ($categories) {
            echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
            echo '<span class="breadcrumb__separator" aria-hidden="true">/</span>';
        }
        the_title();
    } elseif (is_page()) {
        the_title();
    } elseif (is_search()) {
        echo '検索結果: ' . esc_html(get_search_query());
    } elseif (is_404()) {
        echo 'ページが見つかりません';
    } elseif (is_archive()) {
        the_archive_title();
    }

    echo '</div></nav>';
}


// ==============================================
// 12. カスタマイザー設定
// ==============================================
function ennoshita_customize_register($wp_customize) {
    // ヒーローセクション
    $wp_customize->add_section('ennoshita_hero', [
        'title'    => 'ヒーローセクション',
        'priority' => 30,
    ]);

    $wp_customize->add_setting('ennoshita_hero_image', ['default' => '']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ennoshita_hero_image', [
        'label'   => 'ヒーロー画像',
        'section' => 'ennoshita_hero',
    ]));

    $wp_customize->add_setting('ennoshita_hero_title', [
        'default'           => "人・職場・組織を支え、\nリーダーの心技体を育む",
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('ennoshita_hero_title', [
        'label'   => 'ヒーローキャッチコピー',
        'section' => 'ennoshita_hero',
        'type'    => 'textarea',
    ]);

    $wp_customize->add_setting('ennoshita_hero_description', [
        'default'           => '株式会社えんのしたは、岡山を拠点に人材育成・人事制度構築・組織開発の3つの柱で、組織の持続的な成長を支援するコンサルティング会社です。',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('ennoshita_hero_description', [
        'label'   => 'ヒーロー説明文',
        'section' => 'ennoshita_hero',
        'type'    => 'textarea',
    ]);

    // CTA セクション
    $wp_customize->add_section('ennoshita_cta', [
        'title'    => 'CTAセクション',
        'priority' => 35,
    ]);

    $wp_customize->add_setting('ennoshita_cta_title', [
        'default'           => '組織の課題、一緒に解決しませんか？',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ennoshita_cta_title', [
        'label'   => 'CTAタイトル',
        'section' => 'ennoshita_cta',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('ennoshita_cta_text', [
        'default'           => 'まずはお気軽にご相談ください。貴社の状況をお伺いし、最適なアプローチをご提案します。',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('ennoshita_cta_text', [
        'label'   => 'CTA説明文',
        'section' => 'ennoshita_cta',
        'type'    => 'textarea',
    ]);

    // 会社情報
    $wp_customize->add_section('ennoshita_company', [
        'title'    => '会社情報',
        'priority' => 40,
    ]);

    $wp_customize->add_setting('ennoshita_phone', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ennoshita_phone', [
        'label'   => '電話番号',
        'section' => 'ennoshita_company',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('ennoshita_email', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ]);
    $wp_customize->add_control('ennoshita_email', [
        'label'   => 'メールアドレス',
        'section' => 'ennoshita_company',
        'type'    => 'email',
    ]);

    $wp_customize->add_setting('ennoshita_address', [
        'default'           => '岡山県岡山市 磨屋町ビル8階',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('ennoshita_address', [
        'label'   => '所在地',
        'section' => 'ennoshita_company',
        'type'    => 'textarea',
    ]);
}
add_action('customize_register', 'ennoshita_customize_register');


// ==============================================
// 13. ユーティリティ関数
// ==============================================

/**
 * 投稿の推定読了時間を取得
 */
function ennoshita_reading_time($post_id = null) {
    $content = get_post_field('post_content', $post_id ?: get_the_ID());
    $word_count = mb_strlen(strip_tags($content));
    $minutes = max(1, ceil($word_count / 600));
    return $minutes;
}

/**
 * カスタムロゴまたはテキストロゴを出力
 */
function ennoshita_the_logo($class = 'site-logo') {
    $custom_logo_id = get_theme_mod('custom_logo');

    echo '<a href="' . esc_url(home_url('/')) . '" class="' . esc_attr($class) . '" rel="home">';

    if ($custom_logo_id) {
        echo wp_get_attachment_image($custom_logo_id, 'full', false, [
            'class' => 'custom-logo',
            'alt'   => get_bloginfo('name'),
        ]);
    }

    echo '<span class="site-logo__text">';
    echo '<span class="site-logo__main">株式会社えんのした</span>';
    echo '<span class="site-logo__sub">ENNOSHITA</span>';
    echo '</span>';
    echo '</a>';
}
