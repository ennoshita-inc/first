<?php
/**
 * SEO機能 — タイトル、meta description、OGP、JSON-LD、canonical
 *
 * @package Ennoshita
 */

// ==============================================
// タイトルタグ
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
// meta description
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
// OGP
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
// canonical URL
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
// 構造化データ JSON-LD
// ==============================================
function ennoshita_output_jsonld() {
    $phone = get_theme_mod('ennoshita_phone', '');
    $logo_id = get_theme_mod('custom_logo');
    $logo_url = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';

    if (is_front_page()) {
        $data = [
            '@context'    => 'https://schema.org',
            '@type'       => 'LocalBusiness',
            'name'        => '株式会社えんのした',
            'description' => '人・職場・組織を支えるコンサルティング会社。人材育成、人事制度構築、組織開発を支援します。',
            'url'         => home_url('/'),
            'address'     => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => '磨屋町ビル8階',
                'addressLocality' => '岡山市',
                'addressRegion'   => '岡山県',
                'postalCode'      => '700-0826',
                'addressCountry'  => 'JP',
            ],
            'foundingDate' => '2012-05-01',
        ];

        if ($phone) {
            $data['telephone'] = $phone;
        }
        if ($logo_url) {
            $data['logo'] = $logo_url;
        }

        // SNSリンクを動的に取得
        $same_as = [];
        foreach (['x', 'facebook', 'instagram', 'linkedin'] as $sns) {
            $sns_url = get_theme_mod("ennoshita_sns_{$sns}");
            if ($sns_url) {
                $same_as[] = $sns_url;
            }
        }
        if ($same_as) {
            $data['sameAs'] = $same_as;
        }

        printf(
            '<script type="application/ld+json">%s</script>' . "\n",
            wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );
    }

    // BreadcrumbList JSON-LD（トップページ以外）
    if (!is_front_page()) {
        $breadcrumb_items = [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'ホーム', 'item' => home_url('/')],
        ];
        $pos = 2;

        if (is_singular('post')) {
            $breadcrumb_items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => 'コラム', 'item' => ennoshita_get_blog_url()];
            $breadcrumb_items[] = ['@type' => 'ListItem', 'position' => $pos, 'name' => get_the_title()];
        } elseif (is_singular('case_study')) {
            $breadcrumb_items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => '導入事例', 'item' => get_post_type_archive_link('case_study')];
            $breadcrumb_items[] = ['@type' => 'ListItem', 'position' => $pos, 'name' => get_the_title()];
        } elseif (is_page()) {
            $ancestors = array_reverse(get_post_ancestors(get_the_ID()));
            foreach ($ancestors as $ancestor_id) {
                $breadcrumb_items[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => get_the_title($ancestor_id), 'item' => get_permalink($ancestor_id)];
            }
            $breadcrumb_items[] = ['@type' => 'ListItem', 'position' => $pos, 'name' => get_the_title()];
        } elseif (is_post_type_archive('case_study')) {
            $breadcrumb_items[] = ['@type' => 'ListItem', 'position' => $pos, 'name' => '導入事例'];
        } elseif (is_archive()) {
            $breadcrumb_items[] = ['@type' => 'ListItem', 'position' => $pos, 'name' => 'コラム'];
        }

        if (count($breadcrumb_items) > 1) {
            $bc_data = [
                '@context'        => 'https://schema.org',
                '@type'           => 'BreadcrumbList',
                'itemListElement' => $breadcrumb_items,
            ];
            printf(
                '<script type="application/ld+json">%s</script>' . "\n",
                wp_json_encode($bc_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
            );
        }
    }

    // サービスページのFAQスキーマ
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
        $publisher = [
            '@type' => 'Organization',
            'name'  => '株式会社えんのした',
            'url'   => home_url('/'),
        ];
        if ($logo_url) {
            $publisher['logo'] = [
                '@type' => 'ImageObject',
                'url'   => $logo_url,
            ];
        }

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
            'publisher'        => $publisher,
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
