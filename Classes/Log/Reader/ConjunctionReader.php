<?php

namespace CoStack\Logs\Log\Reader;

use CoStack\Logs\Domain\Model\Filter;
use CoStack\Logs\Domain\Model\Log;
use TYPO3\CMS\Core\Log\Writer\DatabaseWriter;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

use function array_merge;
use function array_slice;
use function is_array;
use function strcmp;
use function usort;

/**
 * Class ConjunctionReader
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

    public function __construct(array $configuration = null)
    {
        $readerFactory = GeneralUtility::makeInstance(ReaderFactory::class);
        $this->readers = $readerFactory->getReadersForWriters($configuration);
    }

    /**
     * @param Filter $filter
     *
     * @return Log[]
     */
    public function findByFilter(Filter $filter): array
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
     * @return ReaderInterface[]
     */
    public function getReaders(): array
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
    public function addReaders(array $readers)
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
     *
     * @return array
     */
    protected function getReadersForWriters(array $logConfiguration = null): array
    {
        if (null === $logConfiguration) {
            $logConfiguration = $this->getLogConfiguration();
        }

        $logReader = [];
        foreach ($logConfiguration as $key => $value) {
            if (is_array($value)) {
                if ('writerConfiguration' !== $key) {
                    $logReader = array_merge($logReader, $this->getReadersForWriters($value));
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
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getLogConfiguration(): array
    {
        return $GLOBALS['TYPO3_CONF_VARS']['LOG'];
    }
}
