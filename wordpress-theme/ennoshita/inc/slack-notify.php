<?php
/**
 * 記事公開時のSlack通知
 *
 * 投稿（post）が初めて公開状態になった瞬間に、Slack の Incoming Webhook へ
 * タイトル・URL・カテゴリを送る。予約投稿（future → publish）、即時公開、
 * 過去日付での公開のいずれも対象。更新や再公開では送らない（投稿メタで1回限り）。
 *
 * Webhook URL は秘密情報のため、リポジトリには置かない。
 *   1. wp-config.php の定数 ENNOSHITA_SLACK_WEBHOOK（あれば優先）
 *   2. 外観 > カスタマイズ > Slack通知 で入力した値
 *
 * @package Ennoshita
 */

// Webhook URL を取得（定数を優先）
function ennoshita_slack_webhook_url() {
    if (defined('ENNOSHITA_SLACK_WEBHOOK') && ENNOSHITA_SLACK_WEBHOOK) {
        return (string) ENNOSHITA_SLACK_WEBHOOK;
    }
    return (string) get_theme_mod('ennoshita_slack_webhook', '');
}

// Slack の Webhook URL 以外は受け付けない
function ennoshita_sanitize_slack_webhook($value) {
    $value = trim((string) $value);
    if ($value === '') {
        return '';
    }
    if (strpos($value, 'https://hooks.slack.com/') !== 0) {
        return '';
    }
    return esc_url_raw($value);
}

// Slack へ送信。成功時 true
function ennoshita_slack_send($text) {
    $url = ennoshita_slack_webhook_url();
    if ($url === '') {
        return false;
    }

    $response = wp_remote_post($url, [
        'timeout' => 5,
        'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
        'body'    => wp_json_encode(['text' => $text]),
    ]);

    if (is_wp_error($response)) {
        error_log('[ennoshita] Slack通知に失敗: ' . $response->get_error_message());
        return false;
    }
    if (wp_remote_retrieve_response_code($response) !== 200) {
        error_log('[ennoshita] Slack通知に失敗: HTTP ' . wp_remote_retrieve_response_code($response));
        return false;
    }
    return true;
}

// 公開時の通知本文
function ennoshita_slack_publish_message($post) {
    $title = html_entity_decode(get_the_title($post), ENT_QUOTES, 'UTF-8');
    $link  = get_permalink($post);
    $cats  = wp_list_pluck(get_the_category($post->ID), 'name');
    $date  = get_the_date('Y/n/j H:i', $post);

    $lines = [
        ':newspaper: 記事が公開されました',
        '*<' . $link . '|' . $title . '>*',
    ];
    if ($cats) {
        $lines[] = 'カテゴリ：' . implode('、', $cats);
    }
    $lines[] = '公開日時：' . $date;

    return implode("\n", $lines);
}

function ennoshita_slack_notify_on_publish($new_status, $old_status, $post) {
    if ($new_status !== 'publish' || $old_status === 'publish') {
        return;
    }
    if (!get_theme_mod('ennoshita_slack_enabled', true)) {
        return;
    }
    if ($post->post_type !== 'post' || wp_is_post_revision($post) || wp_is_post_autosave($post)) {
        return;
    }
    // 一度通知した記事は、非公開→再公開しても送らない
    if (get_post_meta($post->ID, '_ennoshita_slack_notified', true)) {
        return;
    }
    if (ennoshita_slack_webhook_url() === '') {
        return;
    }

    if (ennoshita_slack_send(ennoshita_slack_publish_message($post))) {
        update_post_meta($post->ID, '_ennoshita_slack_notified', current_time('mysql'));
    }
}
add_action('transition_post_status', 'ennoshita_slack_notify_on_publish', 10, 3);

// カスタマイザー: 外観 > カスタマイズ > Slack通知
function ennoshita_slack_customize_register($wp_customize) {
    $wp_customize->add_section('ennoshita_slack', [
        'title'       => 'Slack通知',
        'description' => '記事（投稿）が公開されたらSlackに通知します。Webhook URLを保存すると、確認用のテストメッセージが1通届きます。',
        'priority'    => 210,
    ]);

    $wp_customize->add_setting('ennoshita_slack_enabled', [
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ]);
    $wp_customize->add_control('ennoshita_slack_enabled', [
        'label'   => '公開時に通知する',
        'section' => 'ennoshita_slack',
        'type'    => 'checkbox',
    ]);

    $wp_customize->add_setting('ennoshita_slack_webhook', [
        'default'           => '',
        'sanitize_callback' => 'ennoshita_sanitize_slack_webhook',
        'transport'         => 'postMessage',
    ]);
    $wp_customize->add_control('ennoshita_slack_webhook', [
        'label'       => 'Incoming Webhook URL',
        'description' => 'https://hooks.slack.com/services/… で始まるURL',
        'section'     => 'ennoshita_slack',
        'type'        => 'url',
    ]);
}
add_action('customize_register', 'ennoshita_slack_customize_register');

// Webhook URL が新しく保存されたらテスト送信
function ennoshita_slack_before_save() {
    $GLOBALS['ennoshita_slack_prev_webhook'] = (string) get_theme_mod('ennoshita_slack_webhook', '');
}
add_action('customize_save', 'ennoshita_slack_before_save');

function ennoshita_slack_after_save() {
    $prev = isset($GLOBALS['ennoshita_slack_prev_webhook']) ? $GLOBALS['ennoshita_slack_prev_webhook'] : '';
    $now  = (string) get_theme_mod('ennoshita_slack_webhook', '');
    if ($now !== '' && $now !== $prev) {
        ennoshita_slack_send(':white_check_mark: ' . get_bloginfo('name') . ' のSlack通知を設定しました。記事が公開されると、ここにお知らせが届きます。');
    }
}
add_action('customize_save_after', 'ennoshita_slack_after_save');
