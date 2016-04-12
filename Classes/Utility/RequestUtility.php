<?php
namespace VerteXVaaR\Logs\Utility;

use TYPO3\CMS\Core\Core\Bootstrap;

/**
 * Class RequestUtility
 */
class RequestUtility
{
    /**
     * @return string
     */
    public static function getCurrentRequestId()
    {
        return Bootstrap::getInstance()->getRequestId();
    }
}
