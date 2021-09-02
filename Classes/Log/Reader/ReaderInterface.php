<?php

declare(strict_types=1);

namespace CoStack\Logs\Log\Reader;

use CoStack\Logs\Domain\Model\Filter;
use CoStack\Logs\Domain\Model\Log;

interface ReaderInterface
{
    /**
     * ReaderInterface constructor.
     *
     * @param array|null $configuration
     */
    public function __construct(array $configuration = null);

    /**
     * Returns an array. All array keys make the reader unique for a source e.g. database table or file name.
     * The array values are the default values for the writer.
     *
     * @return array
     */
    public static function getDefaultConfigForUniqueKeys(): array;

    /**
     * @param Filter $filter
     *
     * @return Log[]
     */
    public function findByFilter(Filter $filter): array;
}
