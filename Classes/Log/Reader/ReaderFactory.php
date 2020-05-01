<?php

namespace CoStack\Logs\Log\Reader;

use TYPO3\CMS\Core\Log\Writer\DatabaseWriter;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function array_merge;
use function is_array;

/**
 * Class ReaderFactory
 */
class ReaderFactory
{
    /**
     * @var array
     */
    protected static $writerReaderMapping = [
        DatabaseWriter::class => DatabaseReader::class,
    ];

    /**
     * @param array|null $logConfiguration Omit if you want all readers for all configured writers or pass your writer
     *     configuration if you want only the reader for the given writers
     *
     * @return array
     */
    public function getReadersForWriters(array $logConfiguration = null)
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
                                    $logReader[] = GeneralUtility::makeInstance($readerClass, $writerConfiguration);
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
