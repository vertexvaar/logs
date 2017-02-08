<?php
namespace VerteXVaaR\Logs\Log\Eraser;

use VerteXVaaR\Logs\Domain\Model\Log;

/**
 * Class ConjunctionEraser
 */
class ConjunctionEraser implements EraserInterface
{
    /**
     * @var array
     */
    protected static $writerEraserMapping = [
        'TYPO3\\CMS\\Core\\Log\\Writer\\DatabaseWriter' => 'VerteXVaaR\\Logs\\Log\\Eraser\\DatabaseEraser',
    ];

    /**
     * @var EraserInterface[]
     */
    protected $eraser = [];

    /**
     * ConjunctionEraser constructor.
     *
     * @param array $configuration
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(array $configuration = [])
    {
        $this->eraser = $this->getErasersForWriters();
    }

    /**
     * @param Log $log
     */
    public function delete(Log $log)
    {
        foreach ($this->eraser as $eraser) {
            $eraser->delete($log);
        }
    }

    /**
     * @param array|null $logConfiguration
     * @return array
     */
    protected function getErasersForWriters(array $logConfiguration = null)
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
                                    $logReader[] = new $eraserClass($writerConfiguration);
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
