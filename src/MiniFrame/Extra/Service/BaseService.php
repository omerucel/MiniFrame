<?php

namespace MiniFrame\Extra\Service;

use MiniFrame\Di\IDi;

abstract class BaseService
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
}
