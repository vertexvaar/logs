<?php
namespace VerteXVaaR\Logs\Log\Eraser;

use TYPO3\CMS\Core\Database\DatabaseConnection;
use VerteXVaaR\Logs\Domain\Model\Log;

/**
 * Class DatabaseEraser
 */
class DatabaseEraser implements EraserInterface
{
    /**
     * @var string
     */
    protected $table = 'sys_log';

    /**
     * DatabaseEraser constructor.
     *
     * @param array $configuration
     */
    public function __construct(array $configuration = [])
    {
        if (isset($configuration['logTable'])) {
            $this->table = $configuration['logTable'];
        } else {
            $this->table = 'sys_log';
        }
    }

    /**
     * @param Log $log
     */
    public function delete(Log $log)
    {
        $this->getDatabase()->exec_DELETEquery($this->table, $this->getWhere($log));
    }

    /**
     * @param Log $log
     * @return string
     */
    protected function getWhere(Log $log)
    {
        $whereParts = [];
        $whereParts[] = 'request_id LIKE "' . $this->escape($log->getRequestId()) . '"';
        $whereParts[] = 'time_micro LIKE "' . $this->escape($log->getTimeMicro()) . '"';
        $whereParts[] = 'component LIKE "' . $this->escape($log->getComponent()) . '"';
        $whereParts[] = 'level LIKE "' . $this->escape($log->getLevel()) . '"';
        $whereParts[] = 'message LIKE "' . $this->escape($log->getMessage()) . '"';
        return implode(' AND ', $whereParts);
    }

    /**
     * @param string $string
     * @return string
     */
    protected function escape($string)
    {
        return $this->getDatabase()->quoteStr($string, $this->table);
    }

    /**
     * @return DatabaseConnection
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getDatabase()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
