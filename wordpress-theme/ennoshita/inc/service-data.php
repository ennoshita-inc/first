<?php
/**
 * サービスデータ一元管理 + サンプルデータ
 *
 * @package Ennoshita
 */

/**
 * 3つのサービス情報を一元管理する関数
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
