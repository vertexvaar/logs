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
     * Returns the names of the configuration keys which determine the source of the reader.
     *
     * @return array
     */
    public static function getUniqueConfigKeys(): array;

    /**
     * @param Filter $filter
     *
     * @return Log[]
     */
    public function findByFilter(Filter $filter): array;
}
