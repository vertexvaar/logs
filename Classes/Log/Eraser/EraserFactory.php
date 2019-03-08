<?php
namespace VerteXVaaR\Logs\Log\Eraser;

use TYPO3\CMS\Core\Log\Writer\DatabaseWriter;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use function array_merge;
use function is_array;

/**
 * Class EraserFactory
 */
class EraserFactory
{
    /**
     * @var array
     */
    protected static $writerEraserMapping = [
        DatabaseWriter::class => DatabaseEraser::class,
    ];

    /**
     * @param array|null $logConfiguration Omit if you want all erasers for all configured writers or pass your writer
     *     configuration if you want only the erasers for the given writers
     * @return array
     */
    public function getErasersForWriters(array $logConfiguration = null)
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
                                if (isset(static::$writerEraserMapping[$class])) {
                                    $eraserClass = static::$writerEraserMapping[$class];
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
     * @return array
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getLogConfiguration()
    {
        return $GLOBALS['TYPO3_CONF_VARS']['LOG'];
    }
}
