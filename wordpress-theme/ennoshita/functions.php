<?php
/**
 * 株式会社えんのした WordPress テーマ functions.php v4.0
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
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Noto+Sans+JP:wght@300;400;500;700&family=Noto+Serif+JP:wght@500;700;900&display=swap',
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

    // サービスページのFAQスキーマ（テンプレート選択 or サービス子ページ）
    $is_service_tpl = is_page() && (is_page_template('page-service.php') || (is_page() && wp_get_post_parent_id(get_the_ID()) && get_post_field('post_name', wp_get_post_parent_id(get_the_ID())) === 'service'));
    if ($is_service_tpl) {
        $faq_raw = get_post_meta(get_the_ID(), '_service_faq', true);
        if ($faq_raw) {
            $faq_items = [];
            foreach (explode("\n", trim($faq_raw)) as $line) {
                $parts = explode('|', trim($line), 2);
                if (count($parts) === 2 && trim($parts[0]) && trim($parts[1])) {
                    $faq_items[] = [
                        '@type'          => 'Question',
                        'name'           => trim($parts[0]),
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text'  => trim($parts[1]),
                        ],
                    ];
                }
            }
            if ($faq_items) {
                $faq_data = [
                    '@context'   => 'https://schema.org',
                    '@type'      => 'FAQPage',
                    'mainEntity' => $faq_items,
                ];
                printf(
                    '<script type="application/ld+json">%s</script>' . "\n",
                    wp_json_encode($faq_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
                );
            }
        }
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
// 9. カスタム投稿タイプ: お客様の声
// ==============================================
function ennoshita_register_testimonial_cpt() {
    register_post_type('testimonial', [
        'labels' => [
            'name'               => 'お客様の声',
            'singular_name'      => 'お客様の声',
            'add_new'            => '新規追加',
            'add_new_item'       => 'お客様の声を追加',
            'edit_item'          => 'お客様の声を編集',
            'new_item'           => '新しいお客様の声',
            'view_item'          => 'お客様の声を表示',
            'search_items'       => 'お客様の声を検索',
            'not_found'          => 'お客様の声が見つかりません',
            'not_found_in_trash' => 'ゴミ箱にお客様の声はありません',
            'menu_name'          => 'お客様の声',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-format-quote',
        'menu_position' => 25,
        'supports'     => ['title', 'editor', 'thumbnail'],
        'has_archive'  => false,
    ]);
}
add_action('init', 'ennoshita_register_testimonial_cpt');

// お客様の声のカスタムフィールドを管理画面に追加
function ennoshita_testimonial_meta_boxes() {
    add_meta_box(
        'testimonial_details',
        'お客様情報',
        'ennoshita_testimonial_meta_box_html',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'ennoshita_testimonial_meta_boxes');

function ennoshita_testimonial_meta_box_html($post) {
    $company = get_post_meta($post->ID, '_testimonial_company', true);
    $role    = get_post_meta($post->ID, '_testimonial_role', true);
    wp_nonce_field('ennoshita_testimonial_nonce', '_testimonial_nonce');
    ?>
    <table class="form-table">
        <tr>
            <th><label for="testimonial_company">会社名・業種</label></th>
            <td><input type="text" id="testimonial_company" name="testimonial_company"
                       value="<?php echo esc_attr($company); ?>" class="regular-text"
                       placeholder="例: 製造業 A社様（従業員300名）"></td>
        </tr>
        <tr>
            <th><label for="testimonial_role">肩書き</label></th>
            <td><input type="text" id="testimonial_role" name="testimonial_role"
                       value="<?php echo esc_attr($role); ?>" class="regular-text"
                       placeholder="例: 人事部長"></td>
        </tr>
    </table>
    <p class="description">本文欄にお客様のコメントを入力してください。</p>
    <?php
}

function ennoshita_save_testimonial_meta($post_id) {
    if (!isset($_POST['_testimonial_nonce']) || !wp_verify_nonce($_POST['_testimonial_nonce'], 'ennoshita_testimonial_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['testimonial_company'])) {
        update_post_meta($post_id, '_testimonial_company', sanitize_text_field($_POST['testimonial_company']));
    }
    if (isset($_POST['testimonial_role'])) {
        update_post_meta($post_id, '_testimonial_role', sanitize_text_field($_POST['testimonial_role']));
    }
}
add_action('save_post_testimonial', 'ennoshita_save_testimonial_meta');


// ==============================================
// 10. ウィジェット
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
        'default'           => '「人が育てば組織が変わる」――岡山を拠点に、人材育成・人事制度構築・組織開発の3つの柱で、100社以上の企業様の組織変革を支援してきました。',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('ennoshita_hero_description', [
        'label'   => 'ヒーロー説明文',
        'section' => 'ennoshita_hero',
        'type'    => 'textarea',
    ]);

    // 代表メッセージセクション
    $wp_customize->add_section('ennoshita_message', [
        'title'    => '代表メッセージ',
        'priority' => 32,
    ]);

    $wp_customize->add_setting('ennoshita_representative_photo', ['default' => '']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ennoshita_representative_photo', [
        'label'       => '代表写真',
        'description' => '推奨サイズ: 400×500px（縦長）',
        'section'     => 'ennoshita_message',
    ]));

    // ロゴ設定セクション
    $wp_customize->add_section('ennoshita_logo', [
        'title'       => 'ロゴ設定',
        'description' => '合体ロゴ、またはシンボルマーク＋テキストロゴを個別に設定できます。合体ロゴが設定されている場合はそちらが優先されます。',
        'priority'    => 20,
    ]);

    $wp_customize->add_setting('ennoshita_logo_combined', ['default' => '']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ennoshita_logo_combined', [
        'label'       => '合体ロゴ画像（優先）',
        'description' => 'シンボルマーク＋社名が一体になった画像（推奨: 高さ40〜50px、PNG/SVG透過）。設定すると下の個別ロゴより優先されます。',
        'section'     => 'ennoshita_logo',
    ]));

    $wp_customize->add_setting('ennoshita_logo_symbol', ['default' => '']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ennoshita_logo_symbol', [
        'label'       => 'シンボルマーク（個別）',
        'description' => '会社名の先頭に表示するアイコンロゴ（推奨: 正方形 80×80px、PNG/SVG透過）',
        'section'     => 'ennoshita_logo',
    ]));

    $wp_customize->add_setting('ennoshita_logo_text_image', ['default' => '']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ennoshita_logo_text_image', [
        'label'       => 'テキストロゴ画像（個別）',
        'description' => '「株式会社えんのした」の画像ロゴ（推奨: 高さ40px程度、PNG/SVG透過）',
        'section'     => 'ennoshita_logo',
    ]));

    // 理念セクション画像
    $wp_customize->add_section('ennoshita_philosophy', [
        'title'    => '理念セクション',
        'priority' => 31,
    ]);

    $wp_customize->add_setting('ennoshita_philosophy_image', ['default' => '']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ennoshita_philosophy_image', [
        'label'       => '理念セクション画像',
        'description' => '推奨サイズ: 540×405px（横長4:3）。未設定の場合はデフォルト画像が表示されます。',
        'section'     => 'ennoshita_philosophy',
    ]));

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

    // SNSリンク
    $wp_customize->add_section('ennoshita_sns', [
        'title'    => 'SNSリンク',
        'priority' => 38,
    ]);

    foreach (['x' => 'X (Twitter)', 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn'] as $key => $label) {
        $wp_customize->add_setting("ennoshita_sns_{$key}", [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control("ennoshita_sns_{$key}", [
            'label'   => "{$label} URL",
            'section' => 'ennoshita_sns',
            'type'    => 'url',
        ]);
    }

    // GA / GTM
    $wp_customize->add_section('ennoshita_analytics', [
        'title'       => 'アクセス解析',
        'description' => 'Google Analytics や Google Tag Manager の計測ID を入力してください。',
        'priority'    => 39,
    ]);

    $wp_customize->add_setting('ennoshita_ga4_id', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ennoshita_ga4_id', [
        'label'       => 'GA4 測定ID',
        'description' => '例: G-XXXXXXXXXX',
        'section'     => 'ennoshita_analytics',
        'type'        => 'text',
    ]);

    $wp_customize->add_setting('ennoshita_gtm_id', [
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ennoshita_gtm_id', [
        'label'       => 'GTM コンテナID',
        'description' => '例: GTM-XXXXXXX（GA4 ID と同時に設定した場合は GTM が優先されます）',
        'section'     => 'ennoshita_analytics',
        'type'        => 'text',
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
// 13. Google Analytics / Tag Manager
// ==============================================

// GA4 または GTM の <head> 内タグ出力
function ennoshita_output_analytics_head() {
    $gtm_id = get_theme_mod('ennoshita_gtm_id');
    $ga4_id = get_theme_mod('ennoshita_ga4_id');

    if ($gtm_id) {
        printf(
            "<!-- Google Tag Manager -->\n<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','%s');</script>\n<!-- End Google Tag Manager -->\n",
            esc_js($gtm_id)
        );
    } elseif ($ga4_id) {
        printf(
            "<!-- Google Analytics (GA4) -->\n<script async src=\"https://www.googletagmanager.com/gtag/js?id=%1\$s\"></script>\n<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','%1\$s');</script>\n",
            esc_attr($ga4_id)
        );
    }
}
add_action('wp_head', 'ennoshita_output_analytics_head', 0);

// GTM の <body> 直後の noscript タグ
function ennoshita_output_gtm_body() {
    $gtm_id = get_theme_mod('ennoshita_gtm_id');
    if ($gtm_id) {
        printf(
            '<!-- Google Tag Manager (noscript) --><noscript><iframe src="https://www.googletagmanager.com/ns.html?id=%s" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript><!-- End Google Tag Manager (noscript) -->' . "\n",
            esc_attr($gtm_id)
        );
    }
}
add_action('wp_body_open', 'ennoshita_output_gtm_body', 0);


// ==============================================
// 14. セキュリティ対策
// ==============================================

// セキュリティヘッダー
function ennoshita_security_headers() {
    if (is_admin()) return;
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}
add_action('send_headers', 'ennoshita_security_headers');

// XML-RPC無効化（ブルートフォース攻撃防止）
add_filter('xmlrpc_enabled', '__return_false');

// XML-RPCの pingback メソッド無効化
function ennoshita_remove_xmlrpc_pingback($methods) {
    unset($methods['pingback.ping']);
    unset($methods['pingback.extensions.getPingbacks']);
    return $methods;
}
add_filter('xmlrpc_methods', 'ennoshita_remove_xmlrpc_pingback');

// REST APIのユーザー列挙を防止
function ennoshita_restrict_user_rest_api($result, $server, $request) {
    $route = $request->get_route();
    if (preg_match('/\/wp\/v2\/users/', $route) && !current_user_can('list_users')) {
        return new WP_Error('rest_forbidden', 'アクセスが拒否されました。', ['status' => 403]);
    }
    return $result;
}
add_filter('rest_pre_dispatch', 'ennoshita_restrict_user_rest_api', 10, 3);

// ユーザー列挙（?author=N）を防止
function ennoshita_prevent_author_enum() {
    if (!is_admin() && isset($_GET['author']) && !current_user_can('list_users')) {
        wp_safe_redirect(home_url('/'), 301);
        exit;
    }
}
add_action('init', 'ennoshita_prevent_author_enum');

// ログインエラーメッセージを一般化（ユーザー名漏洩防止）
function ennoshita_login_error_message() {
    return 'ログイン情報が正しくありません。';
}
add_filter('login_errors', 'ennoshita_login_error_message');

// コメントをデフォルト無効化（スパム対策）
function ennoshita_disable_comments_defaults() {
    update_option('default_comment_status', 'closed');
    update_option('default_ping_status', 'closed');
}
add_action('after_switch_theme', 'ennoshita_disable_comments_defaults');

// テーマ有効化時にリライトルールをフラッシュ（CPTの404対策）
function ennoshita_flush_rewrite_rules() {
    ennoshita_register_testimonial_cpt();
    ennoshita_register_case_study_cpt();
    ennoshita_register_team_member_cpt();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'ennoshita_flush_rewrite_rules');

// 既存投稿のコメントもフロントでは無効化
function ennoshita_close_comments($open) {
    return false;
}
add_filter('comments_open', 'ennoshita_close_comments', 20, 1);
add_filter('pings_open', 'ennoshita_close_comments', 20, 1);

// コメントフォームとコメント数を非表示
function ennoshita_hide_comments($comments) {
    return [];
}
add_filter('comments_array', 'ennoshita_hide_comments', 20, 1);


// サービス子ページに自動的に page-service.php テンプレートを適用
function ennoshita_service_child_template($template) {
    if (is_page()) {
        $post = get_queried_object();
        if ($post && $post->post_parent) {
            $parent = get_post($post->post_parent);
            if ($parent && $parent->post_name === 'service') {
                $service_template = locate_template('page-service.php');
                if ($service_template) {
                    return $service_template;
                }
            }
        }
    }
    return $template;
}
add_filter('template_include', 'ennoshita_service_child_template');


// ==============================================
// 14. サービスデータ一元管理
// ==============================================

/**
 * 3つのサービス情報を一元管理する関数
 * front-page.php と page-service.php の重複を排除
 */
