<?php
namespace VerteXVaaR\Logs\Log\Reader;

use VerteXVaaR\Logs\Domain\Model\Filter;
use VerteXVaaR\Logs\Domain\Model\Log;

interface ReaderInterface
{
    public function __construct(array $configuration = null);

    /**
     * @param Filter $filter
     * @return Log[]
     */
    public function findByFilter(Filter $filter): array;
}
