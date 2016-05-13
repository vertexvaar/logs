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
     * @var array
     */
    protected $selectFields = ['request_id', 'time_micro', 'component', 'level', 'message', 'data'];

    /**
     * @var string
     */
    protected $table = '';

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
        $statement = $this->getDatabase()->prepare_SELECTquery($this->selectFields, $this->table, '1');
        return $this->fetchLogsByStatement($statement);
    }

    /**
     * @param Filter $filter
     * @return Log[]
     */
    public function findByFilter(Filter $filter)
    {
        $statement = $this->getDatabase()->prepare_SELECTquery(
            $this->getSelectFieldsByFilter($filter),
            $this->table,
            $this->getWhereClausByFilter($filter),
            '',
            $filter->getOrderField() . ' ' . $filter->getOrderDirection(),
            $filter->getLimit()
        );
        return $this->fetchLogsByStatement($statement);
    }

    /**
     * @param Filter $filter
     * @return string
     */
    protected function getWhereClausByFilter(Filter $filter)
    {
        $where = [
            'level<=' . $filter->getLevel(),
            'message IS NOT NULL',
        ];
        if (!empty(($requestId = $filter->getRequestId()))) {
            /* @see \TYPO3\CMS\Core\Core\Bootstrap::__construct for requestId string length */
            if (13 === strlen($requestId)) {
                $where[] = Filter::ORDER_REQUEST_ID . ' = "' . $this->escapeString($requestId) . '"';
            } else {
                $where[] = Filter::ORDER_REQUEST_ID . ' LIKE "%' . $this->escapeString($requestId) . '%"';
            }
        }
        if (!empty(($fromTime = $filter->getFromTime()))) {
            $where[] = Filter::ORDER_TIME_MICRO . ' >= ' . $this->escapeString($fromTime);
        }
        if (!empty(($toTime = $filter->getToTime()))) {
            // Add +1 to the timestamp to ignore additional microseconds when comparing. UX stuff, you know ;)
            $where[] = Filter::ORDER_TIME_MICRO . ' <= ' . $this->escapeString($toTime + 1);
        }
        if (!empty(($component = $filter->getComponent()))) {
            $where[] = Filter::ORDER_COMPONENT . ' = "%' . $this->escapeString($component) . '%"';
        }
        return implode(' AND ', $where);
    }

    /**
     * @param Filter $filter
     * @return string
     */
    protected function getSelectFieldsByFilter(Filter $filter)
    {
        $selectFields = $this->selectFields;
        $filter->isFullMessage() ?: $selectFields[4] = 'CONCAT(LEFT(message , 120), "...") as message';
        $filter->isShowData() ?: $selectFields[5] = '"- {}"';
        return implode(',', $selectFields);
    }

    /**
     * @param PreparedStatement $statement
     * @return Log[]
     */
    protected function fetchLogsByStatement(PreparedStatement $statement)
    {
        $logs = [];
        $statement->setFetchMode(PreparedStatement::FETCH_NUM);

        if ($statement->execute()) {
            while (($row = $statement->fetch())) {
                $row[5] = json_decode(substr($row[5], 2), true);
                $logs[] = new Log(...$row);
            }
            return $logs;
        }
        return $logs;
    }

    /**
     * @param string $string
     * @return string
     */
    protected function escapeString($string)
    {
        return $this->getDatabase()->escapeStrForLike($string, 'sys_log');
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
