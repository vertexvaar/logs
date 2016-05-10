<?php
namespace VerteXVaaR\Logs\Log;

use TYPO3\CMS\Core\Log\Writer\DatabaseWriter;
use VerteXVaaR\Logs\Log\Reader\DatabaseReader;

/**
 * Class ConjunctionReaderFactory
 */
class ConjunctionReaderFactory
{
    /**
     * @var array
     */
    protected static $writerReaderMapping = [
        DatabaseWriter::class => DatabaseReader::class,
    ];

    /**
     * @param array|null $logConfiguration
     * @return ConjunctionReader
     */
    public static function fromConfiguration(array $logConfiguration = null)
    {
        $conjunctionReader = new ConjunctionReader();
        $conjunctionReader->setReaders(self::getReaders($logConfiguration));
        return $conjunctionReader;
    }

    /**
     * @param array|null $logConfiguration
     * @return array
     */
    protected static function getReaders(array $logConfiguration = null)
    {
        if (null === $logConfiguration) {
            $logConfiguration = self::getLogConfiguration();
        }

        $logReader = [];
        foreach ($logConfiguration as $key => $value) {
            if (is_array($value)) {
                if ('writerConfiguration' !== $key) {
                    $logReader = array_merge($logReader, self::getReaders($value));
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
     * @return array
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getLogConfiguration()
    {
        return $GLOBALS['TYPO3_CONF_VARS']['LOG'];
    }
}
