<?php
/**
 * カスタマイザー設定
 *
 * @package Ennoshita
 */

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

    // 実績セクション
    $wp_customize->add_section('ennoshita_trust', [
        'title'       => '実績セクション',
        'description' => 'トップページに表示される実績数字（4項目）。事実に基づいた数字を入力してください。',
        'priority'    => 33,
    ]);

    $trust_defaults = [
        1 => ['number' => '13',  'unit' => '年',    'label' => '支援実績'],
        2 => ['number' => '9',   'unit' => '社',    'label' => '導入事例'],
        3 => ['number' => '15',  'unit' => '種類+', 'label' => '提供プログラム'],
        4 => ['number' => '3',   'unit' => '分野',  'label' => '支援領域'],
    ];

    foreach ($trust_defaults as $i => $def) {
        $wp_customize->add_setting("ennoshita_trust_{$i}_number", [
            'default'           => $def['number'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("ennoshita_trust_{$i}_number", [
            'label'   => "実績{$i}: 数字",
            'section' => 'ennoshita_trust',
            'type'    => 'text',
        ]);

        $wp_customize->add_setting("ennoshita_trust_{$i}_unit", [
            'default'           => $def['unit'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("ennoshita_trust_{$i}_unit", [
            'label'   => "実績{$i}: 単位（年/社/種類 等）",
            'section' => 'ennoshita_trust',
            'type'    => 'text',
        ]);

        $wp_customize->add_setting("ennoshita_trust_{$i}_label", [
            'default'           => $def['label'],
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("ennoshita_trust_{$i}_label", [
            'label'   => "実績{$i}: ラベル",
            'section' => 'ennoshita_trust',
            'type'    => 'text',
        ]);

        $wp_customize->add_setting("ennoshita_trust_{$i}_link", [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control("ennoshita_trust_{$i}_link", [
            'label'       => "実績{$i}: リンク先URL（任意）",
            'description' => 'サービスページの導入事例等にリンクする場合に設定',
            'section'     => 'ennoshita_trust',
            'type'        => 'url',
        ]);
    }

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

    // 資料ダウンロード（リードマグネット）
    $wp_customize->add_section('ennoshita_lead_magnet', [
        'title'       => '資料ダウンロード',
        'description' => 'サービスページやブログに表示する無料資料ダウンロードCTA。URLを設定すると表示されます。',
        'priority'    => 36,
    ]);

    $wp_customize->add_setting('ennoshita_lead_magnet_title', [
        'default'           => '無料ダウンロード資料',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ennoshita_lead_magnet_title', [
        'label'   => 'タイトル',
        'section' => 'ennoshita_lead_magnet',
        'type'    => 'text',
    ]);

    $wp_customize->add_setting('ennoshita_lead_magnet_description', [
        'default'           => '「組織診断チェックリスト」を無料でお届けします。自社の組織課題を可視化する第一歩にご活用ください。',
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('ennoshita_lead_magnet_description', [
        'label'   => '説明文',
        'section' => 'ennoshita_lead_magnet',
        'type'    => 'textarea',
    ]);

    $wp_customize->add_setting('ennoshita_lead_magnet_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('ennoshita_lead_magnet_url', [
        'label'       => 'ダウンロードページURL（または外部フォームURL）',
        'description' => '設定するとサービスページ・ブログ記事にCTAが表示されます',
        'section'     => 'ennoshita_lead_magnet',
        'type'        => 'url',
    ]);

    $wp_customize->add_setting('ennoshita_lead_magnet_button_text', [
        'default'           => '無料でダウンロード',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ennoshita_lead_magnet_button_text', [
        'label'   => 'ボタンテキスト',
        'section' => 'ennoshita_lead_magnet',
        'type'    => 'text',
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

    // メルマガ設定
    $wp_customize->add_section('ennoshita_newsletter', [
        'title'       => 'メルマガ登録',
        'description' => 'メルマガ登録フォームの設定。URLを入力すると、ブログサイドバーや記事末尾にフォームが表示されます。',
        'priority'    => 37,
    ]);

    $wp_customize->add_setting('ennoshita_newsletter_url', [
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ]);
    $wp_customize->add_control('ennoshita_newsletter_url', [
        'label'       => 'メルマガ登録ページURL',
        'description' => '外部フォーム（Mailchimp等）のURLを入力',
        'section'     => 'ennoshita_newsletter',
        'type'        => 'url',
    ]);

    // パートナー企業ロゴ
    $wp_customize->add_section('ennoshita_partners', [
        'title'       => 'パートナー・メディア掲載',
        'description' => 'トップページに表示するパートナー企業ロゴやメディア掲載実績の画像を設定します。',
        'priority'    => 34,
    ]);

    for ($i = 1; $i <= 6; $i++) {
        $wp_customize->add_setting("ennoshita_partner_logo_{$i}", ['default' => '']);
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "ennoshita_partner_logo_{$i}", [
            'label'   => "パートナーロゴ {$i}",
            'section' => 'ennoshita_partners',
        ]));

        $wp_customize->add_setting("ennoshita_partner_name_{$i}", [
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        ]);
        $wp_customize->add_control("ennoshita_partner_name_{$i}", [
            'label'   => "パートナー名 {$i}",
            'section' => 'ennoshita_partners',
            'type'    => 'text',
        ]);
    }
}
add_action('customize_register', 'ennoshita_customize_register');
