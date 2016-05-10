<?php
namespace VerteXVaaR\Logs\Log\Reader;

use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Database\PreparedStatement;
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
    protected $selectFields = 'request_id,time_micro,component,level,message,data';

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
     * @return array
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
     * @return DatabaseConnection
     * @SuppressWarnings("PHPMD.Superglobals")
     */
    protected function getDatabase()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
