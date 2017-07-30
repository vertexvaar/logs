<?php
namespace VerteXVaaR\Logs\Log\Eraser;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use VerteXVaaR\Logs\Domain\Model\Log;

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
     * ConjunctionEraser constructor.
     *
     * @param array $configuration
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(array $configuration = [])
    {
        $eraserFactory = GeneralUtility::makeInstance(EraserFactory::class);
        $this->eraser = $eraserFactory->getErasersForWriters();
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
}
