<?php

namespace CoStack\Logs\Domain\Model;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

use function array_keys;
use function get_object_vars;
use function in_array;
use function ucfirst;

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
     * @var int
     */
    protected $fromTime = 0;

    /**
     * @var int
     */
    protected $toTime = 0;

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

    /**
     * Filter constructor.
     *
     * @param bool $loadFromSession
     */
    public function __construct(bool $loadFromSession = true)
    {
        if (true === $loadFromSession) {
            $this->loadFromSession();
        }
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
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @param string $level
     */
    public function setLevel(string $level)
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getFromTime(): ?int
    {
        return $this->fromTime;
    }

    /**
     * @param int $fromTime
     */
    public function setFromTime(int $fromTime = null)
    {
        $this->fromTime = $fromTime;
    }

    /**
     * @return int
     */
    public function getToTime(): ?int
    {
        return $this->toTime;
    }

    /**
     * @param int $toTime
     */
    public function setToTime(int $toTime = null)
    {
        $this->toTime = $toTime;
    }

    /**
     * @return bool
     */
    public function isShowData(): bool
    {
        return $this->showData;
    }

    /**
     * @param bool $showData
     */
    public function setShowData(bool $showData)
    {
        $this->showData = $showData;
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
     * @return bool
     */
    public function isFullMessage(): bool
    {
        return $this->fullMessage;
    }

    /**
     * @param bool $fullMessage
     */
    public function setFullMessage(bool $fullMessage)
    {
        $this->fullMessage = $fullMessage;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return string
     */
    public function getOrderField(): string
    {
        return $this->orderField;
    }

    /**
     * @param string $orderField
     */
    public function setOrderField(string $orderField)
    {
        if (in_array($orderField, array_keys($this->getOrderFields()))) {
            $this->orderField = $orderField;
        }
    }

    /**
     * @return string
     */
    public function getOrderDirection(): string
    {
        return $this->orderDirection;
    }

    /**
     * @param string $orderDirection
     */
    public function setOrderDirection(string $orderDirection)
    {
        $this->orderDirection = $orderDirection;
    }

    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public function getOrderFields(): array
    {
        return [
            Log::FIELD_TIME_MICRO => LocalizationUtility::translate('filter.time_micro', 'logs'),
            Log::FIELD_REQUEST_ID => LocalizationUtility::translate('filter.request_id', 'logs'),
            Log::FIELD_COMPONENT => LocalizationUtility::translate('filter.component', 'logs'),
            Log::FIELD_LEVEL => LocalizationUtility::translate('filter.level', 'logs'),
        ];
    }

    /**
     * @return array
     */
    public function getOrderDirections(): array
    {
        return [
            static::SORTING_DESC => LocalizationUtility::translate('filter.desc', 'logs'),
            static::SORTING_ASC => LocalizationUtility::translate('filter.asc', 'logs'),
        ];
    }

    /**
     *
     */
    public function saveToSession()
    {
        $this->getBackendUser()->setAndSaveSessionData('tx_logs_filter', $this);
    }

    /**
     *
     */
    public function loadFromSession()
    {
        $filter = $this->getBackendUser()->getSessionData('tx_logs_filter');
        if ($filter instanceof Filter) {
            foreach (get_object_vars($filter) as $name => $value) {
                $this->{'set' . ucfirst($name)} = $value;
            }
        }
    }

    /**
     * @return BackendUserAuthentication
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
