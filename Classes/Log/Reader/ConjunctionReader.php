<?php
namespace VerteXVaaR\Logs\Log\Reader;

use TYPO3\CMS\Core\Log\Writer\DatabaseWriter;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;
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
     * @var ReaderInterface[]
     */
    protected $readers = [];

    /**
     * ReaderCollection constructor.
     *
     * @param array $configuration
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(array $configuration = [])
    {
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
        $orderField = GeneralUtility::underscoredToUpperCamelCase($filter->getOrderField());
        $direction = Filter::SORTING_ASC === $filter->getOrderDirection() ? -1 : 1;
        usort(
            $logs,
            function ($left, $right) use ($orderField, $direction) {
                return $direction
                       * strcmp(
                           ObjectAccess::getProperty($right, $orderField),
                           ObjectAccess::getProperty($left, $orderField)
                       );
            }
        );
        return array_slice($logs, 0, $filter->getLimit());
    }

    /**
     * @constructor Factory method to create an instance will all supported log reader
     */
    public static function fromConfiguration()
    {
        $conjunctionReader = new static();
        $conjunctionReader->setReaders(static::getReadersForWriters());
        return $conjunctionReader;
    }

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
     * @param array|null $logConfiguration
     * @return array
     */
    protected static function getReadersForWriters(array $logConfiguration = null)
    {
        if (null === $logConfiguration) {
            $logConfiguration = static::getLogConfiguration();
        }

        $logReader = [];
        foreach ($logConfiguration as $key => $value) {
            if (is_array($value)) {
                if ('writerConfiguration' !== $key) {
                    $logReader = array_merge($logReader, static::getReadersForWriters($value));
                } else {
                    foreach ($value as $writer) {
                        if (is_array($writer)) {
                            foreach ($writer as $class => $writerConfiguration) {
                                if (isset(static::$writerReaderMapping[$class])) {
                                    $readerClass = static::$writerReaderMapping[$class];
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
     * @return array
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected static function getLogConfiguration()
    {
        return $GLOBALS['TYPO3_CONF_VARS']['LOG'];
    }
}
