<?php
namespace VerteXVaaR\Logs\Domain\Model;

class Log
{
    protected $requestId = '';

    protected $timeMicro = 0.0;

    protected $component = '';

    protected $level = 0;

    protected $message = '';

    protected $data = [];

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

    public function getRequestId(): string
    {
        return $this->requestId;
    }

    public function setRequestId(string $requestId)
    {
        $this->requestId = $requestId;
    }

    public function getTimeMicro(): float
    {
        return $this->timeMicro;
    }

    public function setTimeMicro(float $timeMicro)
    {
        $this->timeMicro = $timeMicro;
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    public function setComponent(string $component)
    {
        $this->component = $component;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level)
    {
        $this->level = $level;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }
}
