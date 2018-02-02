<?php
namespace VerteXVaaR\Logs\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use VerteXVaaR\Logs\Domain\Model\Filter;
use VerteXVaaR\Logs\Domain\Model\Log;
use VerteXVaaR\Logs\Log\Eraser\ConjunctionEraser;
use VerteXVaaR\Logs\Log\Reader\ConjunctionReader;

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
     * @param string $timeMicro
     * @param string $component
     * @param string $level
     * @param string $message
     */
    public function deleteAction($requestId, $timeMicro, $component, $level, $message)
    {
        $log = GeneralUtility::makeInstance(Log::class, $requestId, $timeMicro, $component, $level, $message, []);
        $conjunctionReader = GeneralUtility::makeInstance(ConjunctionEraser::class, $this->logConfiguration);
        $conjunctionReader->delete($log);
        $this->redirect('filter');
    }
}
