<?php
/**
 * カスタム投稿タイプ — お客様の声、チーム、提供プログラム、導入事例
 *
 * @package Ennoshita
 */

// ==============================================
// お客様の声
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
// チームメンバー
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
// 提供プログラム
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
// 導入事例 (case_study)
// ==============================================
function ennoshita_register_case_study_cpt() {
    register_post_type('case_study', [
        'labels' => [
            'name'               => '導入事例',
            'singular_name'      => '導入事例',
            'add_new'            => '新規追加',
            'add_new_item'       => '導入事例を追加',
            'edit_item'          => '導入事例を編集',
            'new_item'           => '新しい導入事例',
            'view_item'          => '導入事例を表示',
            'search_items'       => '導入事例を検索',
            'not_found'          => '導入事例が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に導入事例はありません',
            'menu_name'          => '導入事例',
        ],
        'public'        => true,
        'show_ui'       => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-portfolio',
        'menu_position' => 26,
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'case-study', 'with_front' => false],
        'show_in_rest'  => true,
    ]);
}
add_action('init', 'ennoshita_register_case_study_cpt');

function ennoshita_case_study_meta_boxes() {
    add_meta_box('case_study_details', '導入事例詳細', 'ennoshita_case_study_meta_box_html', 'case_study', 'normal', 'high');
}
add_action('add_meta_boxes', 'ennoshita_case_study_meta_boxes');

function ennoshita_case_study_meta_box_html($post) {
    $company   = get_post_meta($post->ID, '_cs_company', true);
    $industry  = get_post_meta($post->ID, '_cs_industry', true);
    $employees = get_post_meta($post->ID, '_cs_employees', true);
    $duration  = get_post_meta($post->ID, '_cs_duration', true);
    $service   = get_post_meta($post->ID, '_cs_service', true);
    $challenge = get_post_meta($post->ID, '_cs_challenge', true);
    $solution  = get_post_meta($post->ID, '_cs_solution', true);
    $result    = get_post_meta($post->ID, '_cs_result', true);
    $quote     = get_post_meta($post->ID, '_cs_quote', true);
    $role      = get_post_meta($post->ID, '_cs_role', true);
    wp_nonce_field('ennoshita_cs_nonce', '_cs_nonce');
    ?>
    <table class="form-table">
        <tr><th><label for="cs_company">企業名</label></th>
            <td><input type="text" id="cs_company" name="cs_company" value="<?php echo esc_attr($company); ?>" class="regular-text" placeholder="例: 製造業 A社様"></td></tr>
        <tr><th><label for="cs_industry">テーマ</label></th>
            <td><input type="text" id="cs_industry" name="cs_industry" value="<?php echo esc_attr($industry); ?>" class="regular-text" placeholder="例: 管理職研修"></td></tr>
        <tr><th><label for="cs_employees">従業員数</label></th>
            <td><input type="text" id="cs_employees" name="cs_employees" value="<?php echo esc_attr($employees); ?>" class="regular-text" placeholder="例: 350名"></td></tr>
        <tr><th><label for="cs_duration">支援期間</label></th>
            <td><input type="text" id="cs_duration" name="cs_duration" value="<?php echo esc_attr($duration); ?>" class="regular-text" placeholder="例: 6ヶ月"></td></tr>
        <tr><th><label for="cs_service">関連サービス</label></th>
            <td><select id="cs_service" name="cs_service">
                <option value="">選択してください</option>
                <option value="training" <?php selected($service, 'training'); ?>>人材育成サービス</option>
                <option value="hr-system" <?php selected($service, 'hr-system'); ?>>人事制度構築支援</option>
                <option value="organization" <?php selected($service, 'organization'); ?>>組織開発支援</option>
            </select></td></tr>
        <tr><th><label for="cs_challenge">課題</label></th>
            <td><textarea id="cs_challenge" name="cs_challenge" rows="3" class="large-text"><?php echo esc_textarea($challenge); ?></textarea></td></tr>
        <tr><th><label for="cs_solution">施策</label></th>
            <td><textarea id="cs_solution" name="cs_solution" rows="3" class="large-text"><?php echo esc_textarea($solution); ?></textarea></td></tr>
        <tr><th><label for="cs_result">成果</label></th>
            <td><textarea id="cs_result" name="cs_result" rows="3" class="large-text"><?php echo esc_textarea($result); ?></textarea></td></tr>
        <tr><th><label for="cs_quote">お客様の声</label></th>
            <td><textarea id="cs_quote" name="cs_quote" rows="3" class="large-text"><?php echo esc_textarea($quote); ?></textarea></td></tr>
        <tr><th><label for="cs_role">担当者肩書き</label></th>
            <td><input type="text" id="cs_role" name="cs_role" value="<?php echo esc_attr($role); ?>" class="regular-text" placeholder="例: 人事部長"></td></tr>
    </table>
    <?php
}

function ennoshita_save_case_study_meta($post_id) {
    if (!isset($_POST['_cs_nonce']) || !wp_verify_nonce($_POST['_cs_nonce'], 'ennoshita_cs_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $text_fields = ['cs_company', 'cs_industry', 'cs_employees', 'cs_duration', 'cs_service', 'cs_role'];
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
// コラム記事の関連サービス設定
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
    if (get_post_status($post_id) === 'auto-draft') return;
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
add_action('save_post_post', 'ennoshita_save_post_service_meta');

function ennoshita_register_post_meta() {
    register_post_meta('post', '_related_service', [
        'show_in_rest'  => true,
        'single'        => true,
        'type'          => 'string',
        'auth_callback' => function() { return current_user_can('edit_posts'); },
    ]);
}
add_action('init', 'ennoshita_register_post_meta');
