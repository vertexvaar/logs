<?php

namespace CoStack\Logs\Log\Reader;

use TYPO3\CMS\Core\Log\Writer\DatabaseWriter;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function is_array;
use function json_encode;
use function sha1;

/**
 * Class ReaderFactory
 */
class ReaderFactory
{
    protected const WRITER_READER_MAPPING = [
        DatabaseWriter::class => DatabaseReader::class,
    ];

    /**
     * @param array|null $logConfiguration Omit if you want all readers for all configured writers or pass your writer
     *     configuration if you want only the reader for the given writers
     * @param array $logReader
     *
     * @return array
     */
    public function getReadersForWriters(array $logConfiguration = null, array $logReader = [])
    {
        if (null === $logConfiguration) {
            $logConfiguration = $this->getLogConfiguration();
        }

        $writer = $this->collectWriter($logConfiguration);

        foreach ($writer as $class => $writerConfigurations) {
            foreach ($writerConfigurations as $writerConfiguration) {
                $readerClass = static::WRITER_READER_MAPPING[$class];
                $logReader[] = GeneralUtility::makeInstance($readerClass, $writerConfiguration);
            }
        }
        return $logReader;
    }

    /**
     * @param array $logConfiguration
     * @param array $writer
     *
     * @return array
     */
    protected function collectWriter(array $logConfiguration, array $writer = []): array
    {
        foreach ($logConfiguration as $key => $value) {
            if (is_array($value)) {
                if ('writerConfiguration' !== $key) {
                    $writer = $this->collectWriter($value, $writer);
                } else {
                    foreach ($value as $writerConf) {
                        if (is_array($writerConf)) {
                            foreach ($writerConf as $class => $writerConfig) {
                                if (isset(static::WRITER_READER_MAPPING[$class])) {
                                    $configKey = $this->getUniqueConfigKey($class, $writerConfig);
                                    $writer[$class][$configKey] = $writerConfig;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $writer;
    }

    /**
     * @param string $class
     * @param array $writerConfig
     *
     * @return string
     */
    protected function getUniqueConfigKey(string $class, array $writerConfig): string
    {
        /** @var ReaderInterface $readerClass */
        $readerClass = static::WRITER_READER_MAPPING[$class];
        $configValues = [];
        foreach ($readerClass::getUniqueConfigKeys() as $field) {
            $configValues[] = $writerConfig[$field] ?? '_none_';
        }
        return sha1(json_encode($configValues));
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
