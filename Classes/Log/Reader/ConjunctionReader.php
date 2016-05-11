<?php
namespace VerteXVaaR\Logs\Log\Reader;

use TYPO3\CMS\Core\Log\Writer\DatabaseWriter;
use VerteXVaaR\Logs\Domain\Model\Filter;
use VerteXVaaR\Logs\Domain\Model\Log;

/**
 * Class ReaderCollection
 */
class ConjunctionReader implements ReaderInterface
{
    /**
     * @var array
     */
    protected static $writerReaderMapping = [
        DatabaseWriter::class => DatabaseReader::class,
    ];

    /**
     * @constructor Factory method to create an instance will all supported log reader
     */
    public static function fromConfiguration()
    {
        $conjunctionReader = new static();
        $conjunctionReader->setReaders(self::getReadersForWriters());
        return $conjunctionReader;
    }

    /**
     * @param array|null $logConfiguration
     * @return array
     */
    protected static function getReadersForWriters(array $logConfiguration = null)
    {
        if (null === $logConfiguration) {
            $logConfiguration = self::getLogConfiguration();
        }

        $logReader = [];
        foreach ($logConfiguration as $key => $value) {
            if (is_array($value)) {
                if ('writerConfiguration' !== $key) {
                    $logReader = array_merge($logReader, self::getReadersForWriters($value));
                } else {
                    foreach ($value as $writer) {
                        if (is_array($writer)) {
                            foreach ($writer as $class => $writerConfiguration) {
                                if (isset(self::$writerReaderMapping[$class])) {
                                    $readerClass = self::$writerReaderMapping[$class];
                                    $logReader[] = new $readerClass($writerConfiguration);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $logReader;
    }

    /**
     * ReaderCollection constructor.
     *
     * @param array $configuration
     */
    public function __construct(array $configuration = [])
    {
    }

    /**
     * @var ReaderInterface[]
     */
    protected $readers = [];

    /**
     * @return ReaderInterface[]
     */
    public function getReaders()
    {
        return $this->readers;
    }

    /**
     * @param ReaderInterface[] $readers
     */
    public function setReaders(array $readers)
    {
        $this->readers = $readers;
    }

    /**
     * @param ReaderInterface[] $readers
     */
    public function addReaders($readers)
    {
        foreach ($readers as $reader) {
            $this->addReader($reader);
        }
    }

    /**
     * @param ReaderInterface $reader
     */
    public function addReader(ReaderInterface $reader)
    {
        $this->readers[] = $reader;
    }

    /**
     * @return Log[]
     */
    public function findAll()
    {
        $logs = [];
        foreach ($this->readers as $reader) {
            $logs = array_merge($logs, $reader->findAll());
        }
        return $logs;
    }

    /**
     * @param Filter $filter
     * @return Log[]
     */
    public function findByFilter(Filter $filter)
    {
        $logs = [];
        foreach ($this->readers as $reader) {
            $logs = array_merge($logs, $reader->findByFilter($filter));
        }
        return $logs;
    }

    /**
     * @return array
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getLogConfiguration()
    {
        return $GLOBALS['TYPO3_CONF_VARS']['LOG'];
    }
}
