<?php
namespace VerteXVaaR\Logs\Log\Eraser;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use VerteXVaaR\Logs\Domain\Model\Log;

/**
 * Class DatabaseEraser
 */
class DatabaseEraser implements EraserInterface
{
    protected $table = 'sys_log';

    /**
     * @var Connection
     */
    protected $connection = null;

    /**
     * DatabaseEraser constructor.
     *
     * @param array|null $configuration
     */
    public function __construct(array $configuration = null)
    {
        if (null !== $configuration && isset($configuration['logTable'])) {
            $this->table = $configuration['logTable'];
        } else {
            $this->table = 'sys_log';
        }
        $this->connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($this->table);
    }

    /**
     * @param Log $log
     */
    public function delete(Log $log)
    {
        $this->connection->delete($this->table, $this->getWhere($log));
    }

    /**
     * @param Log $log
     * @return array
     */
    protected function getWhere(Log $log): array
    {
        return [
            'request_id' => $log->getRequestId(),
            'time_micro' => $log->getTimeMicro(),
            'component' => $log->getComponent(),
            'level' => $log->getLevel(),
            'message' => $log->getMessage(),
        ];
    }

    /**
     * @param Log $log
     */
    public function deleteAlike(Log $log)
    {
        $this->connection->delete($this->table, $this->getWhereAlike($log));
    }

    /**
     * @param Log $log
     * @return array
     */
    protected function getWhereAlike(Log $log): array
    {
        return [
            'component' => $log->getComponent(),
            'level' => $log->getLevel(),
            'message' => $log->getMessage(),
        ];
    }
}
