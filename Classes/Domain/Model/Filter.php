<?php
namespace VerteXVaaR\Logs\Domain\Model;

use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class Filter
 */
class Filter
{
    /**
     * @var string
     */
    protected $requestId = '';

    /**
     * @var int
     */
    protected $minimumSeverity = LogLevel::NOTICE;

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
    protected $cropMessage = true;

    /**
     * @var int
     */
    protected $limit = 150;

    /**
     * @var string
     */
    protected $orderField = 'time_micro';

    /**
     * @var string
     */
    protected $orderDirection = 'DESC';

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
    public function getMinimumSeverity()
    {
        return (int)$this->minimumSeverity;
    }

    /**
     * @param int $minimumSeverity
     */
    public function setMinimumSeverity($minimumSeverity)
    {
        $this->minimumSeverity = $minimumSeverity;
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
    public function isCropMessage()
    {
        return $this->cropMessage;
    }

    /**
     * @param boolean $cropMessage
     */
    public function setCropMessage($cropMessage)
    {
        $this->cropMessage = $cropMessage;
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
            'time_micro' => LocalizationUtility::translate('filter.time_micro', 'logs'),
            'request_id' => LocalizationUtility::translate('filter.request_id', 'logs'),
            'component' => LocalizationUtility::translate('filter.component', 'logs'),
        ];
    }

    public function getOrderDirections()
    {
       return [
           'DESC' => LocalizationUtility::translate('filter.desc', 'logs'),
           'ASC' => LocalizationUtility::translate('filter.asc', 'logs'),
       ];

    }
}
