<?php

namespace CoStack\Logs\Log\Eraser;

use CoStack\Logs\Domain\Model\Log;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ConjunctionEraser
 */
class ConjunctionEraser implements EraserInterface
{
    /**
     * @var EraserInterface[]
     */
    protected $eraser = [];

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(array $configuration = null)
    {
        $eraserFactory = GeneralUtility::makeInstance(EraserFactory::class);
        $this->eraser = $eraserFactory->getErasersForWriters($configuration);
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
     * @param Log $log
     */
    public function deleteAlike(Log $log)
    {
        foreach ($this->eraser as $eraser) {
            $eraser->deleteAlike($log);
        }
    }
}
