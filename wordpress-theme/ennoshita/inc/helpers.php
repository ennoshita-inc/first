<?php
/**
 * ユーティリティ関数・ヘルパー
 *
 * @package Ennoshita
 */

// ==============================================
// SVGアイコンヘルパー (#21)
// ==============================================
function ennoshita_icon($name, $size = 16) {
    $icons = [
        'arrow-right' => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
        'phone'       => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'mail'        => '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>',
        'map-pin'     => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
        'check'       => '<polyline points="20 6 9 17 4 12"/>',
        'chevron-right' => '<polyline points="9 18 15 12 9 6"/>',
        'users'       => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'award'       => '<circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>',
        'calendar'    => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
        'book-open'   => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
        'download'    => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>',
        'external-link' => '<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>',
        'quote'       => '<path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z"/>',
    ];

    if (!isset($icons[$name])) {
        return '';
    }

    $fill = ($name === 'quote') ? 'currentColor' : 'none';
    $stroke = ($name === 'quote') ? 'none' : 'currentColor';

    return sprintf(
        '<svg class="icon icon--%s" width="%d" height="%d" viewBox="0 0 24 24" fill="%s" stroke="%s" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%s</svg>',
        esc_attr($name),
        intval($size),
        intval($size),
        esc_attr($fill),
        esc_attr($stroke),
        $icons[$name]
    );
}


// ==============================================
// コラム（ブログ）一覧ページの URL を取得
// ==============================================
function ennoshita_get_blog_url() {
    $posts_page_id = get_option('page_for_posts');
    if ($posts_page_id) {
        return get_permalink($posts_page_id);
    }

    $archive_link = get_post_type_archive_link('post');
    $home = trailingslashit(home_url('/'));
    if ($archive_link && trailingslashit($archive_link) !== $home) {
        return $archive_link;
    }

    return home_url('/blog/');
}


// ==============================================
// 投稿の推定読了時間を取得
// ==============================================
function ennoshita_reading_time($post_id = null) {
    $content = get_post_field('post_content', $post_id ?: get_the_ID());
    $word_count = mb_strlen(strip_tags($content));
    $minutes = max(1, ceil($word_count / 600));
    return $minutes;
}


// ==============================================
// ロゴ出力
// ==============================================
function ennoshita_the_logo($class = 'site-logo') {
    $combined_url   = get_theme_mod('ennoshita_logo_combined');
    $symbol_url     = get_theme_mod('ennoshita_logo_symbol');
    $text_image_url = get_theme_mod('ennoshita_logo_text_image');
    $custom_logo_id = get_theme_mod('custom_logo');
    $site_name      = get_bloginfo('name');
    $has_image_logo = $combined_url || $symbol_url || $text_image_url || $custom_logo_id;

    echo '<a href="' . esc_url(home_url('/')) . '" class="' . esc_attr($class) . '" rel="home">';

    if ($combined_url) {
        echo '<img src="' . esc_url($combined_url) . '" alt="' . esc_attr($site_name) . '" class="site-logo__combined">';
    } else {
        if ($symbol_url) {
            echo '<img src="' . esc_url($symbol_url) . '" alt="" class="site-logo__symbol" width="40" height="40">';
        }
        if ($text_image_url) {
            echo '<img src="' . esc_url($text_image_url) . '" alt="' . esc_attr($site_name) . '" class="site-logo__image">';
        } elseif ($custom_logo_id) {
            echo wp_get_attachment_image($custom_logo_id, 'full', false, [
                'class' => 'site-logo__image custom-logo',
                'alt'   => $site_name,
            ]);
        }
    }

    $text_class = $has_image_logo ? 'site-logo__text screen-reader-text' : 'site-logo__text';
    echo '<span class="' . $text_class . '">';
    echo '<span class="site-logo__main">株式会社えんのした</span>';
    echo '<span class="site-logo__sub">ENNOSHITA</span>';
    echo '</span>';
    echo '</a>';
}


// ==============================================
// パンくずリスト
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
    } elseif (is_singular('case_study')) {
        echo '<a href="' . esc_url(get_post_type_archive_link('case_study')) . '">導入事例</a>';
        echo '<span class="breadcrumb__separator" aria-hidden="true">/</span>';
        the_title();
    } elseif (is_post_type_archive('case_study')) {
        echo '導入事例';
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
