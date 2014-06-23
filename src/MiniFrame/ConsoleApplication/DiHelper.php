<?php

namespace MiniFrame\ConsoleApplication;

use MiniFrame\Di\IDi;
use Symfony\Component\Console\Helper\Helper;

class DiHelper extends Helper
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

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     *
     * @api
     */
    public function getName()
    {
        return 'di';
    }
}
