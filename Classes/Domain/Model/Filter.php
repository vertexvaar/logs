<?php
namespace VerteXVaaR\Logs\Domain\Model;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use function get_object_vars;

class Filter
{
    const SORTING_DESC = 'DESC';
    const SORTING_ASC = 'ASC';
    const ORDER_TIME_MICRO = 'time_micro';
    const ORDER_REQUEST_ID = 'request_id';
    const ORDER_COMPONENT = 'component';
    const ORDER_LEVEL = 'level';

    protected $requestId = '';

    protected $level = LogLevel::NOTICE;

    protected $fromTime = 0;

    protected $toTime = 0;

    protected $showData = false;

    protected $component = '';

    protected $fullMessage = true;

    protected $limit = 150;

    protected $orderField = self::ORDER_TIME_MICRO;

    protected $orderDirection = self::SORTING_DESC;

    public function __construct(bool $loadFromSession = true)
    {
        if (true === $loadFromSession) {
            $this->loadFromSession();
        }
    }

    public function getRequestId(): string
    {
        return $this->requestId;
    }

    public function setRequestId(string $requestId)
    {
        $this->requestId = $requestId;
    }

    public function getLevel(): int
    {
        return (int)$this->level;
    }

    public function setLevel(int $level)
    {
        $this->level = $level;
    }

    public function getFromTime(): int
    {
        return $this->fromTime;
    }

    public function setFromTime(int $fromTime)
    {
        $this->fromTime = $fromTime;
    }

    public function getToTime(): int
    {
        return $this->toTime;
    }

    public function setToTime(int $toTime)
    {
        $this->toTime = $toTime;
    }

    public function isShowData(): bool
    {
        return $this->showData;
    }

    public function setShowData(bool $showData)
    {
        $this->showData = $showData;
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    public function setComponent(string $component)
    {
        $this->component = $component;
    }

    public function isFullMessage(): bool
    {
        return $this->fullMessage;
    }

    public function setFullMessage(bool $fullMessage)
    {
        $this->fullMessage = $fullMessage;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }

    public function getOrderField(): string
    {
        return $this->orderField;
    }

    public function setOrderField(string $orderField)
    {
        $this->orderField = $orderField;
    }

    public function getOrderDirection(): string
    {
        return $this->orderDirection;
    }

    public function setOrderDirection(string $orderDirection)
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
            static::ORDER_TIME_MICRO => LocalizationUtility::translate('filter.time_micro', 'logs'),
            static::ORDER_REQUEST_ID => LocalizationUtility::translate('filter.request_id', 'logs'),
            static::ORDER_COMPONENT => LocalizationUtility::translate('filter.component', 'logs'),
            static::ORDER_LEVEL => LocalizationUtility::translate('filter.level', 'logs'),
        ];
    }

    public function getOrderDirections(): array
    {
        return [
            static::SORTING_DESC => LocalizationUtility::translate('filter.desc', 'logs'),
            static::SORTING_ASC => LocalizationUtility::translate('filter.asc', 'logs'),
        ];
    }

    public function saveToSession()
    {
        $this->getBackendUser()->setAndSaveSessionData('tx_logs_filter', $this);
    }

    public function loadFromSession()
    {
        $filter = $this->getBackendUser()->getSessionData('tx_logs_filter');
        if ($filter instanceof Filter) {
            foreach (get_object_vars($filter) as $name => $value) {
                $this->{$name} = $value;
            }
        }
    }

    /**
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
