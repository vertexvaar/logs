<?php
namespace CoStack\Logs\Log\Reader;

use CoStack\Logs\Domain\Model\Filter;
use CoStack\Logs\Domain\Model\Log;

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
