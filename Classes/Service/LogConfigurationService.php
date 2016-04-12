<?php
namespace VerteXVaaR\Logs\Service;

use TYPO3\CMS\Core\Log\Writer\DatabaseWriter;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Class LogConfigurationService
 */
class LogConfigurationService implements SingletonInterface
{
    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * LogConfigurationService constructor.
     */
    public function __construct()
    {
        $this->configuration = $this->getConfigurationFromGlobals();
    }

    /**
     * @param array|null $configuration
     * @return mixed
     */
    public function getAllLogTables(array $configuration = null)
    {
        if (null === $configuration) {
            $logTables = $this->getAllLogTables($this->configuration);
        } else {
            $logTables = [];
            foreach ($configuration as $key => $value) {
                if ('writerConfiguration' === $key) {
                    foreach ($value as $writer) {
                        foreach ($writer as $class => $writerConfiguration) {
                            if (DatabaseWriter::class === $class) {
                                $logTables[] = $writerConfiguration['logTable'];
                            }
                        }
                    }
                } else {
                    $logTables = array_merge($logTables, $this->getAllLogTables($value));
                }
            }
        }
        return $logTables;
    }

    /**
     * @return array
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getConfigurationFromGlobals()
    {
        return $GLOBALS['TYPO3_CONF_VARS']['LOG'];
    }
}
