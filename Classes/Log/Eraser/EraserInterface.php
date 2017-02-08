<?php
namespace VerteXVaaR\Logs\Log\Eraser;

use VerteXVaaR\Logs\Domain\Model\Log;

/**
 * Interface EraserInterface
 */
interface EraserInterface
{
    /**
     * EraserInterface constructor.
     *
     * @param array $configuration
     */
    public function __construct(array $configuration = []);

    /**
     * @param Log $log
     */
    public function delete(Log $log);
}
