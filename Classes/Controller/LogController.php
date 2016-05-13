<?php
namespace VerteXVaaR\Logs\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use VerteXVaaR\Logs\Domain\Model\Filter;
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
                'logs' => ConjunctionReader::fromConfiguration()->findByFilter($filter),
            ]
        );
    }
}
