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
    'version' => '3.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.2.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
