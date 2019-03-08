<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'VXVR Logs',
    'description' => 'Sophisticated Log Reader API with a backend module to red, filter and delete logs from the TYPO3 Logging API',
    'category' => 'module',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'Oliver Eglseder',
    'author_email' => 'php@vxvr.de',
    'author_company' => 'vxvr.de',
    'version' => '2.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
