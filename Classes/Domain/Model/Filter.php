<?php
namespace VerteXVaaR\Logs\Domain\Model;

use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class Filter
 */
class Filter
{
    const SORTING_DESC = 'DESC';
    const SORTING_ASC = 'ASC';
    const ORDER_TIME_MICRO = 'time_micro';
    const ORDER_REQUEST_ID = 'request_id';
    const ORDER_COMPONENT = 'component';
    const ORDER_LEVEL = 'level';

    /**
     * @var string
     */
    protected $requestId = '';

    /**
     * @var int
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
    protected $orderField = self::ORDER_TIME_MICRO;

    /**
     * @var string
     */
    protected $orderDirection = self::SORTING_DESC;

    /**
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @param string $requestId
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return (int)$this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getFromTime()
    {
        return $this->fromTime;
    }

    /**
     * @param int $fromTime
     */
    public function setFromTime($fromTime)
    {
        $this->fromTime = $fromTime;
    }

    /**
     * @return int
     */
    public function getToTime()
    {
        return $this->toTime;
    }

    /**
     * @param int $toTime
     */
    public function setToTime($toTime)
    {
        $this->toTime = $toTime;
    }

    /**
     * @return boolean
     */
    public function isShowData()
    {
        return $this->showData;
    }

    /**
     * @param boolean $showData
     */
    public function setShowData($showData)
    {
        $this->showData = $showData;
    }

    /**
     * @return string
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * @param string $component
     */
    public function setComponent($component)
    {
        $this->component = $component;
    }

    /**
     * @return boolean
     */
    public function isFullMessage()
    {
        return $this->fullMessage;
    }

    /**
     * @param boolean $fullMessage
     */
    public function setFullMessage($fullMessage)
    {
        $this->fullMessage = $fullMessage;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return string
     */
    public function getOrderField()
    {
        return $this->orderField;
    }

    /**
     * @param string $orderField
     */
    public function setOrderField($orderField)
    {
        $this->orderField = $orderField;
    }

    /**
     * @return string
     */
    public function getOrderDirection()
    {
        return $this->orderDirection;
    }

    /**
     * @param string $orderDirection
     */
    public function setOrderDirection($orderDirection)
    {
        $this->orderDirection = $orderDirection;
    }

    /**
     * @return array
     */
    public function getLogLevels()
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
    public function getOrderFields()
    {
        return [
            static::ORDER_TIME_MICRO => LocalizationUtility::translate('filter.time_micro', 'logs'),
            static::ORDER_REQUEST_ID => LocalizationUtility::translate('filter.request_id', 'logs'),
            static::ORDER_COMPONENT => LocalizationUtility::translate('filter.component', 'logs'),
            static::ORDER_LEVEL => LocalizationUtility::translate('filter.level', 'logs'),
        ];
    }

    /**
     * @return array
     */
    public function getOrderDirections()
    {
        return [
            static::SORTING_DESC => LocalizationUtility::translate('filter.desc', 'logs'),
            static::SORTING_ASC => LocalizationUtility::translate('filter.asc', 'logs'),
        ];
    }
}
