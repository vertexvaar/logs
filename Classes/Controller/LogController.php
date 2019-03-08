<?php
namespace VerteXVaaR\Logs\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException;
use VerteXVaaR\Logs\Domain\Model\Filter;
use VerteXVaaR\Logs\Domain\Model\Log;
use VerteXVaaR\Logs\Log\Eraser\ConjunctionEraser;
use VerteXVaaR\Logs\Log\Reader\ConjunctionReader;

class LogController extends ActionController
{
    /**
     * @var array|null
     * @api Overwrite this property in your inheriting controller with your log config to restrict log readers
     */
    protected $logConfiguration = null;

    /**
     * @ignorevalidation filter
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
