<?php

namespace MiniFrame\ConsoleApplication;

use MiniFrame\Di\IDi;
use Symfony\Component\Console\Command\Command;

abstract class BaseCommand extends Command
{
    /**
     * @return IDi
     */
    public function getDi()
    {
        return $this->getHelperSet()->get('di');
    }
}
