<?php
namespace VerteXVaaR\Logs\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use VerteXVaaR\Logs\Domain\Model\Filter;
use VerteXVaaR\Logs\Log\Reader\ConjunctionReader;
use VerteXVaaR\Logs\Log\Reader\ReaderInterface;

/**
 * Class LogController
 */
class LogController extends ActionController
{
    /**
     * @var ReaderInterface
     */
    protected $reader = null;

    /**
     *
     */
    public function initializeObject()
    {
        $this->reader = ConjunctionReader::fromConfiguration();
    }

    /**
     * @param Filter|null $filter
     */
    public function filterAction(Filter $filter = null)
    {
        null !== $filter ?: $filter = new Filter();
        $this->view->assign('filter', $filter);
        $this->view->assign('logs', $this->reader->findByFilter($filter));
    }
}
