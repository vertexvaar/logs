<?php

namespace CoStack\Logs\Domain\Model;

use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

use function array_keys;
use function in_array;

/**
 * Class Filter
 */
class Filter
{
    public const SORTING_DESC = 'DESC';
    public const SORTING_ASC = 'ASC';

    /**
     * @var string
     */
    protected $requestId = '';

    /**
     * @var string
     */
    protected $level = LogLevel::NOTICE;

    /**
     * @var int|null
     */
    protected $fromTime;

    /**
     * @var int|null
     */
    protected $toTime;

    /**
     * @var bool
     */
    protected $showData = false;

    /**
     * @var string
     */
    protected $component = '';

    /**
     * @var bool
     */
    protected $fullMessage = true;

    /**
     * @var int
     */
    protected $limit = 150;

    /**
     * @var string
     */
    protected $orderField = Log::FIELD_TIME_MICRO;

    /**
     * @var string
     */
    protected $orderDirection = self::SORTING_DESC;

    public function getRequestId(): string
    {
        return $this->requestId;
    }

    public function setRequestId(string $requestId): void
    {
        $this->requestId = $requestId;
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    public function setLevel(string $level): void
    {
        $this->level = $level;
    }

    public function getFromTime(): ?int
    {
        return $this->fromTime;
    }

    public function setFromTime(int $fromTime = null): void
    {
        $this->fromTime = $fromTime;
    }

    public function getToTime(): ?int
    {
        return $this->toTime;
    }

    public function setToTime(int $toTime = null): void
    {
        $this->toTime = $toTime;
    }

    public function isShowData(): bool
    {
        return $this->showData;
    }

    public function setShowData(bool $showData): void
    {
        $this->showData = $showData;
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    public function setComponent(string $component): void
    {
        $this->component = $component;
    }

    public function isFullMessage(): bool
    {
        return $this->fullMessage;
    }

    public function setFullMessage(bool $fullMessage): void
    {
        $this->fullMessage = $fullMessage;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function getOrderField(): string
    {
        return $this->orderField;
    }

    public function setOrderField(string $orderField): void
    {
        if (in_array($orderField, array_keys($this->getOrderFields()))) {
            $this->orderField = $orderField;
        }
    }

    public function getOrderDirection(): string
    {
        return $this->orderDirection;
    }

    public function setOrderDirection(string $orderDirection): void
    {
        $this->orderDirection = $orderDirection;
    }

    public function getLogLevels(): array
    {
        return [
            LogLevel::EMERGENCY => LogLevel::EMERGENCY . ' (' . \Psr\Log\LogLevel::EMERGENCY . ')',
            LogLevel::ALERT => LogLevel::ALERT . ' (' . \Psr\Log\LogLevel::ALERT . ')',
            LogLevel::CRITICAL => LogLevel::CRITICAL . ' (' . \Psr\Log\LogLevel::CRITICAL . ')',
            LogLevel::ERROR => LogLevel::ERROR . ' (' . \Psr\Log\LogLevel::ERROR . ')',
            LogLevel::WARNING => LogLevel::WARNING . ' (' . \Psr\Log\LogLevel::WARNING . ')',
            LogLevel::NOTICE => LogLevel::NOTICE . ' (' . \Psr\Log\LogLevel::NOTICE . ')',
            LogLevel::INFO => LogLevel::INFO . ' (' . \Psr\Log\LogLevel::INFO . ')',
            LogLevel::DEBUG => LogLevel::DEBUG . ' (' . \Psr\Log\LogLevel::DEBUG . ')',
        ];
    }

    public function getOrderFields(): array
    {
        return [
            Log::FIELD_TIME_MICRO => LocalizationUtility::translate('filter.time_micro', 'logs'),
            Log::FIELD_REQUEST_ID => LocalizationUtility::translate('filter.request_id', 'logs'),
            Log::FIELD_COMPONENT => LocalizationUtility::translate('filter.component', 'logs'),
            Log::FIELD_LEVEL => LocalizationUtility::translate('filter.level', 'logs'),
        ];
    }

    public function getOrderDirections(): array
    {
        return [
            static::SORTING_DESC => LocalizationUtility::translate('filter.desc', 'logs'),
            static::SORTING_ASC => LocalizationUtility::translate('filter.asc', 'logs'),
        ];
    }
}
