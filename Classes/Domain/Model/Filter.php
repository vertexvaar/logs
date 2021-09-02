<?php

declare(strict_types=1);

namespace CoStack\Logs\Domain\Model;

use Psr\Log\LogLevel;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
        if (array_key_exists($orderField, $this->getOrderFields())) {
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
            LogLevel::EMERGENCY => '0 - ' . LogLevel::EMERGENCY,
            LogLevel::ALERT => '1 - ' . LogLevel::ALERT,
            LogLevel::CRITICAL => '2 - ' . LogLevel::CRITICAL,
            LogLevel::ERROR => '3 - ' . LogLevel::ERROR,
            LogLevel::WARNING => '4 - ' . LogLevel::WARNING,
            LogLevel::NOTICE => '5 - ' . LogLevel::NOTICE,
            LogLevel::INFO => '6 - ' . LogLevel::INFO,
            LogLevel::DEBUG => '7 - ' . LogLevel::DEBUG,
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
