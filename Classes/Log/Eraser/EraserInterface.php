<?php

declare(strict_types=1);

namespace CoStack\Logs\Log\Eraser;

use CoStack\Logs\Domain\Model\Log;

/**
 * Interface EraserInterface
 */
interface EraserInterface
{
    /**
     * EraserInterface constructor.
     *
     * @param array|null $configuration
     */
    public function __construct(array $configuration = null);

    /**
     * @param Log $log
     *
     * @return mixed
     */
    public function delete(Log $log);

    /**
     * Deletes all log entries with the same component, message and level (ignoring the request ID, micro time and data)
     *
     * @param Log $log
     *
     * @return void
     */
    public function deleteAlike(Log $log);
}
