<?php
namespace VerteXVaaR\Logs\Log;

use VerteXVaaR\Logs\Log\Reader\ReaderInterface;

/**
 * Class ReaderCollection
 */
class ConjunctionReader implements ReaderInterface
{
    /**
     * ReaderCollection constructor.
     *
     * @param array $configuration
     */
    public function __construct(array $configuration = [])
    {
    }

    /**
     * @var ReaderInterface[]
     */
    protected $readers = [];

    /**
     * @return Reader\ReaderInterface[]
     */
    public function getReaders()
    {
        return $this->readers;
    }

    /**
     * @param Reader\ReaderInterface[] $readers
     */
    public function setReaders(array $readers)
    {
        $this->readers = $readers;
    }

    /**
     * @param Reader\ReaderInterface[] $readers
     */
    public function addReaders($readers)
    {
        foreach ($readers as $reader) {
            $this->addReader($reader);
        }
    }

    /**
     * @param ReaderInterface $reader
     */
    public function addReader(ReaderInterface $reader)
    {
        $this->readers[] = $reader;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $logs = [];
        foreach ($this->readers as $reader) {
            $logs = array_merge($logs, $reader->findAll());
        }
        return $logs;
    }
}
