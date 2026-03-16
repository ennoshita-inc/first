<?php
/**
 * お問い合わせフォーム処理
 *
 * @package Ennoshita
 */

function ennoshita_handle_contact_form() {
    if (!isset($_POST['_wpnonce_contact']) || !wp_verify_nonce($_POST['_wpnonce_contact'], 'ennoshita_contact_nonce')) {
        wp_die('不正なリクエストです。');
    }

    // honeypotチェック（スパムボットが自動入力する非表示フィールド）
    if (!empty($_POST['website'])) {
        wp_safe_redirect(add_query_arg('contact', 'success', wp_get_referer()));
        exit;
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

    // 管理者への通知メール
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

    // 送信者への自動返信メール
    if ($sent && is_email($email)) {
        $reply_subject = "【{$site_name}】お問い合わせを受け付けました";
        $reply_body = "{$name} 様\n\n"
                    . "この度はお問い合わせいただき、誠にありがとうございます。\n"
                    . "以下の内容で承りました。\n\n"
                    . "━━━━━━━━━━━━━━━━━━━━━━\n"
                    . "ご相談内容: {$subject}\n\n"
                    . "メッセージ:\n{$message}\n"
                    . "━━━━━━━━━━━━━━━━━━━━━━\n\n"
                    . "内容を確認の上、担当者より2営業日以内にご連絡いたします。\n"
                    . "今しばらくお待ちくださいませ。\n\n"
                    . "──────────────────\n"
                    . "{$site_name}\n"
                    . get_theme_mod('ennoshita_address', '') . "\n"
                    . home_url('/') . "\n"
                    . "──────────────────\n\n"
                    . "※このメールは自動送信です。心当たりのない場合はお手数ですが削除してください。\n";

        $reply_headers = [
            "From: {$site_name} <{$admin_email}>",
            "Content-Type: text/plain; charset=UTF-8",
        ];

        wp_mail($email, $reply_subject, $reply_body, $reply_headers);
    }

    if ($sent) {
        wp_safe_redirect(add_query_arg('contact', 'success', wp_get_referer()));
    } else {
        wp_safe_redirect(add_query_arg('contact', 'error', wp_get_referer()));
    }
    exit;
}
add_action('admin_post_nopriv_ennoshita_contact', 'ennoshita_handle_contact_form');
add_action('admin_post_ennoshita_contact', 'ennoshita_handle_contact_form');
