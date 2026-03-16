<?php
/**
 * Google Analytics / Tag Manager
 *
 * @package Ennoshita
 */

// GA4 / GTM: Cookie同意後にのみ読み込む（改正電気通信事業法対応）
function ennoshita_output_analytics_head() {
    $gtm_id = get_theme_mod('ennoshita_gtm_id');
    $ga4_id = get_theme_mod('ennoshita_ga4_id');

    if ($gtm_id || $ga4_id) {
        printf(
            '<script id="ennoshita-analytics-config" type="application/json">%s</script>' . "\n",
            wp_json_encode([
                'gtm' => $gtm_id ? esc_attr($gtm_id) : '',
                'ga4' => $ga4_id ? esc_attr($ga4_id) : '',
            ])
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
