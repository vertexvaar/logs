<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'co-stack.com Logs',
    'description' => 'Log Reader with a backend module and API to read, filter and delete logs from the TYPO3 Logging API',
    'category' => 'module',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'Oliver Eglseder',
    'author_email' => 'oliver.eglseder@co-stack.com',
    'author_company' => 'co-stack.com',
    'version' => '3.1.5',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
