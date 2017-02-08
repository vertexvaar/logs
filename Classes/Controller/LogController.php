<?php
namespace VerteXVaaR\Logs\Controller;

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
        $this->view->assignMultiple(
            [
                'filter' => (null !== $filter ? $filter : $filter = new Filter()),
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
}
