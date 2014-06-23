<?php

namespace MiniFrame\Extra\Service;

use MiniFrame\Extra\Service\MonologService\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\TestHandler;
use Monolog\Logger;

class MonologService extends BaseService
{
    /**
     * @var array
     */
    protected $loggers = array();

    /**
     * @return Logger
     */
    public function getDefaultLogger()
    {
        return $this->getLogger($this->getDi()->getConfigs()->monolog->default_logger);
    }

    /**
     * @param $name
     * @return Logger
     * @throws \Exception
     */
    public function getLogger($name)
    {
        if (!isset($this->loggers[$name])) {
            $handlers = $this->getDi()->getConfigs()->monolog->loggers->{$name}->toArray();
            $logger = new Logger($name);

            foreach ($handlers as $handlerType => $handlerConfigs) {
                $stream = $this->createLoggerHandler($handlerType, (object)$handlerConfigs);
                $logger->pushHandler($stream);
            }

            $this->loggers[$name] = $logger;
        }

        return $this->loggers[$name];
    }

    /**
     * @param $handlerType
     * @param \stdClass $handlerConfigs
     * @return StreamHandler|null
     * @throws \Exception
     */
    public function createLoggerHandler($handlerType, \stdClass $handlerConfigs)
    {
        $stream = null;
        $formatter = new LineFormatter($handlerConfigs->line_format, $handlerConfigs->datetime_format);
        $formatter->setReqId($this->getDi()->getConfigs()->req_id);

        if ($handlerType == 'stream') {
            $filePath = $handlerConfigs->file . '-' . date('Y-m-d') . '.log';
            $stream = new StreamHandler($filePath, $handlerConfigs->level, true, 0666);
        }

        if ($handlerType == 'test') {
            $stream = new TestHandler();
        }

        $stream->setFormatter($formatter);
        return $stream;
    }

    public function clearLoggers()
    {
        foreach ($this->loggers as $name => $value) {
            unset($value);
        }

        $this->loggers = array();
    }
}
