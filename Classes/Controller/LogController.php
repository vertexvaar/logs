<?php
namespace VerteXVaaR\Logs\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class LogController
 */
class LogController extends ActionController
{
    /**
     *
     */
    public function filterAction()
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this, __CLASS__ . '@' . __LINE__, 20);die;
    }
}
