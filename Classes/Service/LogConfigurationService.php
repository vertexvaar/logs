<?php
namespace VerteXVaaR\Logs\Service;

use TYPO3\CMS\Core\Log\Writer\DatabaseWriter;
use VerteXVaaR\Logs\Log\Reader\DatabaseReader;

/**
 * Class LogConfigurationService
 */
class LogConfigurationService
{
    /**
     * @var array
     */
    protected $writerToReaderMapping = [
        DatabaseWriter::class => DatabaseReader::class,
    ];

    /**
     * @param array|null $logConfiguration
     * @return array
     */
    public function getReaderCollection(array $logConfiguration = null)
    {
        if (null === $logConfiguration) {
            $logConfiguration = $this->getLogConfiguration();
        }

        $logReader = [];
        foreach ($logConfiguration as $key => $value) {
            if (is_array($value)) {
                if ('writerConfiguration' !== $key) {
                    $logReader = array_merge($logReader, $this->getReaderCollection($value));
                } else {
                    foreach ($value as $writer) {
                        foreach ($writer as $class => $writerConfiguration) {
                            if (isset($this->writerToReaderMapping[$class])) {
                                $logReader[] = new $this->writerToReaderMapping[$class]($writerConfiguration);
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
