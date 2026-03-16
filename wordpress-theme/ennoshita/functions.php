<?php
/**
 * 株式会社えんのした WordPress テーマ functions.php v5.0
 *
 * モジュール分割版 — inc/ ディレクトリに機能別ファイルを配置
 *
 * @package Ennoshita
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
// 2. スタイル・スクリプト読み込み
// ==============================================
function ennoshita_enqueue_assets() {
    wp_enqueue_style(
        'ennoshita-style',
        get_stylesheet_uri(),
        [],
        filemtime(get_stylesheet_directory() . '/style.css')
    );

    wp_enqueue_style(
        'ennoshita-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Noto+Sans+JP:wght@400;700&family=Noto+Serif+JP:wght@700;900&display=swap',
        [],
        null
    );

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
function ennoshita_preconnect_fonts($urls, $relation_type) {
    if ($relation_type === 'preconnect') {
        $urls[] = ['href' => 'https://fonts.googleapis.com', 'crossorigin' => false];
        $urls[] = ['href' => 'https://fonts.gstatic.com', 'crossorigin' => true];
    }
    return $urls;
}
add_filter('wp_resource_hints', 'ennoshita_preconnect_fonts', 10, 2);

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

function ennoshita_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
}
add_action('wp_default_scripts', 'ennoshita_remove_jquery_migrate');

function ennoshita_allow_webp($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'ennoshita_allow_webp');

function ennoshita_add_fetchpriority($attr, $attachment, $size) {
    if ($size === 'hero' || $size === 'full') {
        $attr['fetchpriority'] = 'high';
        unset($attr['loading']);
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'ennoshita_add_fetchpriority', 10, 3);

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
// 4. ウィジェット
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
// 5. 抜粋 (excerpt) カスタマイズ
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
// 6. サービス子ページへのテンプレート自動適用
// ==============================================
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
// 7. サービスページ用カスタムフィールド
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
    $template = get_page_template_slug($post->ID);
    $is_service_page = ($template === 'page-service.php');

    if (!$is_service_page && $post->post_parent) {
        $parent = get_post($post->post_parent);
        if ($parent && $parent->post_name === 'service') {
            $is_service_page = true;
        }
    }
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
// 8. モジュール読み込み
// ==============================================
$theme_inc = get_template_directory() . '/inc/';

require_once $theme_inc . 'helpers.php';
require_once $theme_inc . 'seo.php';
require_once $theme_inc . 'cpt.php';
require_once $theme_inc . 'customizer.php';
require_once $theme_inc . 'security.php';
require_once $theme_inc . 'analytics.php';
require_once $theme_inc . 'contact.php';
require_once $theme_inc . 'nanobananapro.php';
require_once $theme_inc . 'service-data.php';
