<?php
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'VerteXVaaR.Logs',
    'tools',
    'tx_logs_m1',
    '',
    ['Log' => 'filter'],
    [
        'access' => 'user,group',
        'icon' => '',
        'labels' => 'LLL:EXT:logs/Resources/Private/Language/locallang.module.xlf',
    ]
);
