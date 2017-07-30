<?php
namespace VerteXVaaR\Logs\Controller;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
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
            $this->getBackendUser()->setAndSaveSessionData('tx_logs_filter', $filter);
        } else {
            $filter = $this->getBackendUser()->getSessionData('tx_logs_filter');
            if (null === $filter) {
                $filter = GeneralUtility::makeInstance(Filter::class);
            }
        }
        $this->view->assignMultiple(
            [
                'filter' => $filter,
                'logs' => (new ConjunctionReader())->findByFilter($filter),
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
        (new ConjunctionEraser())->delete(new Log($requestId, $timeMicro, $component, $level, $message, []));
        $this->redirect('filter');
    }

    /**
     * @return BackendUserAuthentication
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }
}
