<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Suggest with autocreation for tags of EXT:news',
    'description' => 'Let editors create tags quickly while editing a news record',
    'category' => 'be',
    'author' => 'Georg Ringer',
    'author_email' => 'mail@ringer.it',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'version' => '2.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
            'news' => '11.0.0-14.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
