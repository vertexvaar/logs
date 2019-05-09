<?php
namespace VerteXVaaR\Logs\Log\Reader;

use VerteXVaaR\Logs\Domain\Model\Filter;
use VerteXVaaR\Logs\Domain\Model\Log;

/**
 * Interface ReaderInterface
 */
interface ReaderInterface
{
    /**
     * ReaderInterface constructor.
     *
     * @param array|null $configuration
     */
    public function __construct(array $configuration = null);

    /**
     * @param Filter $filter
     * @return Log[]
     */
    public function findByFilter(Filter $filter): array;
}
