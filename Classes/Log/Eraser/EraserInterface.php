<?php
namespace VerteXVaaR\Logs\Log\Eraser;

use VerteXVaaR\Logs\Domain\Model\Log;

interface EraserInterface
{
    public function __construct(array $configuration = null);

    public function delete(Log $log);

    /**
     * Deletes all log entries with the same component, message and level (ignoring the request ID, micro time and data)
     *
     * @param Log $log
     * @return void
     */
    public function deleteAlike(Log $log);
}
