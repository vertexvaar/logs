<?php
namespace VerteXVaaR\Logs\Log\Eraser;

use VerteXVaaR\Logs\Domain\Model\Log;

interface EraserInterface
{
    public function __construct(array $configuration = null);

    public function delete(Log $log);
}
