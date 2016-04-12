<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'VerteXVaaR LogThunder',
    'description' => 'TYPO3 Logging API reading module and devlog extension in one',
    'category' => 'module',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-7.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'state' => 'beta',
    'uploadfolder' => false,
    'createDirs' => '',
    'clearcacheonload' => true,
    'author' => 'Oliver Eglseder',
    'author_email' => 'php@vxvr.de',
    'author_company' => 'vxvr.de',
    'version' => '1.0.0',
];
