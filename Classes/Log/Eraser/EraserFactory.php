<?php

declare(strict_types=1);

namespace CoStack\Logs\Log\Eraser;

use TYPO3\CMS\Core\Log\Writer\DatabaseWriter;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use function array_merge;
use function is_array;

class EraserFactory
{
    protected const WRITER_ERASER_MAPPING = [
        DatabaseWriter::class => DatabaseEraser::class,
    ];

    /**
     * @param array|null $logConfiguration Omit if you want all erasers for all configured writers or pass your writer
     *     configuration if you want only the erasers for the given writers
     *
     * @return array
     */
    public function getErasersForWriters(array $logConfiguration = null): array
    {
        if (null === $logConfiguration) {
            $logConfiguration = $this->getLogConfiguration();
        }

        $logReader = [];
        foreach ($logConfiguration as $key => $value) {
            if (is_array($value)) {
                if ('writerConfiguration' !== $key) {
                    $logReader = array_merge($logReader, $this->getErasersForWriters($value));
                } else {
                    foreach ($value as $writer) {
                        if (is_array($writer)) {
                            foreach ($writer as $class => $writerConfiguration) {
                                if (isset(static::WRITER_ERASER_MAPPING[$class])) {
                                    $eraserClass = static::WRITER_ERASER_MAPPING[$class];
                                    $logReader[] = GeneralUtility::makeInstance($eraserClass, $writerConfiguration);
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
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getLogConfiguration(): array
    {
        return $GLOBALS['TYPO3_CONF_VARS']['LOG'];
    }
}
