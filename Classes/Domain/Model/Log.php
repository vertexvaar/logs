<?php

namespace CoStack\Logs\Domain\Model;

use TYPO3\CMS\Core\Log\LogLevel;

/**
 * Class Log
 */
class Log
{
    public const FIELD_REQUEST_ID = 'request_id';
    public const FIELD_TIME_MICRO = 'time_micro';
    public const FIELD_COMPONENT = 'component';
    public const FIELD_LEVEL = 'level';
    public const FIELD_MESSAGE = 'message';
    public const FIELD_DATA = 'data';

    /**
     * @var string
     */
    protected $requestId = '';

    /**
     * @var float
     */
    protected $timeMicro = 0.0;

    /**
     * @var string
     */
    protected $component = '';

    /**
     * @var int
     */
    protected $level = 0;

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Log constructor.
     *
     * @param string $requestId
     * @param float $timeMicro
     * @param string $component
     * @param int $level
     * @param string $message
     * @param array $data
     */
    public function __construct(
        string $requestId,
        float $timeMicro,
        string $component,
        int $level,
        string $message,
        array $data
    ) {
        $this->requestId = $requestId;
        $this->timeMicro = $timeMicro;
        $this->component = $component;
        $this->level = $level;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * @param string $requestId
     */
    public function setRequestId(string $requestId)
    {
        $this->requestId = $requestId;
    }

    /**
     * @return float
     */
    public function getTimeMicro(): float
    {
        return $this->timeMicro;
    }

    /**
     * @param float $timeMicro
     */
    public function setTimeMicro(float $timeMicro)
    {
        $this->timeMicro = $timeMicro;
    }

    /**
     * @return string
     */
    public function getComponent(): string
    {
        return $this->component;
    }

    /**
     * @param string $component
     */
    public function setComponent(string $component)
    {
        $this->component = $component;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getReadableLevel(): string
    {
        return LogLevel::getName($this->level);
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level)
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }
}