function ennoshita_get_services() {
    return [
        [
            'slug'     => '/service/training/',
            'number'   => 'SERVICE 01',
            'title'    => '組織の頭脳を育む',
            'subtitle' => '人材育成サービス',
            'text'     => '多様な学びの場を提供し、次世代リーダーに必要な知識・スキル・マインドを体系的に育成します。',
            'icon'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
        ],
        [
            'slug'     => '/service/hr-system/',
            'number'   => 'SERVICE 02',
            'title'    => '組織の背骨を整える',
            'subtitle' => '人事制度構築支援',
            'text'     => '評価制度・等級制度・報酬制度など、公正で納得感のある人事制度の構築・運用を支援します。',
            'icon'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>',
        ],
        [
            'slug'     => '/service/organization/',
            'number'   => 'SERVICE 03',
            'title'    => '組織の筋力を鍛える',
            'subtitle' => '組織開発支援',
            'text'     => 'チームの関係性を強化し、自律的に課題を解決できる強い組織づくりをサポートします。',
            'icon'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        ],
    ];
}


// ==============================================
// 15. サービスページ用カスタムフィールド
// ==============================================

function ennoshita_service_meta_boxes() {
    add_meta_box(
        'service_details',
        'サービス詳細情報',
        'ennoshita_service_meta_box_html',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'ennoshita_service_meta_boxes');

function ennoshita_service_meta_box_html($post) {
    // サービス詳細ページテンプレートを使用しているか判定
    $template = get_page_template_slug($post->ID);
    $is_service_page = ($template === 'page-service.php');

    // テンプレート未選択でも、親ページのスラッグが 'service' ならサービス子ページ
    if (!$is_service_page && $post->post_parent) {
        $parent = get_post($post->post_parent);
        if ($parent && $parent->post_name === 'service') {
            $is_service_page = true;
        }
    }
    // スラッグが 'service' のページ自体もOK
    if (!$is_service_page && $post->post_name === 'service') {
        $is_service_page = true;
    }

    if (!$is_service_page) {
        echo '<p style="color:#666">このメタボックスは「サービス詳細ページ」テンプレートを選択しているページ、またはサービス（/service/）の子ページで使用します。<br>子ページの場合はページ属性の「親ページ」を「サービス一覧」に設定してください。</p>';
    }

    wp_nonce_field('ennoshita_service_nonce', '_service_nonce');

    $fields = [
        '_service_number'    => get_post_meta($post->ID, '_service_number', true),
        '_service_overview'  => get_post_meta($post->ID, '_service_overview', true),
        '_service_targets'   => get_post_meta($post->ID, '_service_targets', true),
        '_service_programs'  => get_post_meta($post->ID, '_service_programs', true),
        '_service_outcomes'  => get_post_meta($post->ID, '_service_outcomes', true),
        '_service_faq'       => get_post_meta($post->ID, '_service_faq', true),
    ];

    // サンプルデータで未入力フィールドを事前投入
    $sample_loaded = false;
    if (!$fields['_service_overview'] && function_exists('ennoshita_get_service_sample_data')) {
        $sample = ennoshita_get_service_sample_data($post->post_name);
        if ($sample) {
            if (!$fields['_service_number'])   $fields['_service_number']   = $sample['number'];
            if (!$fields['_service_overview']) $fields['_service_overview'] = $sample['overview'];
            if (!$fields['_service_targets'])  $fields['_service_targets']  = $sample['targets'];
            if (!$fields['_service_programs']) $fields['_service_programs'] = $sample['programs'];
            if (!$fields['_service_outcomes']) $fields['_service_outcomes'] = $sample['outcomes'];
            if (!$fields['_service_faq'])      $fields['_service_faq']      = $sample['faq'];
            $sample_loaded = true;
        }
    }
    ?>
    <?php if ($sample_loaded) : ?>
        <div class="notice notice-info inline" style="margin:10px 0"><p>サンプルデータが表示されています。内容を編集して「更新」を押すと、カスタムデータとして保存されます。</p></div>
    <?php endif; ?>
    <table class="form-table">
        <tr>
            <th><label for="service_number">サービス番号</label></th>
            <td><input type="text" id="service_number" name="service_number" value="<?php echo esc_attr($fields['_service_number']); ?>" class="regular-text" placeholder="例: SERVICE 01"></td>
        </tr>
        <tr>
            <th><label for="service_overview">サービス概要</label></th>
            <td><textarea id="service_overview" name="service_overview" rows="3" class="large-text" placeholder="このサービスの具体的な概要（2-3文）"><?php echo esc_textarea($fields['_service_overview']); ?></textarea></td>
        </tr>
        <tr>
            <th><label for="service_targets">こんな企業様におすすめ</label></th>
            <td>
                <textarea id="service_targets" name="service_targets" rows="5" class="large-text" placeholder="1行に1項目ずつ記入&#10;例:&#10;管理職のマネジメント力を強化したい&#10;新入社員の早期戦力化を図りたい"><?php echo esc_textarea($fields['_service_targets']); ?></textarea>
                <p class="description">1行に1項目ずつ記入してください。</p>
            </td>
        </tr>
        <tr>
            <th><label for="service_programs">プログラム/メニュー一覧</label></th>
            <td>
                <textarea id="service_programs" name="service_programs" rows="8" class="large-text" placeholder="タイトル|説明|期間|対象 の形式で1行1プログラム&#10;例:&#10;管理職リーダーシップ研修|部下育成・チーム運営・目標管理を実践的に学ぶ|2日間（集合研修）|管理職・課長クラス&#10;新入社員ビジネス基礎研修|社会人としての基礎力を短期集中で養成|3日間|新入社員"><?php echo esc_textarea($fields['_service_programs']); ?></textarea>
                <p class="description">「タイトル|説明|期間|対象」の形式で、1行に1プログラムずつ記入してください。</p>
            </td>
        </tr>
        <tr>
            <th><label for="service_outcomes">導入効果・期待される成果</label></th>
            <td>
                <textarea id="service_outcomes" name="service_outcomes" rows="5" class="large-text" placeholder="1行に1項目ずつ記入&#10;例:&#10;管理職の部下育成スキルが向上し、離職率が20%改善&#10;1on1ミーティングの質が向上"><?php echo esc_textarea($fields['_service_outcomes']); ?></textarea>
                <p class="description">1行に1項目ずつ記入してください。</p>
            </td>
        </tr>
    </table>

    <h3 style="margin-top:2em;padding-top:1em;border-top:1px solid #ddd;">導入事例</h3>
    <p style="color:#666;padding:8px 0;">導入事例は「実績事例」メニューから管理できます。各事例の「サービス種別」を設定すると、対応するサービスページにカルーセル形式で自動表示されます。</p>
    <p style="color:#666;padding:4px 0;">提供プログラムは「提供プログラム」メニューから管理できます。各プログラムの「対象サービス」を設定してください。</p>

    <h3 style="margin-top:2em;padding-top:1em;border-top:1px solid #ddd;">よくあるご質問（FAQ）</h3>
    <table class="form-table">
        <tr>
            <th><label for="service_faq">FAQ</label></th>
            <td>
                <textarea id="service_faq" name="service_faq" rows="10" class="large-text" placeholder="質問|回答 の形式で1行1問ずつ&#10;例:&#10;研修の最少催行人数は？|5名様からご対応可能です。少人数ならではの密度の濃い研修が実現できます。&#10;オンラインでも実施できますか？|はい。Zoom等を活用したオンライン研修にも対応しております。"><?php echo esc_textarea($fields['_service_faq']); ?></textarea>
                <p class="description">「質問|回答」の形式で、1行に1問ずつ記入してください。</p>
            </td>
        </tr>
    </table>
    <?php
}

function ennoshita_save_service_meta($post_id) {
    if (!isset($_POST['_service_nonce']) || !wp_verify_nonce($_POST['_service_nonce'], 'ennoshita_service_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $text_fields = ['service_number'];
    foreach ($text_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, "_{$field}", sanitize_text_field($_POST[$field]));
        }
    }

    $textarea_fields = ['service_overview', 'service_targets', 'service_programs',
        'service_outcomes', 'service_faq'];
    foreach ($textarea_fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, "_{$field}", sanitize_textarea_field($_POST[$field]));
        }
    }
}
add_action('save_post_page', 'ennoshita_save_service_meta');


