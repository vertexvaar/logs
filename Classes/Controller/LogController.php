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
     * @param Filter|null $filter
     */
    public function filterAction(Filter $filter = null)
    {
        if (null !== $filter) {
            $filter->saveToSession();
        } else {
            $filter = GeneralUtility::makeInstance(Filter::class);
        }

        $this->view->assignMultiple(
            [
                'filter' => $filter,
                'logs' => GeneralUtility::makeInstance(ConjunctionReader::class)->findByFilter($filter),
            ]
        );
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
        $conjunctionReader = GeneralUtility::makeInstance(ConjunctionEraser::class);
        $conjunctionReader->delete($log);
        $this->redirect('filter');
    }
}
