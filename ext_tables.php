<?php
call_user_func(
    function () {
        $configuration = (array)@unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['logs']);

        if (empty($configuration['moduleConfig'])) {
            $configuration['moduleConfig'] = 'tools';
        }

        if ($configuration['moduleConfig'] !== 'disable') {
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'VerteXVaaR.Logs',
                $configuration['moduleConfig'],
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

