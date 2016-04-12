<?php
namespace VerteXVaaR\Logs\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use VerteXVaaR\Logs\Service\LogConfigurationService;

/**
 * Class LogController
 */
class LogController extends ActionController
{
    /**
     * @var LogConfigurationService
     */
    protected $logConfigurationService = null;

    /**
     * LogController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->logConfigurationService = GeneralUtility::makeInstance(LogConfigurationService::class);
    }

    /**
     *
     */
    public function filterAction()
    {
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
            $this->logConfigurationService->getAllLogTables(),
            __CLASS__ . '@' . __LINE__,
            20
        );
        die;
    }
}
