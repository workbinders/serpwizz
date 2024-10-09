<?php
return [
    'date_format' => 'd M y',
    'lang' => [
        'en' => 'English',
        'es' => 'Spanish',
        'de' => 'German',
    ],
    'account_active_url'         => env('ACCOUNT_ACTIVE_URL'),
    'account_active_success_url' => env('ACCOUNT_ACTIVE_SUCCESS_URL'),
    'account_active_fail_url'    => env('ACCOUNT_ACTIVE_FAIL_URL'),
    'title_tag' => [
        'min_length' => 30,
        'max_length' => 70,
    ],
    'meta_description' => [
        'min_length' => 70,
        'max_length' => 320,
    ],
    'meta_keyword' => [
        'min_length' => 70,
        'max_length' => 320,
    ],
    'google_backlink_count_status' => [
        'danger' => ['min' => 0, 'max' => 70],
        'warning' => ['min' => 71, 'max' => 800],
        'good' => ['min' => 801]
    ],
    'web_formats' => [
        'html',
        'htm',
        'xhtml',
        'xht',
        'mhtml',
        'mht',
        'asp',
        'aspx',
        'cgi',
        'ihtml',
        'jsp',
        'las',
        'pl',
        'php',
        'php3',
        'phtml',
        'shtml'
    ]
];
