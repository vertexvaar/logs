<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'VerteXVaaR Logs',
    'description' => 'TYPO3 Logging API reading module and devlog extension in one',
    'category' => 'module',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'Oliver Eglseder',
    'author_email' => 'php@vxvr.de',
    'author_company' => 'vxvr.de',
    'version' => '1.2.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
