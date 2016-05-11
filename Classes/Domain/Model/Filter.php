<?php
namespace VerteXVaaR\Logs\Domain\Model;

use TYPO3\CMS\Core\Log\LogLevel;

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
    protected $minimumSeverity = LogLevel::DEBUG;

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
    protected $cropMessage = false;

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
}
