<?php
namespace VerteXVaaR\Logs\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use VerteXVaaR\Logs\Helper\LoggingTrait;
use VerteXVaaR\Logs\Log\ConjunctionReaderFactory;
use VerteXVaaR\Logs\Log\Reader\ReaderInterface;

/**
 * Class LogController
 */
class LogController extends ActionController
{
    use LoggingTrait;

    /**
     * @var ReaderInterface
     */
    protected $reader = null;

    /**
     *
     */
    public function initializeObject()
    {
        $this->reader = ConjunctionReaderFactory::fromConfiguration();
    }

    /**
     *
     */
    public function filterAction()
    {
        $this->view->assign('logs', $this->reader->findAll());
    }
}
