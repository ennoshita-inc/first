<?php
/**
 * セキュリティ対策
 *
 * @package Ennoshita
 */

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

// テーマ有効化時にリライトルールをフラッシュ（全CPT対応）
function ennoshita_flush_rewrite_rules() {
    ennoshita_register_testimonial_cpt();
    ennoshita_register_team_cpt();
    ennoshita_register_service_program_cpt();
    ennoshita_register_case_study_cpt();
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
