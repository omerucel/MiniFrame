<?php

namespace MiniFrame;

use MiniFrame\Di\IDi;

abstract class BaseApplication
{
    /**
     * @var IDi
     */
    protected $dependencyInjection;

    /**
     * @param IDi $dependencyInjection
     */
    public function __construct(IDi $dependencyInjection)
    {
        $this->dependencyInjection = $dependencyInjection;
    }

    /**
     * @return IDi
     */
    public function getDi()
    {
        return $this->dependencyInjection;
    }

    abstract public function serve();
}
