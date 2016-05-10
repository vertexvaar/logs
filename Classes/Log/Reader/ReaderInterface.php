<?php
namespace VerteXVaaR\Logs\Log\Reader;

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
     * @return Log[]
     */
    public function findAll();
}