// ==============================================
// 16. カスタム投稿タイプ: 実績事例
// ==============================================
function ennoshita_register_case_study_cpt() {
    register_post_type('case_study', [
        'labels' => [
            'name'               => '実績事例',
            'singular_name'      => '実績事例',
            'add_new'            => '新規追加',
            'add_new_item'       => '実績事例を追加',
            'edit_item'          => '実績事例を編集',
            'new_item'           => '新しい実績事例',
            'view_item'          => '実績事例を表示',
            'search_items'       => '実績事例を検索',
            'not_found'          => '実績事例が見つかりません',
            'menu_name'          => '実績事例',
        ],
        'public'       => true,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-awards',
        'menu_position' => 26,
        'supports'     => ['title', 'editor', 'thumbnail'],
        'has_archive'  => true,
        'rewrite'      => ['slug' => 'case-study'],
    ]);
}
add_action('init', 'ennoshita_register_case_study_cpt');

function ennoshita_case_study_meta_boxes() {
    add_meta_box('case_study_details', '事例情報', 'ennoshita_case_study_meta_box_html', 'case_study', 'normal', 'high');
}
add_action('add_meta_boxes', 'ennoshita_case_study_meta_boxes');

function ennoshita_case_study_meta_box_html($post) {
    $fields = [
        '_cs_company'   => get_post_meta($post->ID, '_cs_company', true),
        '_cs_industry'  => get_post_meta($post->ID, '_cs_industry', true),
        '_cs_employees' => get_post_meta($post->ID, '_cs_employees', true),
        '_cs_service'   => get_post_meta($post->ID, '_cs_service', true),
        '_cs_challenge' => get_post_meta($post->ID, '_cs_challenge', true),
        '_cs_solution'  => get_post_meta($post->ID, '_cs_solution', true),
        '_cs_result'    => get_post_meta($post->ID, '_cs_result', true),
        '_cs_duration'  => get_post_meta($post->ID, '_cs_duration', true),
        '_cs_quote'     => get_post_meta($post->ID, '_cs_quote', true),
        '_cs_role'      => get_post_meta($post->ID, '_cs_role', true),
    ];
    wp_nonce_field('ennoshita_cs_nonce', '_cs_nonce');
    ?>
    <table class="form-table">
        <tr><th><label for="cs_company">企業名</label></th>
            <td><input type="text" id="cs_company" name="cs_company" value="<?php echo esc_attr($fields['_cs_company']); ?>" class="regular-text" placeholder="例: 株式会社A（匿名可）"></td></tr>
        <tr><th><label for="cs_industry">業種</label></th>
            <td><input type="text" id="cs_industry" name="cs_industry" value="<?php echo esc_attr($fields['_cs_industry']); ?>" class="regular-text" placeholder="例: 製造業"></td></tr>
        <tr><th><label for="cs_employees">従業員数</label></th>
            <td><input type="text" id="cs_employees" name="cs_employees" value="<?php echo esc_attr($fields['_cs_employees']); ?>" class="regular-text" placeholder="例: 300名"></td></tr>
        <tr><th><label for="cs_service">サービス種別</label></th>
            <td><select id="cs_service" name="cs_service">
                <option value="">選択してください</option>
                <option value="training" <?php selected($fields['_cs_service'], 'training'); ?>>人材育成サービス</option>
                <option value="hr-system" <?php selected($fields['_cs_service'], 'hr-system'); ?>>人事制度構築支援</option>
                <option value="organization" <?php selected($fields['_cs_service'], 'organization'); ?>>組織開発支援</option>
            </select></td></tr>
        <tr><th><label for="cs_duration">支援期間</label></th>
            <td><input type="text" id="cs_duration" name="cs_duration" value="<?php echo esc_attr($fields['_cs_duration']); ?>" class="regular-text" placeholder="例: 6ヶ月"></td></tr>
        <tr><th><label for="cs_challenge">課題</label></th>
            <td><textarea id="cs_challenge" name="cs_challenge" rows="3" class="large-text"><?php echo esc_textarea($fields['_cs_challenge']); ?></textarea></td></tr>
        <tr><th><label for="cs_solution">実施内容</label></th>
            <td><textarea id="cs_solution" name="cs_solution" rows="3" class="large-text"><?php echo esc_textarea($fields['_cs_solution']); ?></textarea></td></tr>
        <tr><th><label for="cs_result">成果</label></th>
            <td><textarea id="cs_result" name="cs_result" rows="3" class="large-text"><?php echo esc_textarea($fields['_cs_result']); ?></textarea></td></tr>
        <tr><th><label for="cs_quote">担当者の声</label></th>
            <td><textarea id="cs_quote" name="cs_quote" rows="3" class="large-text"><?php echo esc_textarea($fields['_cs_quote']); ?></textarea></td></tr>
        <tr><th><label for="cs_role">肩書き</label></th>
            <td><input type="text" id="cs_role" name="cs_role" value="<?php echo esc_attr($fields['_cs_role']); ?>" class="regular-text" placeholder="例: 人事部長"></td></tr>
    </table>
    <?php
}

