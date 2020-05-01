<?php

namespace CoStack\Logs\Controller;

use CoStack\Logs\Domain\Model\Filter;
use CoStack\Logs\Domain\Model\Log;
use CoStack\Logs\Log\Eraser\ConjunctionEraser;
use CoStack\Logs\Log\Reader\ConjunctionReader;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException;

/**
 * Class LogController
 */
class LogController extends ActionController
{
    /**
     * @var array|null
     * @api Overwrite this property in your inheriting controller with your log config to restrict log readers
     */
    protected $logConfiguration = null;

    /**
     * @param Filter|null $filter
     *
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("filter")
     */
    public function filterAction(Filter $filter = null)
    {
        if (null !== $filter) {
            $filter->saveToSession();
        } else {
            $filter = GeneralUtility::makeInstance(Filter::class);
        }

        $reader = GeneralUtility::makeInstance(ConjunctionReader::class, $this->logConfiguration);
        $logs = $reader->findByFilter($filter);

        $this->view->assign('filter', $filter);
        $this->view->assign('logs', $logs);
    }

    /**
     * @param string $requestId
     * @param float $timeMicro
     * @param string $component
     * @param int $level
     * @param string $message
     *
     * @throws StopActionException
     * @throws UnsupportedRequestTypeException
     */
    public function deleteAction(string $requestId, float $timeMicro, string $component, int $level, string $message)
    {
        $log = GeneralUtility::makeInstance(Log::class, $requestId, $timeMicro, $component, $level, $message, []);
        $conjunctionReader = GeneralUtility::makeInstance(ConjunctionEraser::class, $this->logConfiguration);
        $conjunctionReader->delete($log);
        $this->redirect('filter');
    }

    /**
     * @param string $component
     * @param int $level
     * @param string $message
     *
     * @throws StopActionException
     * @throws UnsupportedRequestTypeException
     */
    public function deleteAlikeAction(string $component, int $level, string $message)
    {
        $log = GeneralUtility::makeInstance(Log::class, '', 0.0, $component, $level, $message, []);
        $conjunctionReader = GeneralUtility::makeInstance(ConjunctionEraser::class, $this->logConfiguration);
        $conjunctionReader->deleteAlike($log);
        $this->redirect('filter');
    }
}
