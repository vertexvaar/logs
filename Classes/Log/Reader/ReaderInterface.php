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
     * @param array $configuration
     */
    public function __construct(array $configuration = []);

    /**
     * @param Filter $filter
     * @return Log[]
     */
    public function findByFilter(Filter $filter);
}
