<?php

return [
    'default' => env('LOCALE_DRIVER', 'header'),

    'sources' => [
        'header' => [
            'driver' => 'header',
            'key' => 'accept-language',
        ],
        'input' => [ // not only query string, maybe post patch and put data.
            'driver' => 'input',
            'key' => 'hl', // same as google
        ],
        'cookie' => [
            'driver' => 'cookie',
            'key' => 'hl',
        ],
    ],

    'locale_map' => [
        // en
        'en' => 'en',
        'en_gb' => 'en',
        'en_us' => 'en',
        // zh_CN
        'cmn_hans' => 'cmn_Hans',
        'zh_cn' => 'cmn_Hans',
        'zh_hans' => 'cmn_Hans',
        'zh_hans_cn' => 'cmn_Hans',
        // zh_TW
        'cmn_hant' => 'cmn_Hant',
        'zh_hant' => 'cmn_Hant',
        'zh_hant_hk' => 'cmn_Hant',
        'zh_hant_tw' => 'cmn_Hant',
        'zh_hk' => 'cmn_Hant',
        'zh_tw' => 'cmn_Hant',
    ],
];
