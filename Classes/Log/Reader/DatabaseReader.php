<?php
namespace VerteXVaaR\Logs\Log\Reader;

use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Database\PreparedStatement;
use VerteXVaaR\Logs\Domain\Model\Filter;
use VerteXVaaR\Logs\Domain\Model\Log;

/**
 * Class DatabaseReader
 */
class DatabaseReader implements ReaderInterface
{
    /**
     * @var string
     */
    protected $table = '';

    /**
     * @var string
     */
    protected $selectFields = 'request_id,time_micro,component,level';

    /**
     * DatabaseReader constructor.
     *
     * @param array $configuration
     */
    public function __construct(array $configuration = [])
    {
        $this->table = $configuration['logTable'];
    }

    /**
     * @return Log[]
     */
    public function findAll()
    {
        $logs = [];
        $statement = $this->getDatabase()->prepare_SELECTquery($this->selectFields, $this->table, '1');
        $statement->setFetchMode(PreparedStatement::FETCH_NUM);
        if ($statement->execute()) {
            while (($row = $statement->fetch())) {
                $row[5] = json_decode(substr($row[5], 2), true);
                $logs[] = new Log(...$row);
            }
        }
        return $logs;
    }

    /**
     * @param Filter $filter
     * @return Log[]
     */
    public function findByFilter(Filter $filter)
    {
        $where = [
            'level<=' . $filter->getMinimumSeverity(),
            'message IS NOT NULL',
        ];
        if (!empty(($requestId = $filter->getRequestId()))) {
            $where[] = sprintf('request_id LIKE "%s"', $this->getDatabase()->escapeStrForLike($requestId, 'sys_log'));
        }
        if (!empty(($fromTime = $filter->getFromTime()))) {
            $where[] = sprintf('time_micro >= %d', $this->getDatabase()->escapeStrForLike($fromTime, 'sys_log'));
        }
        if (!empty(($toTime = $filter->getToTime()))) {
            // Add +1 to the timestamp to ignore microseconds when comparing. UX stuff, you know ;)
            $where[] = sprintf('time_micro <= %d', $this->getDatabase()->escapeStrForLike($toTime + 1, 'sys_log'));
        }
        if (!empty(($component = $filter->getComponent()))) {
            $where[] = 'component LIKE "%' . $this->getDatabase()->escapeStrForLike($component, 'sys_log') . '%"';
        }

        $selectFields = $this->selectFields;
        $selectFields .= $filter->isCropMessage() ? ',CONCAT(LEFT(message , 120), "...") as message' : ',message';
        $selectFields .= $filter->isShowData() ? ',data' : ',"- {}"';

        $logs = [];
        $statement = $this->getDatabase()->prepare_SELECTquery(
            $selectFields,
            $this->table,
            implode(' AND ', $where),
            '',
            $filter->getOrderField() . ' ' . $filter->getOrderDirection(),
            $filter->getLimit()
        );
        $statement->setFetchMode(PreparedStatement::FETCH_NUM);
        if ($statement->execute()) {
            while (($row = $statement->fetch())) {
                $row[5] = json_decode(substr($row[5], 2), true);
                $logs[] = new Log(...$row);
            }
        }
        return $logs;
    }

    /**
     * @return DatabaseConnection
     * @SuppressWarnings("PHPMD.Superglobals")
     */
    protected function getDatabase()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
