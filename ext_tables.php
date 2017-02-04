<?php
call_user_func(
    function () {
        if (empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['logs'])) {
            $configuration = [
                'modules' => '1',
                'category' => 'tools',
            ];
        } else {
            $configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['logs']);
        }

        if ('1' === $configuration['modules']) {
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'VerteXVaaR.Logs',
                $configuration['category'],
                'tx_logs_m1',
                '',
                ['Log' => 'filter'],
                [
                    'access' => 'user,group',
                    'icon' => 'EXT:logs/Resources/Public/Icons/Extension.svg',
                    'labels' => 'LLL:EXT:logs/Resources/Private/Language/locallang.module.xlf',
                ]
            );
        }
    }
);

