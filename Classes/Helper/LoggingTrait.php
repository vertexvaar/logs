<?php
namespace VerteXVaaR\Logs\Helper;

use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class LoggingTrait
 */
trait LoggingTrait
{
    /**
     * @var null
     */
    private static $logger = null;

    /**
     * @return Logger
     */
    protected static function getLogger()
    {
        if (null === self::$logger) {
            self::$logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(get_called_class());
        }
        return self::$logger;
    }
}
