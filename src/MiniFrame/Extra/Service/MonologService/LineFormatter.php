<?php

namespace MiniFrame\Extra\Service\MonologService;

/**
 * İstek sırasında yazılan log satırlarına numara tanımlamak için kütüphanenin LineFormatter sınıfı genişletilmiştir.
 */
class LineFormatter extends \Monolog\Formatter\LineFormatter
{
    protected $logCounter = 0;

    /**
     * @var string
     */
    protected $reqId = '';

    /**
     * @param array $record
     * @return mixed|string
     */
    public function format(array $record)
    {
        $this->logCounter++;
        $output = parent::format($record);
        $output = str_replace('%counter%', $this->logCounter, $output);
        $output = str_replace('%req-id%', $this->reqId, $output);

        return $output;
    }

    /**
     * @param int $logCounter
     */
    public function setLogCounter($logCounter)
    {
        $this->logCounter = $logCounter;
    }

    /**
     * @param string $reqId
     */
    public function setReqId($reqId)
    {
        $this->reqId = $reqId;
    }
}