function ennoshita_save_case_study_meta($post_id) {
    if (!isset($_POST['_cs_nonce']) || !wp_verify_nonce($_POST['_cs_nonce'], 'ennoshita_cs_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $text_fields = ['cs_company', 'cs_industry', 'cs_employees', 'cs_service', 'cs_duration', 'cs_role'];
    foreach ($text_fields as $f) {
        if (isset($_POST[$f])) update_post_meta($post_id, "_{$f}", sanitize_text_field($_POST[$f]));
    }
    $textarea_fields = ['cs_challenge', 'cs_solution', 'cs_result', 'cs_quote'];
    foreach ($textarea_fields as $f) {
        if (isset($_POST[$f])) update_post_meta($post_id, "_{$f}", sanitize_textarea_field($_POST[$f]));
    }
}
add_action('save_post_case_study', 'ennoshita_save_case_study_meta');


// ==============================================
// 17. カスタム投稿タイプ: チームメンバー
// ==============================================
function ennoshita_register_team_cpt() {
    register_post_type('team_member', [
        'labels' => [
            'name'          => 'チーム紹介',
            'singular_name' => 'チームメンバー',
            'add_new_item'  => 'メンバーを追加',
            'edit_item'     => 'メンバーを編集',
            'menu_name'     => 'チーム紹介',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-groups',
        'menu_position' => 27,
        'supports'     => ['title', 'editor', 'thumbnail'],
        'has_archive'  => false,
    ]);
}
add_action('init', 'ennoshita_register_team_cpt');

function ennoshita_team_meta_boxes() {
    add_meta_box('team_details', 'メンバー情報', 'ennoshita_team_meta_box_html', 'team_member', 'normal', 'high');
}
add_action('add_meta_boxes', 'ennoshita_team_meta_boxes');

function ennoshita_team_meta_box_html($post) {
    $position    = get_post_meta($post->ID, '_team_position', true);
    $specialty   = get_post_meta($post->ID, '_team_specialty', true);
    $credentials = get_post_meta($post->ID, '_team_credentials', true);
    wp_nonce_field('ennoshita_team_nonce', '_team_nonce');
    ?>
    <table class="form-table">
        <tr><th><label for="team_position">肩書き</label></th>
            <td><input type="text" id="team_position" name="team_position" value="<?php echo esc_attr($position); ?>" class="regular-text" placeholder="例: 代表取締役 / シニアコンサルタント"></td></tr>
        <tr><th><label for="team_specialty">専門分野</label></th>
            <td><input type="text" id="team_specialty" name="team_specialty" value="<?php echo esc_attr($specialty); ?>" class="regular-text" placeholder="例: リーダーシップ開発、組織文化変革"></td></tr>
        <tr><th><label for="team_credentials">保有資格</label></th>
            <td><textarea id="team_credentials" name="team_credentials" rows="3" class="large-text" placeholder="1行に1資格ずつ記入"><?php echo esc_textarea($credentials); ?></textarea></td></tr>
    </table>
    <p class="description">本文欄にプロフィール・経歴を入力してください。</p>
    <?php
}

function ennoshita_save_team_meta($post_id) {
    if (!isset($_POST['_team_nonce']) || !wp_verify_nonce($_POST['_team_nonce'], 'ennoshita_team_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    foreach (['team_position', 'team_specialty'] as $f) {
        if (isset($_POST[$f])) update_post_meta($post_id, "_{$f}", sanitize_text_field($_POST[$f]));
    }
    if (isset($_POST['team_credentials'])) {
        update_post_meta($post_id, '_team_credentials', sanitize_textarea_field($_POST['team_credentials']));
    }
}
add_action('save_post_team_member', 'ennoshita_save_team_meta');


// ==============================================
// 18. ユーティリティ関数
// ==============================================

/**
 * コラム（ブログ）一覧ページの URL を取得
 *
 * 優先順位:
 * 1. 投稿ページ（Settings > Reading で設定）の URL
 * 2. フロントページと異なる投稿アーカイブ URL
 * 3. /blog/ へのフォールバック
 */
function ennoshita_get_blog_url() {
    // 投稿ページが設定されていればそのパーマリンクを返す
    $posts_page_id = get_option('page_for_posts');
    if ($posts_page_id) {
        return get_permalink($posts_page_id);
    }

    // 投稿アーカイブリンクがフロントページと異なれば使用
    $archive_link = get_post_type_archive_link('post');
    $home = trailingslashit(home_url('/'));
    if ($archive_link && trailingslashit($archive_link) !== $home) {
        return $archive_link;
    }

    // フォールバック: /blog/
    return home_url('/blog/');
}

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
 * ロゴを出力
 *
 * 優先順位:
 * 1. 合体ロゴ画像（シンボル＋社名が一体の画像）
 * 2. シンボルマーク + テキストロゴ画像（個別設定）
 * 3. WordPress標準カスタムロゴ
 * 4. テキスト表示
 *
 * 画像ロゴが表示される場合、テキストは screen-reader-text（SEO用に保持）。
 */
function ennoshita_the_logo($class = 'site-logo') {
    $combined_url   = get_theme_mod('ennoshita_logo_combined');
    $symbol_url     = get_theme_mod('ennoshita_logo_symbol');
    $text_image_url = get_theme_mod('ennoshita_logo_text_image');
    $custom_logo_id = get_theme_mod('custom_logo');
    $site_name      = get_bloginfo('name');
    $has_image_logo = $combined_url || $symbol_url || $text_image_url || $custom_logo_id;

    echo '<a href="' . esc_url(home_url('/')) . '" class="' . esc_attr($class) . '" rel="home">';

    if ($combined_url) {
        // 合体ロゴ（最優先）
        echo '<img src="' . esc_url($combined_url) . '" alt="' . esc_attr($site_name) . '" class="site-logo__combined">';
    } else {
        // シンボルマーク（個別）
        if ($symbol_url) {
            echo '<img src="' . esc_url($symbol_url) . '" alt="" class="site-logo__symbol" width="40" height="40">';
        }

        // テキストロゴ画像（個別）
        if ($text_image_url) {
            echo '<img src="' . esc_url($text_image_url) . '" alt="' . esc_attr($site_name) . '" class="site-logo__image">';
        } elseif ($custom_logo_id) {
            echo wp_get_attachment_image($custom_logo_id, 'full', false, [
                'class' => 'site-logo__image custom-logo',
                'alt'   => $site_name,
            ]);
        }
    }

    // テキスト: 画像ロゴがあればSEO用に非表示、なければ表示
    $text_class = $has_image_logo ? 'site-logo__text screen-reader-text' : 'site-logo__text';
    echo '<span class="' . $text_class . '">';
    echo '<span class="site-logo__main">株式会社えんのした</span>';
    echo '<span class="site-logo__sub">ENNOSHITA</span>';
    echo '</span>';
    echo '</a>';
}


// ==============================================
// 15. お問い合わせフォーム処理
// ==============================================
function ennoshita_handle_contact_form() {
    if (!isset($_POST['_wpnonce_contact']) || !wp_verify_nonce($_POST['_wpnonce_contact'], 'ennoshita_contact_nonce')) {
        wp_die('不正なリクエストです。');
    }

    $company = sanitize_text_field($_POST['company'] ?? '');
    $name    = sanitize_text_field($_POST['name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $phone   = sanitize_text_field($_POST['phone'] ?? '');
    $subject = sanitize_text_field($_POST['subject'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if (empty($company) || empty($name) || empty($email) || empty($subject) || empty($message)) {
        wp_safe_redirect(add_query_arg('contact', 'error', wp_get_referer()));
        exit;
    }

    $admin_email = get_option('admin_email');
    $site_name   = get_bloginfo('name');

    $mail_subject = "【{$site_name}】お問い合わせ: {$subject}";
    $mail_body    = "以下のお問い合わせがありました。\n\n"
                  . "━━━━━━━━━━━━━━━━━━━━━━\n"
                  . "会社名: {$company}\n"
                  . "お名前: {$name}\n"
                  . "メール: {$email}\n"
                  . "電話番号: {$phone}\n"
                  . "ご相談内容: {$subject}\n"
                  . "━━━━━━━━━━━━━━━━━━━━━━\n\n"
                  . "メッセージ:\n{$message}\n";

    $headers = [
        "From: {$site_name} <{$admin_email}>",
        "Reply-To: {$name} <{$email}>",
        "Content-Type: text/plain; charset=UTF-8",
    ];

    $sent = wp_mail($admin_email, $mail_subject, $mail_body, $headers);

    if ($sent) {
        wp_safe_redirect(add_query_arg('contact', 'success', wp_get_referer()));
    } else {
        wp_safe_redirect(add_query_arg('contact', 'error', wp_get_referer()));
    }
    exit;
}
add_action('admin_post_nopriv_ennoshita_contact', 'ennoshita_handle_contact_form');
add_action('admin_post_ennoshita_contact', 'ennoshita_handle_contact_form');


// ==============================================
// 21. カスタム投稿タイプ: 提供プログラム
// ==============================================
function ennoshita_register_service_program_cpt() {
    register_post_type('service_program', [
        'labels' => [
            'name'               => '提供プログラム',
            'singular_name'      => '提供プログラム',
            'add_new'            => '新規追加',
            'add_new_item'       => 'プログラムを追加',
            'edit_item'          => 'プログラムを編集',
            'new_item'           => '新しいプログラム',
            'view_item'          => 'プログラムを表示',
            'search_items'       => 'プログラムを検索',
            'not_found'          => 'プログラムが見つかりません',
            'menu_name'          => '提供プログラム',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-welcome-learn-more',
        'menu_position' => 25,
        'supports'     => ['title', 'editor'],
        'has_archive'  => false,
    ]);
}
add_action('init', 'ennoshita_register_service_program_cpt');

function ennoshita_service_program_meta_boxes() {
    add_meta_box('program_details', 'プログラム情報', 'ennoshita_program_meta_box_html', 'service_program', 'normal', 'high');
}
add_action('add_meta_boxes', 'ennoshita_service_program_meta_boxes');

function ennoshita_program_meta_box_html($post) {
    $service  = get_post_meta($post->ID, '_prog_service', true);
    $duration = get_post_meta($post->ID, '_prog_duration', true);
    $audience = get_post_meta($post->ID, '_prog_audience', true);
    $order    = get_post_meta($post->ID, '_prog_order', true);
    wp_nonce_field('ennoshita_prog_nonce', '_prog_nonce');
    ?>
    <table class="form-table">
        <tr>
            <th><label for="prog_service">対象サービス</label></th>
            <td><select id="prog_service" name="prog_service">
                <option value="">選択してください</option>
                <option value="training" <?php selected($service, 'training'); ?>>人材育成サービス</option>
                <option value="hr-system" <?php selected($service, 'hr-system'); ?>>人事制度構築支援</option>
                <option value="organization" <?php selected($service, 'organization'); ?>>組織開発支援</option>
            </select></td>
        </tr>
        <tr>
            <th><label for="prog_duration">期間</label></th>
            <td><input type="text" id="prog_duration" name="prog_duration" value="<?php echo esc_attr($duration); ?>" class="regular-text" placeholder="例: 2日間（集合研修）"></td>
        </tr>
        <tr>
            <th><label for="prog_audience">対象者</label></th>
            <td><input type="text" id="prog_audience" name="prog_audience" value="<?php echo esc_attr($audience); ?>" class="regular-text" placeholder="例: 管理職・課長クラス"></td>
        </tr>
        <tr>
            <th><label for="prog_order">表示順</label></th>
            <td><input type="number" id="prog_order" name="prog_order" value="<?php echo esc_attr($order ?: '0'); ?>" class="small-text">
            <p class="description">数字が小さいほど先に表示されます。</p></td>
        </tr>
    </table>
    <p class="description">タイトル欄にプログラム名、本文欄にプログラムの説明を入力してください。</p>
    <?php
}

function ennoshita_save_program_meta($post_id) {
    if (!isset($_POST['_prog_nonce']) || !wp_verify_nonce($_POST['_prog_nonce'], 'ennoshita_prog_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    foreach (['prog_service', 'prog_duration', 'prog_audience'] as $f) {
        if (isset($_POST[$f])) update_post_meta($post_id, "_{$f}", sanitize_text_field($_POST[$f]));
    }
    if (isset($_POST['prog_order'])) {
        update_post_meta($post_id, '_prog_order', intval($_POST['prog_order']));
    }
}
add_action('save_post_service_program', 'ennoshita_save_program_meta');


// ==============================================
// 22. コラム記事の関連サービス設定
// ==============================================
function ennoshita_post_service_meta_box() {
    add_meta_box(
        'post_related_service',
        '関連サービス',
        'ennoshita_post_service_meta_html',
        'post',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'ennoshita_post_service_meta_box');

function ennoshita_post_service_meta_html($post) {
    $current = get_post_meta($post->ID, '_related_service', true);
    wp_nonce_field('ennoshita_post_service_nonce', '_post_service_nonce');
    $services = [
        'training'     => '人材育成サービス',
        'hr-system'    => '人事制度構築支援',
        'organization' => '組織開発支援',
    ];
    ?>
    <p class="description" style="margin-bottom:8px">このコラムを関連付けるサービスを選択してください。サービス詳細ページの「関連コラム」に表示されます。</p>
    <select name="related_service" id="related_service" style="width:100%">
        <option value="">指定なし</option>
        <?php foreach ($services as $val => $label) : ?>
            <option value="<?php echo esc_attr($val); ?>" <?php selected($current, $val); ?>><?php echo esc_html($label); ?></option>
        <?php endforeach; ?>
    </select>
    <?php
}

function ennoshita_save_post_service_meta($post_id) {
    if (!isset($_POST['_post_service_nonce']) || !wp_verify_nonce($_POST['_post_service_nonce'], 'ennoshita_post_service_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['related_service'])) {
        $value = sanitize_text_field($_POST['related_service']);
        if ($value) {
            update_post_meta($post_id, '_related_service', $value);
        } else {
            delete_post_meta($post_id, '_related_service');
        }
    }
}
add_action('save_post', 'ennoshita_save_post_service_meta');


// ==============================================
// 23. ナノバナナプロ（Gemini API）画像自動生成
// ==============================================

/**
 * コラム保存時にアイキャッチ画像がなければ Gemini API で自動生成
 */
function ennoshita_nanobananapro_generate_image($post_id) {
    // 自動保存・リビジョンはスキップ
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (wp_is_post_revision($post_id)) return;
    if (get_post_type($post_id) !== 'post') return;
    if (!current_user_can('edit_post', $post_id)) return;

    // 既にアイキャッチ画像があればスキップ
    if (has_post_thumbnail($post_id)) return;

    // APIキーの確認
    $api_key = get_option('ennoshita_nanobananapro_api_key');
    if (!$api_key) return;

    $post  = get_post($post_id);
    $title = $post->post_title;
    if (!$title) return;

    // 本文から抜粋を取得（プロンプトの参考に）
    $excerpt = wp_trim_words(strip_tags($post->post_content), 50, '');

    // 画像生成プロンプト
    $prompt = sprintf(
        'ビジネスブログ記事「%s」のアイキャッチ画像を生成してください。' .
        '記事の内容: %s。' .
        'スタイル: プロフェッショナルで洗練されたビジネスイラスト、' .
        '暖かみのある緑系のカラーパレット（#1a5632を基調）、' .
        '人材育成・組織開発のコンサルティング企業にふさわしいトーン。' .
        'テキストや文字は一切入れないでください。' .
        'アスペクト比は16:9（横長）で生成してください。',
        $title,
        $excerpt
    );

    // Gemini API（ナノバナナプロ）に画像生成をリクエスト
    $model = get_option('ennoshita_nanobananapro_model', 'gemini-2.0-flash-exp');
    $api_url = sprintf(
        'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s',
        $model,
        $api_key
    );

    $body = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $prompt],
                ],
            ],
        ],
        'generationConfig' => [
            'responseModalities' => ['TEXT', 'IMAGE'],
        ],
    ];

    $response = wp_remote_post($api_url, [
        'timeout' => 60,
        'headers' => ['Content-Type' => 'application/json'],
        'body'    => wp_json_encode($body),
    ]);

    if (is_wp_error($response)) {
        error_log('ナノバナナプロ API エラー: ' . $response->get_error_message());
        return;
    }

    $code = wp_remote_retrieve_response_code($response);
    if ($code !== 200) {
        error_log('ナノバナナプロ API HTTPエラー: ' . $code . ' ' . wp_remote_retrieve_body($response));
        return;
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    // レスポンスから画像データを抽出
    $image_data = null;
    $mime_type  = 'image/png';
    if (!empty($data['candidates'][0]['content']['parts'])) {
        foreach ($data['candidates'][0]['content']['parts'] as $part) {
            if (!empty($part['inlineData'])) {
                $image_data = $part['inlineData']['data'];
                $mime_type  = $part['inlineData']['mimeType'] ?? 'image/png';
                break;
            }
        }
    }

    if (!$image_data) {
        error_log('ナノバナナプロ: 画像データが見つかりません');
        return;
    }

    // Base64デコード & 一時ファイルに保存
    $decoded = base64_decode($image_data);
    if (!$decoded) return;

    $ext = ($mime_type === 'image/jpeg') ? '.jpg' : '.png';
    $filename = 'nanobananapro-' . $post_id . '-' . time() . $ext;
    $upload_dir = wp_upload_dir();
    $filepath   = $upload_dir['path'] . '/' . $filename;

    if (!file_put_contents($filepath, $decoded)) {
        error_log('ナノバナナプロ: ファイル保存に失敗');
        return;
    }

    // WordPressメディアライブラリに登録
    $attachment = [
        'post_mime_type' => $mime_type,
        'post_title'     => sanitize_file_name($title) . ' - AI生成画像',
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    $attach_id = wp_insert_attachment($attachment, $filepath, $post_id);
    if (is_wp_error($attach_id)) {
        error_log('ナノバナナプロ: アタッチメント登録に失敗');
        return;
    }

    // メタデータ生成（サムネイルサイズ等）
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $metadata = wp_generate_attachment_metadata($attach_id, $filepath);
    wp_update_attachment_metadata($attach_id, $metadata);

    // アイキャッチ画像として設定
    set_post_thumbnail($post_id, $attach_id);
}
add_action('save_post', 'ennoshita_nanobananapro_generate_image', 20);

/**
 * 管理画面: ナノバナナプロAPIキー設定ページ
 */
function ennoshita_nanobananapro_settings_page() {
    add_options_page(
        'ナノバナナプロ設定',
        'ナノバナナプロ',
        'manage_options',
        'ennoshita-nanobananapro',
        'ennoshita_nanobananapro_settings_html'
    );
}
add_action('admin_menu', 'ennoshita_nanobananapro_settings_page');

function ennoshita_nanobananapro_settings_html() {
    if (!current_user_can('manage_options')) return;

    if (isset($_POST['_nanobananapro_nonce']) && wp_verify_nonce($_POST['_nanobananapro_nonce'], 'nanobananapro_settings')) {
        update_option('ennoshita_nanobananapro_api_key', sanitize_text_field($_POST['api_key'] ?? ''));
        update_option('ennoshita_nanobananapro_model', sanitize_text_field($_POST['model'] ?? 'gemini-2.0-flash-exp'));
        echo '<div class="notice notice-success"><p>設定を保存しました。</p></div>';
    }

    $api_key = get_option('ennoshita_nanobananapro_api_key', '');
    $model   = get_option('ennoshita_nanobananapro_model', 'gemini-2.0-flash-exp');
    ?>
    <div class="wrap">
        <h1>ナノバナナプロ（Gemini API）設定</h1>
        <p>コラム記事を保存する際、アイキャッチ画像が未設定の場合に Gemini API（ナノバナナプロ）で自動生成します。</p>
        <form method="post">
            <?php wp_nonce_field('nanobananapro_settings', '_nanobananapro_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th><label for="api_key">Gemini API キー</label></th>
                    <td>
                        <input type="password" id="api_key" name="api_key" value="<?php echo esc_attr($api_key); ?>" class="regular-text">
                        <p class="description">Google AI Studio で取得した API キーを入力してください。</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="model">モデル</label></th>
                    <td>
                        <select id="model" name="model">
                            <option value="gemini-2.0-flash-exp" <?php selected($model, 'gemini-2.0-flash-exp'); ?>>Gemini 2.0 Flash (Nano Banana)</option>
                            <option value="gemini-2.5-flash-preview-image" <?php selected($model, 'gemini-2.5-flash-preview-image'); ?>>Gemini 2.5 Flash (Nano Banana 2)</option>
                            <option value="gemini-3-pro-image-preview" <?php selected($model, 'gemini-3-pro-image-preview'); ?>>Gemini 3 Pro Image (Nano Banana Pro)</option>
                        </select>
                        <p class="description">使用する画像生成モデルを選択してください。Nano Banana Pro が最高品質です。</p>
                    </td>
                </tr>
            </table>
            <?php submit_button('設定を保存'); ?>
        </form>
        <hr>
        <h2>使い方</h2>
        <ol>
            <li>Google AI Studio（<code>https://aistudio.google.com/</code>）でAPIキーを取得</li>
            <li>上のフォームにAPIキーを入力して保存</li>
            <li>コラム記事を作成・保存すると、アイキャッチ画像が未設定の場合に自動で画像が生成されます</li>
            <li>生成された画像はメディアライブラリに保存され、アイキャッチに設定されます</li>
        </ol>
        <p><strong>注意:</strong> 既にアイキャッチ画像が設定されている記事では画像は生成されません。再生成したい場合は、アイキャッチ画像を一度削除してから記事を更新してください。</p>
    </div>
    <?php
}

/**
 * テーマ有効化時にリライトルール更新（提供プログラムCPT追加対応）
 */
function ennoshita_flush_rewrite_rules_v2() {
    ennoshita_register_service_program_cpt();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'ennoshita_flush_rewrite_rules_v2');
