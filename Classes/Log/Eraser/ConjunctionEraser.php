<?php
namespace VerteXVaaR\Logs\Log\Eraser;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use VerteXVaaR\Logs\Domain\Model\Log;

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

    public function delete(Log $log)
    {
        foreach ($this->eraser as $eraser) {
            $eraser->delete($log);
        }
    }

    public function deleteAlike(Log $log)
    {
        foreach ($this->eraser as $eraser) {
            $eraser->deleteAlike($log);
        }
    }
}
